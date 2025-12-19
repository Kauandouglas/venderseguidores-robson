@extends('panel.templates.master')
@section('title', 'Vincular meu domínio')
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
                                  action="{{ route('panel.domains.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="domain">Domínio</label>
                                                <input type="text" id="domain" class="form-control" name="domain"
                                                       value="{{ $domain->domain ?? '' }}">
                                            </div>
                                            @if($domain)
                                                <div class="alert alert-primary" role="alert">
                                                    <h5 class="text-white">DNS:</h5><br>
                                                    <i data-feather="copy" width="20"></i> master.rapidcloud.com.br<br>
                                                    <i data-feather="copy" width="20"></i> slave.rapidcloud.com.br
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Adicionar</button>
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
