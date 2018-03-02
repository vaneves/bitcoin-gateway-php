@extends('layouts.master')

@section('template')
<div id="app-checkout">
  <div class="container">
    <div class="logo">
      <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
    </div>
    @yield('content')
  </div>
</div>
@endsection