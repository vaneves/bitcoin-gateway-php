@extends('layouts.panel')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">Detalhes da Transação</div>
  <table class="table">
    <tbody>
      <tr>
        <th scope="row">Status</th>
        <td>{{ $invoice->status_text }}</td>
      </tr>
      <tr>
        <th scope="row">Código da Transação</th>
        <td>{{ $invoice->code }}</td>
      </tr>
      <tr>
        <th scope="row">Código de Referência</th>
        <td>{{ $invoice->reference }}</td>
      </tr>
      <tr>
        <th scope="row">Valor</th>
        <td>{{ $invoice->total_text }}</td>
      </tr>
      <tr>
        <th scope="row">Taxa</th>
        <td><span class="text-danger">{{ $invoice->fee_text }}</span></td>
      </tr>
      <tr>
        <th scope="row">Total (Líquido)</th>
        <td>{{ $invoice->net_value_text }}</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Itens da Compra</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Valor</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoice->items as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->amount }}</td>
          <td>{{ $item->price_text }}</td>
          <td>{{ $item->total_text }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Extrato de Pagamentos</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Data</th>
          <th>Transação Bitcoin</th>
          <th>Valor</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($invoice->payments as $payment)
        <tr>
          <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
          <td><a href="{{ $blockchain_info . $payment->txid }}" target="_blank">{{ $payment->txid }}</a></td>
          <td>{{ $payment->value_text }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3">Nenhum pagamento encontrado</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Histórico de Alteração de Status</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width: 220px;">Data</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoice->statusHistories as $history)
        <tr>
          <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $history->status_text }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Histórico de Notificações</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width: 220px;">Data</th>
          <th>Tentativas</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($invoice->notifications as $notification)
        <tr>
          <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $notification->attempt }}</td>
          <td>{{ $notification->status_text }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3">Não houve alteração de status ainda</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
