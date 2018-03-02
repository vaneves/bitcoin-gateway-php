<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\User;
use App\Models\Services\InvoiceService;

class InvoiceController extends Controller
{
    private $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function checkout(User $user, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'reference' => 'required|min:1|max:64',
            'buyer.name' => 'required|min:8|max:128',
            'buyer.email' => 'required|email|max:128',
            'items' => 'required|array',
            'items.*.name' => 'required|max:64',
            'items.*.amount' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.0000001',
        ]);
        if ($validator->fails()) {
            throw new \ValidationException($validator->errors()->all());
        }
        $invoice = $this->service->checkout($user, $request->all());
        return response()->json($invoice);
    }

    public function transactions(User $user, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'page' => 'required|integer|min:1',
            'max' => 'required|integer|between:10,500',
        ]);
        if ($validator->fails()) {
            throw new \ValidationException($validator->errors()->all());
        }
        $invoices = $this->service->search($user->id, $request->start_date, $request->end_date, $request->page, $request->max);
        return response()->json($invoices);
    }

    public function transaction($code)
    {
        $invoice = $this->service->getByCode($code);
        return response()->json($invoice);
    }
}
