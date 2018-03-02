@extends('layouts.panel')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">Minha Conta</div>

  <div class="panel-body">
    <div>
      <div class="form-group">
        <label class="control-label">Nome Completo</label>
        <p class="form-control-static">{{ $user->name }}</p>
      </div>

      <div class="form-group">
        <label class="control-label">Endereço de E-mail</label>
        <p class="form-control-static">{{ $user->email }}</p>
      </div>

      <div class="form-group">
        <label class="control-label">Endereço Bitcoin para Saque</label>
        <p class="form-control-static">{{ $user->withdrawal_address ? $user->withdrawal_address : 'Não definido' }}</p>
      </div>

      <div class="form-group">
        <label class="control-label">URL Padrão para Notificações</label>
        <p class="form-control-static">{{ $user->notification_url ? $user->notification_url : 'Não definido' }}</p>
      </div>
    </div>
  </div>
</div>
@endsection
