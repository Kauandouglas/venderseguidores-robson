@extends('dashboard.templates.master')
@section('title', 'Editar perfil')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

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

                            <form class="form form-vertical" method="post"
                                  action="{{ route('dashboard.profiles.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="domain">Dominio</label>
                                                <input type="text" id="domain" class="form-control" name="domain"
                                                       value="{{ old('domain') ?? Auth::user()->domain }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                       value="{{ old('name') ?? Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                       value="{{ old('email') ?? Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="phone">Telefone</label>
                                                <input type="phone" id="phone" class="form-control" name="phone"
                                                       value="{{ old('phone') ?? Auth::user()->phone }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="image">Imagem</label>
                                                <input type="file" id="image" class="form-control" name="image"
                                                       accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password">Senha</label>
                                                <input type="password" id="password" class="form-control"
                                                       name="password">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Editar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
