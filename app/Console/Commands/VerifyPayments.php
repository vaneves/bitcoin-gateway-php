<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services\PaymentService;

class VerifyPayments extends Command
{
    protected $signature = 'payment:verify';

    protected $description = 'Check payments';

    protected $service;

    public function __construct(PaymentService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        $this->service->verify();
    }
}
