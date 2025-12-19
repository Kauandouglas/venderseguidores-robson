@extends('web.templates.master')
@section('title', 'Esqueci a senha')
@section('content')
    <form action="{{ route('password.email') }}" method="post" style="max-width: 90%;" class="form-login">
        @csrf
        <h2 class="text-center mb-5">Esqueci a senha</h2>

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
        <div class="clearfix mt-2">
            <button class="btn btn-primary w-100">Enviar Email</button>
        </div>
    </form>
@endsection
