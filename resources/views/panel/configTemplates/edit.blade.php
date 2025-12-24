@php
/* ==========================
| SIMULANDO DADOS DO BANCO
|==========================*/

$schema = json_decode('{
  "header": {
    "title": "Cabeçalho",
    "fields": [
      { "type": "text", "key": "header_title", "label": "Título Principal" },
      { "type": "textarea", "key": "header_subtitle", "label": "Subtítulo" },
      { "type": "image", "key": "header_image", "label": "Imagem" }
    ]
  },

  "services": {
    "title": "Serviços",
    "repeatable": true,
    "fields": [
      { "type": "text", "key": "title", "label": "Título" },
      { "type": "textarea", "key": "description", "label": "Descrição" }
    ]
  },

  "reviews": {
    "title": "Avaliações",
    "repeatable": true,
    "fields": [
      { "type": "text", "key": "title", "label": "Título" },
      { "type": "textarea", "key": "description", "label": "Descrição" }
    ]
  }
}', true);

$content = json_decode('{
  "header_title": "Sistema Profissional",
  "header_subtitle": "Templates dinâmicos com Laravel + JSON",
  "header_image": "https://via.placeholder.com/1200x400",

  "services": [
    { "title": "Automação", "description": "Ganhe produtividade automatizando processos." },
    { "title": "Performance", "description": "Sistema rápido, escalável e seguro." }
  ],

  "reviews": [
    { "title": "Excelente sistema", "description": "Muito fácil de usar e extremamente flexível. Recomendo para qualquer projeto profissional." },
    { "title": "Top demais", "description": "Consegui montar páginas dinâmicas sem mexer no código. Sensacional." }
  ]
}', true);
@endphp


@extends('panel.templates.master')

@section('title', 'Configuração do Template')

@section('content')

<section class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form id="configTemplateForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @foreach($schema as $sectionKey => $section)

                            <div class="mt-5 mb-3 border-bottom pb-2">
                                <h4 class="fw-bold text-primary">
                                    {{ $section['title'] }}
                                </h4>
                            </div>

                            {{-- REPEATABLE --}}
                            @if(isset($section['repeatable']) && $section['repeatable'])

                                @php
                                    $items = $content[$sectionKey] ?? [];
                                @endphp

                                <div id="{{ $sectionKey }}-wrapper">

                                    @foreach($items as $index => $item)
                                        <div class="card mb-3 shadow-sm repeatable-item">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="badge bg-secondary">
                                                        Item {{ $index + 1 }}
                                                    </span>

                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-item">
                                                        ➖ Remover
                                                    </button>
                                                </div>

                                                @foreach($section['fields'] as $field)
                                                    @php
                                                        $name  = "{$sectionKey}[{$index}][{$field['key']}]";
                                                        $value = $item[$field['key']] ?? '';
                                                    @endphp

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            {{ $field['label'] }}
                                                        </label>

                                                        @if($field['type'] === 'text')
                                                            <input type="text"
                                                                   name="{{ $name }}"
                                                                   class="form-control"
                                                                   value="{{ $value }}">

                                                        @elseif($field['type'] === 'textarea')
                                                            <textarea name="{{ $name }}"
                                                                      class="form-control"
                                                                      rows="3">{{ $value }}</textarea>
                                                        @endif
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <button type="button"
                                        class="btn btn-outline-primary add-item"
                                        data-section="{{ $sectionKey }}">
                                    ➕ Adicionar {{ $section['title'] }}
                                </button>

                            {{-- SEÇÃO SIMPLES --}}
                            @else

                                <div class="row">
                                    @foreach($section['fields'] as $field)
                                        @php
                                            $value = $content[$field['key']] ?? '';
                                        @endphp

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                {{ $field['label'] }}
                                            </label>

                                            @if($field['type'] === 'text')
                                                <input type="text"
                                                       name="{{ $field['key'] }}"
                                                       class="form-control"
                                                       value="{{ $value }}">

                                            @elseif($field['type'] === 'textarea')
                                                <textarea name="{{ $field['key'] }}"
                                                          class="form-control"
                                                          rows="3">{{ $value }}</textarea>

                                            @elseif($field['type'] === 'image')
                                                <label class="d-block" style="cursor:pointer">
                                                    <img src="{{ $value ? asset($value) : asset('images/placeholder.png') }}"
                                                         class="img-thumbnail mb-2"
                                                         width="200">
                                                    <input type="file"
                                                           name="{{ $field['key'] }}"
                                                           class="d-none">
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                        @endforeach

                        <div class="text-end mt-5">
                            <button class="btn btn-success px-4">
                                💾 Salvar Configurações
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
@extends('panel.templates.master')

