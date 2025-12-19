@extends('web.templates.master')
@section('title', 'Entrar')
@section('content')
<form action="{{ route('panel.auth.login') }}" method="post" style="max-width: 90%;" class="form-login">
    @csrf
    <h2 class="text-center mb-5">Entrar</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="form-group position-relative has-icon-left">
        <label for="username">Email</label>
        <div class="position-relative">
            <input type="email" class="form-control" value="{{ old('email') }}" id="username"
                   name="email">
            <div class="form-control-icon">
                <i data-feather="user"></i>
            </div>
        </div>
    </div>
    <div class="form-group position-relative has-icon-left">
        <div class="clearfix">
            <label for="password">Senha</label>
        </div>
        <div class="position-relative">
            <input type="password" class="form-control" id="password" name="password">
            <div class="form-control-icon">
                <i data-feather="lock"></i>
            </div>
        </div>
    </div>
    <div class="form-group d-flex">
        <div class="w-50">
            <a href="cadastro?plan=1">
                <label style="cursor: pointer;" class="checkbox-wrap checkbox-primary text-primary">
                    Não tenho cadastro
                </label>
            </a>
        </div>
        <div class="w-50 text-right">
            <a href="{{ route('password.request') }}" class="text-primary">Esqueci a senha</a>
        </div>
    </div>
    <div class="clearfix mt-2">
        <button class="btn btn-primary w-100">Entrar</button>
    </div>
</form>

@endsection
