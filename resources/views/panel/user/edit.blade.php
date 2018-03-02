@extends('layouts.panel')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">Configurações</div>

  <div class="panel-body">
    <form method="POST" action="{{ url('panel/settings') }}">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <p>Você pode definir uma página para redirecionar seu cliente após o pagamento.</p>
      <div class="row">
        <div class="col-md-10">
          <div class="form-group{{ $errors->has('redirect_url') ? ' has-error' : '' }}">
            <label for="redirect_url" class="control-label">Página de redirecionamento</label>
            <input id="redirect_url" type="text" class="form-control url" name="redirect_url" value="{{ old('redirect_url', $user->redirect_url) }}" required>
            @if ($errors->has('redirect_url'))
              <span class="help-block">
                <strong>{{ $errors->first('redirect_url') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>

      <p>Seu sistema será avisado sempre que uma transação mudar de estado.</p>
      <div class="row">
        <div class="col-md-10">
          <div class="form-group{{ $errors->has('notification_url') ? ' has-error' : '' }}">
            <label for="notification_url" class="control-label">Notificação de transação</label>
            <input id="notification_url" type="text" class="form-control url" name="notification_url" value="{{ old('notification_url', $user->notification_url) }}">
            @if ($errors->has('notification_url'))
              <span class="help-block">
                <strong>{{ $errors->first('notification_url') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Salvar Configurações</button>
    </form>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Token</div>

  <div class="panel-body">
    <form method="POST" action="{{ url('panel/settings/token') }}" id="form-token">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="alert alert-default{{ $user->token ? '' : ' hide' }}">
        <div id="message1"><b>Seu token já foi gerado. Por questão de segurança ele não é exibido.</b></div>
        <div id="message3"><a href="">[Enviar por e-mail]</a></div>
      </div>
      <div class="alert alert-warning{{ $user->token ? ' hide' : '' }}">É necessário gerar um token para poder utilizar a API.</div>

      <button type="submit" class="btn btn-primary">Gerar Novo Token</button>
    </form>
  </div>
</div>
@endsection
