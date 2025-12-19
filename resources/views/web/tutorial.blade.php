@extends('web.templates.master')
@section('content')
    <div class="page-body-wrapper mb-5" style="margin-top: 140px">
        <div class="container">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="d-sm-flex justify-content-between align-items-center mb-2">
                        <h3 class="font-weight-medium text-dark">Tutoriais</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Cadastrando a API do paineldoinstabrasil.com na loja do Insta
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/cwGyLmVn8Mk" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Criando as categorias
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/yJd4sx_Rf4o" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Criando novos serviços
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/wnnNAX90lXs" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="heading4">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Adicionando logotipo, favicon, whats de atendimento
                            </button>
                        </h2>
                    </div>
                    <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/Ba92lzJNSIU" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="heading5">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                Alterando o template
                            </button>
                        </h2>
                    </div>
                    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/JZrWS0vB9yc" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="heading6">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                Adicionando saldo no Painel do Insta
                            </button>
                        </h2>
                    </div>
                    <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
                        <div class="card-body">
                            <iframe src="//www.youtube.com/embed/z-TKTEAzFUw" class="note-video-clip" width="100%"
                                    height="360" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
