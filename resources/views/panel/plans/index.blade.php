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
                                <img style="width: 50px;" src="https://static.vecteezy.com/system/resources/previews/068/336/780/non_2x/flat-gold-coin-with-simple-dollar-symbol-centered-free-png.png">
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
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
