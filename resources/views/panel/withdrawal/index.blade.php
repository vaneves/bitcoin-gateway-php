@extends('layouts.panel')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">Solicitações de Saque</div>
  <div class="panel-body">
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Data</th>
          <th>Valor</th>
          <th>Status</th>
          <th style="width: 60px;">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($withdrawals as $withdrawal)
        <tr>
          <td>{{ $withdrawal->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $withdrawal->value_text }}</td>
          <td>{{ $withdrawal->status_text }}</td>
          <td>
            <a href="{{ url('panel/withdrawal/'. $withdrawal->id) }}" class="btn btn-default btn-xs">
              <span class="fa fa-arrow-right" aria-hidden="true"></span>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4">Nenhum resultado encontrado.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{ $withdrawals->links() }}
  </div>
</div>
@endsection
