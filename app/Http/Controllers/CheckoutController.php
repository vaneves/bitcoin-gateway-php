<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services\InvoiceService;

class CheckoutController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function view($code)
    {
        $invoice = $this->service->getByCode($code);
        return view('checkout.view')->withInvoice($invoice);
    }
}
