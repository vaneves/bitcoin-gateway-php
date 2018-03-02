<?php 

namespace App\Models\Services;

use App\Models\Entities\User;
use App\Models\Entities\Notification;
use App\Models\Entities\NotificationHistory;
use App\Models\Enum\NotificationStatus;
use Illuminate\Support\Facades\Log;

class NotificationService extends AppService
{
    public function send()
    {
        $notifications = Notification::where('status', NotificationStatus::CREATED)
            ->orWhere(function ($query) {
                $query->where('status', NotificationStatus::SENT)
                      ->where('attempt', '<', 5);
            })
            ->with('invoice.user')
            ->orderBy('id')
            ->cursor();

        foreach ($notifications as $notification) {
            $this->notify($notification);
        }
    }

    private function notify(Notification $notification)
    {
        try {
            $notification->status = NotificationStatus::SENT;
            $notification->attempt += 1;
            $notification->save();

            $url = $notification->invoice->notification_url;
            if (!$url) {
                $url = $notification->invoice->user->notification_url;
            }

            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'form_params' => [
                    'code' => $notification->code
                ]
            ]);
            $history = NotificationHistory::create([
                'notification_id' => $notification->id,
                'code' => $response->getStatusCode(),
            ]);
        } catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getInvoiceByCode(User $user, $code)
    {
        $notification = Notification::where('code', $code)->with('invoice.payments')->first();
        if (!$notification) {
            throw new \ValidationException('Code not found');
        }
        if ($notification->invoice->user_id != $user->id) {
            throw new \ValidationException('Code not found');
        }
        
        $notification->status = NotificationStatus::RECEIVED;
        $notification->save();

        return $notification->invoice;
    }
}