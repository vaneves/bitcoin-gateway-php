<?php 

namespace App\Models\Services;

use App\Models\Entities\User;
use App\Models\Entities\Item;
use App\Models\Entities\Invoice;
use App\Models\Enum\InvoiceStatus;
use Vaneves\Bitcoin\Bitcoin;
use App\Common\Generator;
use App\Common\DateTime;
use App\Common\Money;

class InvoiceService extends AppService
{
    private $bitcoin;

    public function __construct(Bitcoin $bitcoin)
    {
        $this->bitcoin = $bitcoin;
    }

    public function checkout(User $user, $data)
    {
        if (!$user->notification_url && (!isset($data['notification_url']) || !$data['notification_url'])) {
            throw new \ValidationException(['O campo notification_url é obrigatório']);
        }

        $invoice = \DB::transaction(function () use ($user, $data) {

            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['amount'];
            }
            if ($total < env('MIN_PRICE')) {
                throw new \ValidationException(['O valor total da compra deve ser no mínimo '. env('MIN_PRICE') .'.']);
            }
            $address = $this->bitcoin->account(config('bitcoin.account'))->newAddress();
        
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'code' => Generator::guid('invoice'),
                'address' => $address,
                'reference' => $data['reference'],
                'total' => $total,
                'fee' => Money::calculateFee($total),
                'notification_url' => $data['notification_url'] ?? $user->notification_url,
                'buyer_name' => $data['buyer']['name'],
                'buyer_email' => $data['buyer']['email'],
                'status' => InvoiceStatus::WAITING,
            ]);

            foreach ($data['items'] as $item) {
                Item::create([
                    'invoice_id' => $invoice->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                ]);
            }

            return $invoice;
        });

        return [
            'code' => $invoice->code,
            'status' => $invoice->status,
            'created_at' => $invoice->created_at->format('Y-m-d H:i:s'),
            'payment_url' => env('APP_URL') . 'checkout/'. $invoice->code,
        ];
    }

    public function search($user_id, $start, $end, $page, $max)
    {
        $page -= 1;
        $query = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end);

        $count = $query->count();
        $invoices = $query->with('payments')
            ->skip($max * $page)
            ->take($max)
            ->orderBy('created_at')
            ->get();

        return [
            'current_page' => $page + 1,
            'total_pages' => ceil($count / $max),
            'transactions' => $invoices,
        ];
    }

    public function advancedSearch($user_id, $data)
    {
        $start = $data['start'] ?? null;
        if ($start) {
            $start = DateTime::fromFormat('d/m/Y', $start)->toStart();
        }
        $end = $data['end'] ?? null;
        if ($end) {
            $end = DateTime::fromFormat('d/m/Y', $end)->toEnd();
        }
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $status = $data['status'] ?? null;

        $invoices = Invoice::where('user_id', $user_id);

        if ($start) {
            $invoices->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $invoices->whereDate('created_at', '<=', $end);
        }
        if ($name) {
            $invoices->where('buyer_name', 'LIKE', '%'. $name .'%');
        }
        if ($email) {
            $invoices->where('buyer_email', 'LIKE', '%'. $email .'%');
        }
        if ($status) {
            $invoices->whereIn('status', $status);
        }

        return $invoices->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getByCode($code)
    {
        $invoice = Invoice::with('payments')->where('code', $code)->first();
        if (!$invoice) {
            throw new \AppException('Transação não encontrada', 404);
        }
        return $invoice;
    }
}