<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\InvoiceService;

use App\Models\Enum\InvoiceStatus;

class InvoiceController extends Controller
{
    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $statuses = [];
        foreach (InvoiceStatus::TEXTS as $key => $text) {
            array_push($statuses, [
                'key' => $key,
                'text' => $text,
            ]);
        }
        $data = $request->all();
        $invoices = $this->service->advancedSearch(\Auth::id(), $data);
        return view('panel.invoice.index')->withInvoices($invoices)
                ->withData($data)
                ->withStatuses($statuses);
    }

    public function view($code)
    {
        $invoice = $this->service->getByCode($code);
        if (!$invoice || $invoice->user_id != \Auth::id()) {
            throw new \AppException('Transação não encontrada', 404);
        }
        return view('panel.invoice.view')->withInvoice($invoice);
    }
}
