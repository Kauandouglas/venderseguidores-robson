@extends('web.templates.master')
@section('title', 'Alterar senha')
@section('content')
    <form action="{{ route('password.update', ['token' => request()->token, 'email' => request()->email]) }}"
          method="post" style="max-width: 90%;" class="form-login">
        @csrf
        <h2 class="text-center mb-5">Alterar senha</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group position-relative has-icon-left">
            <label for="password">Senha</label>
            <div class="position-relative">
                <input type="password" class="form-control" value="{{ old('password') }}" id="password"
                       name="password">
                <div class="form-control-icon">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="clearfix mt-2">
            <button class="btn btn-primary w-100">Alterar senha</button>
        </div>
    </form>
@endsection
