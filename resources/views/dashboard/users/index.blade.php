@extends('dashboard.templates.master')
@section('title', 'Usuários')
@section('content')
    <div class="row">
        <!-- table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>Usuários</h2>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Domínio</th>
                                <th>Whatsapp</th>
                                <th>Email</th>
                                <th>Configurado</th>
                                <th>Serviços cadastrados</th>
                                <th>Quantidade de vendas</th>
                                <th>Plano Atual</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a target="_blank"
                                           href="{{ route('web.systemSettings.template', ['domain' => $user->domain]) }}">
                                            {{ $user->domain }}
                                        </a>
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="https://api.whatsapp.com/send?phone=55{{ clearString($user->phone) }}">
                                            {{ $user->phone }}
                                        </a>

                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ($user->payment_count != 0 && $user->api_providers_count != 0 ? 'Sim' : 'Não') }}</td>
                                    <td>{{ $user->services_count }}</td>
                                    <td>{{ $user->purchases_count }}</td>
                                    <td>{{ (isset($user->planPurchase) ? $user->planPurchase->plan->name : 'Grátis') }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
