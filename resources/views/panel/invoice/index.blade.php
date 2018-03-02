@extends('layouts.panel')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">Extrato de Pagamentos</div>
  <div class="panel-body">
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif
    <div class="panel panel-default">
      <div class="panel-body">
        <form method="get" action="" id="filter" class="form-float">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="start" class="control-label">Início</label>
                <input type="text" id="start" class="form-control date" name="start" placeholder="Início" value="{{ get('start') }}">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="end" class="control-label">Término</label>
                <input type="text" id="end" class="form-control date" name="end" placeholder="Término" value="{{ get('end') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="name" class="control-label">Nome</label>
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome" value="{{ get('name') }}">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="email" class="control-label">E-mail</label>
                <input type="email" id="email" class="form-control" name="email" placeholder="E-mail" value="{{ get('email') }}">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="static-label">Status</label>
            <div>
              @foreach ($statuses as $status)
              <label class="checkbox-inline">
                <input type="checkbox" name="status[{{ $status['key'] }}]" {{ isset($_GET['status'][$status['key']]) ? 'checked' : '' }} value="{{ $status['key'] }}">
                <span class="checked"></span>
                {{ $status['text'] }}
              </label>
              @endforeach
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
      </div>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Data</th>
          <th>Nome</th>
          <th>Status</th>
          <th>Valor</th>
          <th style="width: 60px;">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($invoices as $invoice)
        <tr>
          <td>{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $invoice->buyer_name }}</td>
          <td>{{ $invoice->status_text }}</td>
          <td>{{ $invoice->total_text }}</td>
          <td>
            <a href="{{ url('panel/transaction/'. $invoice->code) }}" class="btn btn-default btn-xs">
              <span class="fa fa-arrow-right" aria-hidden="true"></span>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5">Nenhum resultado encontrado.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{ $invoices->appends($data)->links() }}
  </div>
</div>
@endsection
