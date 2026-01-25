<div class="sidebar-wrapper">
    <div class="sidebar-header">
        @inject("systemSetting", "App\Services\Web\SystemSetting")
        <img width="120" src="{{ $systemSetting->first()->url_logo ?? asset(config('template.url_logo')) }}" alt=""
             srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class='sidebar-title'>Menu</li>
            <li class="sidebar-item">
                <a href="{{ route('panel.index') }}" class='sidebar-link'>
                    <i data-feather="home" width="20"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/painel/planos" class='sidebar-link'>
                    <img src="https://static.vecteezy.com/system/resources/previews/068/336/780/non_2x/flat-gold-coin-with-simple-dollar-symbol-centered-free-png.png" style="width: 20px;">
                    <span>Ser Ouro</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('panel.purchases.index') }}" class='sidebar-link'>
                    <i data-feather="shopping-cart" width="20"></i>
                    <span>Vendas</span>
                </a>
            </li>
            <li class="sidebar-item" id="step4">
                <a href="{{ route('panel.categories.index') }}" class='sidebar-link'>
                    <i data-feather="grid" width="20"></i>
                    <span>Categorias</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('panel.services.index') }}" class='sidebar-link' id="step5">
                    <i data-feather="list" width="20"></i>
                    <span>Serviços</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('panel.serviceDescounts.index') }}" class='sidebar-link'>
                    <i data-feather="percent" width="20"></i>
                    <span>Descontos</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('panel.discountCoupons.index') }}" class='sidebar-link'>
                    <i data-feather="percent" width="20"></i>
                    <span>Cupom de desconto</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('panel.emailTemplates.index') }}" class='sidebar-link'>
                    <i data-feather="mail" width="20"></i>
                    <span>Email Automático</span>
                </a>
            </li>
            @if(Auth::user()->planPurchase()->active()->where('plan_id', 2)->count() == 1)
                <li class="sidebar-item">
                    <a href="{{ route('panel.whatsapp.index') }}" class='sidebar-link'>
                        <i data-feather="message-circle" width="20"></i>
                        <span>Vincular WhatsApp</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('panel.domains.create') }}" class='sidebar-link'>
                        <i data-feather="globe" width="20"></i>
                        <span>Vincular meu domínio</span>
                    </a>
                </li>
            @endif

            <li class="sidebar-item  has-sub" id="step1">
                <a href="#" class='sidebar-link'>
                    <i data-feather="settings" width="20"></i>
                    <span>Configurações</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('panel.systemSettings.edit') }}">Configurações do sistema</a>
                    </li>
                    <li>
                        <a href="{{ route('panel.configTemplates.edit') }}">Configuração do template</a>
                    </li>
                    <li id="step2">
                        <a href="{{ route('panel.apiProviders.index') }}">Provedor de API</a>
                    </li>

                    <li id="step3">
                        <a href="/painel/configuracao/pagamentos">Chave De Pagamento</a>
                    </li>

                    <li>
                        <a href="{{ route('panel.conversionTags.edit') }}">Tags de conversões</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-toggle="modal" data-target="#tutorialsModal" href="" class='sidebar-link'>
                    <i data-feather="play" width="20"></i>
                    <span>Tutoriais</span>
                </a>
            </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>

<div class="modal fade" id="tutorialsModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assista ao nosso tutorial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="height:400px;overflow-y: scroll;">
                <div id="accordion">

                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading14">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse14"
                                        aria-expanded="true" aria-controls="collapse14">
                                    Cadastrando a API do paineldoinstabrasil.com na loja do Insta
                                </button>
                            </h5>
                        </div>

                        <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/cwGyLmVn8Mk" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading20">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse20"
                                        aria-expanded="true" aria-controls="collapse20">
                                    Criando as categorias
                                </button>
                            </h5>
                        </div>

                        <div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/yJd4sx_Rf4o" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading21">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse21"
                                        aria-expanded="true" aria-controls="collapse21">
                                    Criando novos serviços
                                </button>
                            </h5>
                        </div>

                        <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/wnnNAX90lXs" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading13">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse13"
                                        aria-expanded="true" aria-controls="collapse13">
                                    Adicionando logotipo, favicon, whats de atendimento
                                </button>
                            </h5>
                        </div>

                        <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/Ba92lzJNSIU" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading12">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse12"
                                        aria-expanded="true" aria-controls="collapse12">
                                    Alterando o template
                                </button>
                            </h5>
                        </div>

                        <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/JZrWS0vB9yc" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-header" id="heading22">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse22"
                                        aria-expanded="true" aria-controls="collapse22">
                                    Adicionando saldo no Painel do Insta
                                </button>
                            </h5>
                        </div>

                        <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion">
                            <div class="card-body">
                                <iframe src="//www.youtube.com/embed/z-TKTEAzFUw" class="note-video-clip" width="100%"
                                        height="360" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
