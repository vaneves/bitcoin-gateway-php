@extends('layouts.checkout')

@section('content')
<div class="panel panel-default panel-free">
  <div class="panel-heading">Pagamento</div>
  <div class="panel-body">
    <div class="checkout">
      @if ($invoice->isPaid())
      <div class="paid">
        <div class="alert alert-success">
          Esta fatura já foi paga!
        </div>
      </div>
      @elseif ($invoice->isExpired())
      <div class="expired">
        <div class="alert alert-warning">
          Esta fatura expirou!
        </div>
      </div>
      @else
      <div class="toggle-items hidden-md hidden-lg">
        <span class="text">Exibir resumo da compra</span>
        <div class="price">{{ $invoice->total_text }}</div>
      </div>
      <div class="items hidden-sm hidden-xs">
        <table class="table">
          <thead>
            <tr>
              <th>Descrição</th>
              <th style="width: 20px;">&nbsp;</th>
              <th style="width: 120px; text-align: center;">Valor</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoice->items as $item)
            <tr class="item">
              <td>
                <div class="name">{{ $item->name }}</div>
                <div class="amount">Quantidade: {{ $item->amount }}</div>
                <div class="price">Valor do Item: {{ $item->price_text }}</div>
              </td>
              <td>&nbsp;</td>
              <td class="subtotal">{{ $item->total_text }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Total</th>
              <th colspan="2" class="total">{{ $invoice->total_text }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="info">
        <p>Olá, <b>{{ $invoice->buyer_name }}</b>, </p>
        <p>Para efetuar o pagamento, você deve transferir <b>{{ $invoice->total_text }}</b> para o endereço:</p>
        <div class="address">
          {{ $invoice->address }}
        </div>
        <div class="qrcode">
          {!! QrCode::size(260)->generate($invoice->address); !!}
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
