@extends('layouts.master')

@section('template')
@component('layouts.navbar')
@endcomponent
<div class="container">
  <div class="row">
    @if (Auth::guest())
    <div class="col-sm-12">
      @yield('content')
    </div>
    @else
    <div class="col-sm-3">
      <div class="panel panel-default">
        <div class="panel-heading">Menu</div>
        <ul class="list-group">
          <li class="list-group-item"><a href="{{ url('panel') }}">Extrato de Pagamentos</a></li>
          <li class="list-group-item"><a href="{{ url('panel/withdrawal') }}">Solicitações Repasses</a></li>
          <li class="list-group-item"><a href="{{ url('panel/account') }}">Minha Conta</a></li>
          <li class="list-group-item"><a href="{{ url('panel/settings') }}">Configurações</a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-9">
      @yield('content')
    </div>
    @endif
  </div>
</div>
@endsection