@section('title', 'Configuração do Template')

@section('content')

<section class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form id="configTemplateForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @foreach($schema as $sectionKey => $section)

                            <div class="mt-5 mb-3 border-bottom pb-2">
                                <h4 class="fw-bold text-primary">
                                    {{ $section['title'] }}
                                </h4>
                            </div>

                            {{-- REPEATABLE --}}
                            @if(isset($section['repeatable']) && $section['repeatable'])

                                @php
                                    $items = $content[$sectionKey] ?? [];
                                @endphp

                                <div id="{{ $sectionKey }}-wrapper">

                                    @foreach($items as $index => $item)
                                        <div class="card mb-3 shadow-sm repeatable-item">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="badge bg-secondary">
                                                        Item {{ $index + 1 }}
                                                    </span>

                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-item">
                                                        ➖ Remover
                                                    </button>
                                                </div>

                                                @foreach($section['fields'] as $field)
                                                    @php
                                                        $name  = "{$sectionKey}[{$index}][{$field['key']}]";
                                                        $value = $item[$field['key']] ?? '';
                                                    @endphp

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            {{ $field['label'] }}
                                                        </label>

                                                        @if($field['type'] === 'text')
                                                            <input type="text"
                                                                   name="{{ $name }}"
                                                                   class="form-control"
                                                                   value="{{ $value }}">

                                                        @elseif($field['type'] === 'textarea')
                                                            <textarea name="{{ $name }}"
                                                                      class="form-control"
                                                                      rows="3">{{ $value }}</textarea>
                                                        @endif
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <button type="button"
                                        class="btn btn-outline-primary add-item"
                                        data-section="{{ $sectionKey }}">
                                    ➕ Adicionar {{ $section['title'] }}
                                </button>

                            {{-- SEÇÃO SIMPLES --}}
                            @else

                                <div class="row">
                                    @foreach($section['fields'] as $field)
                                        @php
                                            $value = $content[$field['key']] ?? '';
                                        @endphp

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                {{ $field['label'] }}
                                            </label>

                                            @if($field['type'] === 'text')
                                                <input type="text"
                                                       name="{{ $field['key'] }}"
                                                       class="form-control"
                                                       value="{{ $value }}">

                                            @elseif($field['type'] === 'textarea')
                                                <textarea name="{{ $field['key'] }}"
                                                          class="form-control"
                                                          rows="3">{{ $value }}</textarea>

                                            @elseif($field['type'] === 'image')
                                                <label class="d-block" style="cursor:pointer">
                                                    <img src="{{ $value ? asset($value) : asset('images/placeholder.png') }}"
                                                         class="img-thumbnail mb-2"
                                                         width="200">
                                                    <input type="file"
                                                           name="{{ $field['key'] }}"
                                                           class="d-none">
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                        @endforeach

                        <div class="text-end mt-5">
                            <button class="btn btn-success px-4">
                                💾 Salvar Configurações
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
$(function () {

    // Adicionar item
    $('.add-item').on('click', function () {
        let section = $(this).data('section');
        let wrapper = $('#' + section + '-wrapper');
        let index = wrapper.children().length;

        let html = `
        <div class="card mb-3 shadow-sm repeatable-item">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-secondary">Item ${index + 1}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                        ➖ Remover
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Título da Avaliação</label>
                    <input type="text" name="${section}[${index}][title]" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Descrição</label>
                    <textarea name="${section}[${index}][description]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>`;

        wrapper.append(html);
    });

    // Remover item
    $(document).on('click', '.remove-item', function () {
        $(this).closest('.repeatable-item').remove();
    });

});
</script>
@endpush
