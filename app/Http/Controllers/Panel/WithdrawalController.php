<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    public function __construct(WithdrawalService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $withdrawals = $this->service->list(\Auth::id());
        return view('panel.withdrawal.index')->withWithdrawals($withdrawals);
    }
}