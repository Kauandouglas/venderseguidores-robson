@extends('panel.templates.master')
@section('title', 'Cadastrar Serviço')
@section('content')
    <section class="section">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <form method="POST" action="{{ route('panel.configPreviews.store', ['step' => request()->step]) }}"
                  enctype="multipart/form-data">
                @csrf
                @if(true == false)
                    <div class="step-info">
                        <div class="card-body overflow-auto">
                            <div class="col-12">
                                <div class="text-center">
                                    <h3 class="mt-5">
                                        Configuramos e entregamos a sua loja pronta para você
                                    </h3>
                                    <div class="mt-4 mb-4">
                                        <p><span class="badge bg-success">1°</span> Clique no botão abaixo e assine o plano Ouro por apenas R$ 19 por mês</p>
                                        <p>
                                            <span class="badge bg-success">2°</span> Após o pagamento, entre em contato pelo <a target="_blank"
                                                   href="https://api.whatsapp.com/send?phone=5517981452466&text=Paguei o plano e gostaria da minha loja pronta">WhatsApp
                                                +55 17 98145-2466</a> para iniciarmos a configuração
                                        </p>
                                        <p>
                                            <span class="badge bg-success">3°</span> Receba sua loja pronta, idêntica à loja modelo:
                                            <a target="_blank" href="https://lojadoinsta.com.br/brasil">lojadoinsta.com.br/brasil</a>
                                        </p>
                                    </div>
                                    <a href="{{ route('panel.plans.signed', ['plan' => 3]) }}">
                                        <button type="button" class="btn btn-primary btn-lg mt-2 mb-1"
                                                style="background-color: #28a745; border-color: #28a745;">
                                            <i data-feather="shopping-bag" width="20"></i> Assinar Plano
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    @if(request()->step == 'info')
                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <h4 class="mb-4">Configuração do site <b>(1 de 5)</b></h4>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">Título</label>
                                        <input type="text" id="title" class="form-control" name="title"
                                               value="{{ old('title') ?? $systemSetting->title ?? 'Loja de seguidores' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="logo">Logo (.png) (100 x 38)</label>
                                        <input type="file" id="logo" class="form-control" name="logo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Próximo</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->step == 'layout')
                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <h4 class="mb-4">Layout do site <b>(2 de 5)</b></h4>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="primary_color">Cor primária</label>
                                        <input type="color" id="primary_color" class="form-control" name="primary_color"
                                               value="{{ $systemSetting->primary_color ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="secondary_color">Cor secundária</label>
                                        <input type="color" id="secondary_color" class="form-control"
                                               value="{{ $systemSetting->secondary_color ?? '' }}"
                                               name="secondary_color">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch mt-2">
                                            <input autocomplete="off"
                                                   {{ (!isset($systemSetting->color_default) || $systemSetting->color_default ? 'checked' : '') }} name="color_default"
                                                   type="checkbox" value="1" class="custom-control-input"
                                                   id="colorDefault">
                                            <label class="custom-control-label" for="colorDefault">Cor
                                                padrão</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('panel.configPreviews.create', ['step' => 'info']) }}">
                                            <button type="button" class="btn btn-outline-secondary me-1 mb-1">Anterior
                                            </button>
                                        </a>
                                        <button type="submit" class="btn btn-primary ml-2 mb-1">Próximo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->step == 'api')
                        <div id="load" class="mt-4 mb-4" style="display: none">
                            <img src="https://cdn.pixabay.com/animation/2023/05/02/04/29/04-29-06-428_512.gif"
                                 style="width: 220px;margin: auto;display: flex;">
                            <h4 class="text-center mt-4">Aguarde, estamos gerando seu token</h4>
                        </div>

                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <h4 class="mb-4">Provedor de API <b>(3 de 5)</b></h4>
                                </div>
                                <div id="generateKeyLogin"
                                     style="{{ (!empty($apiProvider->key) ? 'display: none' : '') }}">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="login">Usuário (Painel do Insta)</label>
                                            <input type="text" id="login" class="form-control" name="login"
                                                   value="{{ old('login') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password">Senha (Painel do Insta)</label>
                                            <input type="password" id="password" class="form-control" name="password"
                                                   value="{{ old('password') }}">

                                            <p class="mt-3 mb-1"><b>Já tem uma Key?</b></p>
                                            <button class="btn btn-warning btn-sm newKey">
                                                Usar key existente
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="generateKeyToken"
                                     style="{{ (empty($apiProvider->key) ? 'display: none' : '') }}">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="key">Token (API painel do insta)</label>
                                            <input type="text" id="key" class="form-control" name="key"
                                                   value="{{ $apiProvider->key }}">

                                            <p class="mt-3 mb-1"><b>Não sabe gerar sua chave Key?</b></p>
                                            <button class="btn btn-warning btn-sm newKey">
                                                Usar login e senha (Painel do Insta)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('panel.configPreviews.create', ['step' => 'layout']) }}">
                                            <button type="button" class="btn btn-outline-secondary me-1 mb-1">
                                                Anterior
                                            </button>
                                        </a>
                                        <button type="submit" class="btn btn-primary ml-2 mb-1">Próximo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->step == 'categories')
                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <h4 class="mb-4">Categorias <b>(4 de 5)</b></h4>
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nome</th>
                                        </tr>
                                        </thead>
                                        <tbody class="category ui-sortable">
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="1"
                                                               class="custom-control-input" id="categories1">
                                                        <label class="custom-control-label" for="categories1"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Seguidores Mundiais ♻️ R30</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="2"
                                                               class="custom-control-input" id="categories2">
                                                        <label class="custom-control-label" for="categories2"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Seguidores 100% 🇧🇷 ♻️ RA30</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="3"
                                                               class="custom-control-input" id="categories3">
                                                        <label class="custom-control-label" for="categories3"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                Seguidores 100% Reais e 🇧🇷 (100% Orgânicos) ♻️ R30
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="4"
                                                               class="custom-control-input" id="categories4">
                                                        <label class="custom-control-label" for="categories4"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Curtidas Mundiais</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="5"
                                                               class="custom-control-input" id="categories5">
                                                        <label class="custom-control-label" for="categories5"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Curtidas 100% 🇧🇷 ♻️ R30</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="6"
                                                               class="custom-control-input" id="categories6">
                                                        <label class="custom-control-label" for="categories6"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Visualizações Reels/Feed</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="7"
                                                               class="custom-control-input" id="categories7">
                                                        <label class="custom-control-label" for="categories7"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Visualizações no Story</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="8"
                                                               class="custom-control-input" id="categories8">
                                                        <label class="custom-control-label" for="categories8"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Comentários Prontos Brasileiros</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input checked name="categories[]" type="checkbox" value="9"
                                                               class="custom-control-input" id="categories9">
                                                        <label class="custom-control-label" for="categories9"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Tiktok Seguidores</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="{{ route('panel.configPreviews.create', ['step' => 'api']) }}">
                                                <button type="button" class="btn btn-outline-secondary me-1 mb-1">
                                                    Anterior
                                                </button>
                                            </a>
                                            <button type="submit" class="btn btn-primary ml-2 mb-1">Próximo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->step == 'payment')
                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <h4 class="mb-4">Pagamento <b>(5 de 5)</b></h4>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="access_token">Access Token</label>
                                        <input type="text" id="access_token" class="form-control" name="access_token"
                                               value="{{ (isset($payment) ? json_decode($payment->data)->access_token : '') }}">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('panel.configPreviews.create', ['step' => 'categories']) }}">
                                            <button type="button" class="btn btn-outline-secondary me-1 mb-1">Anterior
                                            </button>
                                        </a>
                                        <button type="submit" class="btn btn-primary ml-2 mb-1">Próximo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->step == 'finish')
                        <div class="step-info">
                            <div class="card-body overflow-auto">
                                <div class="col-12">
                                    <div class="text-center">
                                        <img
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8P_9QIVzvJJRSCnGCnyD9Q3O540PyTmNFwqNQXEVCfQ&s">
                                        <h5 class="mt-4">Sua loja foi configurada com sucesso!</h5>

                                        <a href="{{ route('web.systemSettings.template', ['domain' => Auth::user()->domain]) }}">
                                            <button type="button" class="btn btn-success mt-2 mb-1">Ver minha loja
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    @if(request()->step == 'api')
        <script>
            $('.newKey').click(function (e) {
                e.preventDefault()
                $('#generateKeyLogin').toggle()
                $('#generateKeyToken').toggle()
                $('#key').val('{{ $apiProvider->key }}')
            })

            $('form').submit(function () {
                $('#load').show();
                $('.step-info').hide()
            })
        </script>
    @endif
@endpush
