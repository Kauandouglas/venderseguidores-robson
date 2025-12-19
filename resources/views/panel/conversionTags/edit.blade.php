@extends('panel.templates.master')
@section('title', 'Tags de conversão')
@section('content')
    {{--    <a href="https://youtu.be/JZrWS0vB9yc" target="_blank" class="btn btn-danger mb-3">--}}
    {{--        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial--}}
    {{--    </a>--}}
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

                            <form class="form form-vertical" action="{{ route('panel.conversionTags.update') }}"
                                  method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <p class="font-bold">Informe os códigos de identificação dos pixels abaixo
                                                para marcar os visitantes que acessam o seu site</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pixelFacebookAds">Pixel Facebook ADS</label>
                                                <input type="text" id="pixelFacebookAds" class="form-control"
                                                       name="pixel_facebook_ads" placeholder="EX: 9249087134056501"
                                                       value="{{ old('pixel_facebook_ads') ?? $conversionTag->pixel_facebook_ads ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pixelAnalytics">Código Google Analytics</label>
                                                <input type="text" id="pixelAnalytics" class="form-control"
                                                       name="pixel_analytics" placeholder="EX: UA-98292-14"
                                                       value="{{ old('pixel_analytics') ?? $conversionTag->pixel_analytics ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pixelGoogleAds">Código Google Tag ou Google ADS</label>
                                                <input type="text" id="pixelGoogleAds" class="form-control"
                                                       name="pixel_google_ads" placeholder="EX: UA-98292-14"
                                                       value="{{ old('pixel_google_ads') ?? $conversionTag->pixel_google_ads ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="codeEventAds">Código Evento Google ADS</label>
                                                <input type="text" id="codeEventAds" class="form-control"
                                                       name="code_event_ads" placeholder="EX: AW-16593592182/SRePCKLK47YZEPa-uOg9"
                                                       value="{{ old('code_event_ads') ?? $conversionTag->code_event_ads ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
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
