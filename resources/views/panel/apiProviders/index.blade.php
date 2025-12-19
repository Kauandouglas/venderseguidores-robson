@extends('panel.templates.master')
@section('title', 'Provedor de API')
@section('content')
{{--    @if($userPlan == 1)--}}
{{--        <a href="{{ route('panel.apiProviders.create') }}" class="btn btn-primary mb-3">--}}
{{--            <i class="mb-1" data-feather="plus" width="20"></i> Cadastrar Provedor--}}
{{--        </a>--}}
{{--    @endif--}}
    <a href="https://www.youtube.com/watch?v=cwGyLmVn8Mk" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section class="section">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body overflow-auto">
                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th>Provedor</th>
                        <th>Saldo</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($apiProviders as $apiProvider)
                        <tr>
                            <td>{{ $apiProvider->url }}</td>
                            <td>R$ {{ $apiProvider->convert_balance }}</td>
                            <td>
                                @if($apiProvider->status == 0)
                                    <span class="badge badge-danger">{{ $apiProvider->status_string }}</span>
                                @else
                                    <span class="badge badge-success">{{ $apiProvider->status_string }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('panel.apiProviders.edit', ['apiProvider' => $apiProvider]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i data-feather="edit" width="20"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $apiProviders->links() }}
            </div>
        </div>
    </section>
@endsection
