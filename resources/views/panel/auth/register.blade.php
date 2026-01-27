@extends('panel.auth.layout')

@section('title', 'Cadastro')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Criar Conta</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('panel.users.store') }}">
                        @csrf
                        <input type="hidden" name="plan" value="{{ request('plan') }}">
                        <div class="form-group mb-3">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="domain">Domínio</label>
                            <input type="text" class="form-control" id="domain" name="domain" value="{{ old('domain') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Telefone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
