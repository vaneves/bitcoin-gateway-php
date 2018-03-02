<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\User;
use App\Models\Services\NotificationService;

class NotificationController extends Controller
{
    private $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function check(User $user, $code)
    {
        $invoice = $this->service->getInvoiceByCode($user, $code);
        return response()->json($invoice);
    }
}
