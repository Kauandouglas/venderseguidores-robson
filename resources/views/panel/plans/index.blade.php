@extends('panel.templates.master')
@section('title', 'Planos')
@section('content')
    <style>
        .pricing-box {
            -webkit-box-shadow: 0px 5px 30px -10px rgba(0, 0, 0, 0.1);
            box-shadow: 0px 5px 30px -10px rgba(0, 0, 0, 0.1);
            padding: 35px 50px;
            border-radius: 20px;
            position: relative;
        }
    </style>
    <div class="container">
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-lg-4">
                    <div class="pricing-box mt-4">
                        <div style="margin-bottom: 30px;">
                            @if($plan->price > 0)
                                <img src="{{ asset('panel_assets/images/' . $plan->image) }}">
                            @endif
                        </div>
                        <h4 class="f-20">{{ $plan->name }}</h4>
                        <div class="mt-4 pt-2" style="list-style: none;">
                            @foreach(explode("\n", $plan->description) as $description)
                                <p class="mb-2 f-18">{!! $description !!}</p>
                            @endforeach
                        </div>
                        <div class="pricing-plan mt-4 pt-2">
                            <h4 class="text-muted">
                                <span class="plan text-dark">R$ {{ $plan->price }} </span>
                            </h4>
                            <p class="text-muted mb-0">Por mês</p>
                        </div>
                        @if($plan->price > 0)
                            @if(isset($planPurchase))
                                @if($planPurchase->plan_id == $plan->id)
                                    <div class="mt-4 pt-3">
                                        <a href="#" class="btn btn-success btn-rounded">Plano Ativo</a>
                                    </div>
                                @else
                                    <div class="mt-4 pt-3">
                                        <a href="{{ route('panel.plans.signed', ['plan' => $plan]) }}"
                                           class="btn btn-primary btn-rounded">Alterar Plano</a>
                                    </div>
                                @endif
                            @else
                                <div class="mt-4 pt-3">
                                    <a href="{{ route('panel.plans.signed', ['plan' => $plan]) }}"
                                       class="btn btn-primary btn-rounded">Assinar Agora</a>
                                </div>

                                <a href="" data-toggle="modal" data-target="#contentModal"
                                   style="display: flex;justify-content: center;margin-top: 30px;margin-bottom: -10px;">Ver
                                    Condições</a>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações pra montar sua loja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <b> Para montar sua loja, precisamos das seguintes informações: </b><br><br>

                    <b> É necessário ter conhecimento em internet.</b><br><br>

                    Acesse lojadoinsta.com.br, escolha e pague o plano ouro (R$19,00);<br><br>

                   <b> Cadastro na loja:</b> Login e senha;<br><br>

                    Acesse paineldoinstabrasil.com, adicione R$50,00, mesmo se você já for cliente;<br><br>

                    <b> Cadastro no painel:</b> Login e senha.<br><br>

                    <b>Criar conta no Mercado Pago</b> (se ainda não tiver) e enviar o ACCESS TOKEN do Mercado Pago;<br><br>

                    <b>Prazo:</b> 3 dias úteis após o envio e conferência de todas as informações.<br><br>

                    Após receber tudo, montaremos seu grupo de suporte e a comunicação será feita por lá. Sua loja
                    ficará pronta, igual à nossa: lojadoinsta.com.br/brasil, mas a administração será sua!<br><br>

                    Qualquer dúvida, só chamar no Whatsapp de Atendimento: <a href="https://wa.me/5517981452466">+55 17 98145-2466</a>
                </div>
            </div>
        </div>
    </div>
@endsection
