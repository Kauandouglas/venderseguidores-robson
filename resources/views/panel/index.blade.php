@extends('panel.templates.master')
@section('title', 'Home')
@section('content')
    <section class="section">
        <div class="row mb-2">
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-4 py-4 d-flex justify-content-between'>
                                <h3 class='card-title'>
                                    <i data-feather="shopping-cart"
                                       style="height: 40px;width: 40px;color: #00c292;"></i>
                                </h3>
                                <div class="card-right align-items-center">
                                    <p>R$ {{ number_format($purchaseSum, 2, ',', '.') }}</p>
                                    <span>Vendas mês</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-4 py-4 d-flex justify-content-between'>
                                <h3 class='card-title'>
                                    <i data-feather="shopping-cart"
                                       style="height: 40px;width: 40px;color: #00c292;"></i>
                                </h3>
                                <div class="card-right align-items-center">
                                    <p>
                                        R$ {{ number_format($purchaseSum - $purchaseChargeSum, 2, ',', '.') }} /
                                        @if($purchaseChargeSum > 0)
                                            {{ intval((($purchaseSum - $purchaseChargeSum) / $purchaseSum * 100)) }}%
                                        @else
                                            0%
                                        @endif
                                    </p>
                                    <span> Lucro mês </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-4 py-4 d-flex justify-content-between'>
                                <h3 class='card-title'>
                                    <i data-feather="list" style="height: 40px;width: 40px;color: #00c292;"></i>
                                </h3>
                                <div class="card-right align-items-center">
                                    <p>{{ $purchaseTotalCount }}</p>
                                    <span>Pedidos mês</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-4 py-4 d-flex justify-content-between'>
                                <h3 class='card-title'>
                                    <i data-feather="shopping-bag" style="height: 40px;width: 40px;color: #00c292;"></i>
                                </h3>
                                <div class="card-right align-items-center">
                                    @if($purchaseChargeSum > 0)
                                        <p>
                                            R$ {{ number_format(($purchaseSum / $purchaseTotalCount), 2, ',', '.')}}</p>
                                    @else
                                        <p>R$ 0,00</p>
                                    @endif
                                    <span>Preço médio</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="col-12 col-md-3">--}}
{{--                <div class="card card-statistic">--}}
{{--                    <div class="card-body p-0">--}}
{{--                        <div class="d-flex flex-column">--}}
{{--                            <div class='px-4 py-4 d-flex justify-content-between'>--}}
{{--                                <h3 class='card-title'>--}}
{{--                                    <i data-feather="award" style="height: 40px;width: 40px;color: #00c292;"></i>--}}
{{--                                </h3>--}}
{{--                                <div class="card-right align-items-center">--}}
{{--                                    <p>{{ $positionRank }}º</p>--}}
{{--                                    <span>Posição Ranking</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </section>

    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: first baseline;">
                <div class="col-6">
                    <h5 class="box-title">Estatística de Ordens</h5>
                </div>
                <div class="form-group col-6">
                    <form action="" id="monthOrder">
                       <div class="row">
                          <div class="col-lg-6">
                              <select name="monthYear" class="form-control">
                                  <option value="">Selecione um ano</option>
                                  @foreach(["2023", "2024", "2025"] as $month)
                                      <option value="{{ $month }}" {{ (request()->monthYear == $month ? 'selected' : '') }}>
                                          {{ $month }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                           <div class="col-lg-6">
                               <select name="monthOrder" class="form-control">
                                   <option value="">Selecione um mês</option>
                                   @foreach(["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto",
                                               "Setembro", "Outubro", "Novembro", "Dezembro"] as $i => $month)
                                       <option value="{{ $i + 1 }}" {{ (request()->monthOrder == $i + 1 ? 'selected' : '') }}>
                                           {{ $month }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
            <div id="area" class="w-100"></div>
        </div>
    </div>
    @include('panel.users.register-modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('cadastro') == '1') {
                // Se houver parâmetro plan, preenche o campo oculto
                const plan = urlParams.get('plan');
                if (plan) {
                    $('#registerPlanInput').val(plan);
                }
                $('#registerModal').modal('show');
            }
        });
    </script>
    <script>
        var areaOptions = {
            series: [
                {
                    name: "Quantidade De Vendas",
                    data: {!! $purchaseCount !!},
                },
                {
                    name: "Valor De Vendas",
                    data: {!! $sumPurchases !!},
                },
            ],
            chart: {
                height: 350,
                width: '100%',
                type: "area",
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                categories: {!! $purchaseDate !!},
            },
        };

        var area = new ApexCharts(document.querySelector("#area"), areaOptions);
        area.render();

        $('#monthOrder').change(function () {
            $('#monthOrder').submit()
        })
    </script>
@endpush
