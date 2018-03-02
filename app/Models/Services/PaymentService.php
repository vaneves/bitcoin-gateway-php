<?php 

namespace App\Models\Services;

use Vaneves\Bitcoin\Bitcoin;
use App\Models\Entities\Invoice;
use App\Models\Entities\Payment;
use App\Models\Entities\Notification;
use App\Models\Enum\InvoiceStatus;
use App\Models\Enum\NotificationStatus;
use App\Common\Generator;

class PaymentService extends AppService
{
    private $bitcoin;

    public function __construct(Bitcoin $bitcoin)
    {
        $this->bitcoin = $bitcoin;
    }

    public function verify()
    {
        $confirmations = 1;
        $index = (int)Payment::max('index');
        do {
            $transactions = $this->bitcoin->transaction()->paginate($index, 100);
            foreach ($transactions as $i => $transaction) {
                if ($transaction['category'] == 'receive') {
                    if ($transaction['confirmations'] < $confirmations) {
                        return;
                    }
                    $invoice = Invoice::where('address', $transaction['address'])->first();
                    if ($invoice) {
                        $this->save($invoice, $transaction, $index);
                    }
                }
                $index++;
            }
        } while (count($transactions) > 0);
    }

    private function save(Invoice $invoice, $transaction, $index)
    {
        return \DB::transaction(function () use ($invoice, $transaction, $index) {
            $amount = $invoice->payments()->sum('value') + $transaction['amount'];
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'block' => $transaction['blockhash'],
                'txid' => $transaction['txid'],
                'value' => $transaction['amount'],
                'received_at' => date('Y-m-d H:i:s', $transaction['timereceived']),
                'index' => $index,
            ]);

            if (in_array($invoice->status, [InvoiceStatus::WAITING, InvoiceStatus::INCOMPLETE])) {
                $invoice->status = InvoiceStatus::INCOMPLETE;
                if ($amount >= $invoice->total) {
                    $invoice->status = InvoiceStatus::PAID;
                }
                $invoice->save();
                $notification = Notification::create([
                    'invoice_id' => $invoice->id,
                    'code' => Generator::guid('notify'),
                    'status' => NotificationStatus::CREATED,
                ]);
            }
            return $payment;
        });
    }
}