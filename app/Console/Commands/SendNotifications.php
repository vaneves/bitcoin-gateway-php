<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services\NotificationService;

class SendNotifications extends Command
{
    protected $signature = 'notify';

    protected $description = 'Send notifications';

    protected $service;

    public function __construct(NotificationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        $this->service->send();
    }
}
