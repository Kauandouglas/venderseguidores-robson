@php
/* ==========================
| SIMULANDO DADOS DO BANCO
|==========================*/

$schema = json_decode('{
  "header": {
    "title": "Cabeçalho",
    "fields": [
      { "type": "text", "key": "title", "label": "Título Principal" },
      { "type": "textarea", "key": "text", "label": "Texto do Cabeçalho" },
      { "type": "text", "key": "button_text", "label": "Texto do Botão" },
      { "type": "image", "key": "image", "label": "Imagem do Cabeçalho" }
    ]
  },

  "services": {
    "title": "Serviços",
    "repeatable": true,
    "fields": [
      { "type": "image", "key": "image", "label": "Imagem do Serviço" },
      { "type": "text", "key": "title", "label": "Título do Serviço" },
      { "type": "textarea", "key": "text", "label": "Descrição do Serviço" }
    ]
  },

  "details": {
    "title": "Detalhes",
    "fields": [
      { "type": "image", "key": "image", "label": "Imagem dos Detalhes" },
      { "type": "text", "key": "title", "label": "Título dos Detalhes" },
      { "type": "textarea", "key": "text", "label": "Texto dos Detalhes" },
      { "type": "text", "key": "button_text", "label": "Texto do Botão" }
    ]
  },

  "contact": {
    "title": "Contato",
    "fields": [
      { "type": "text", "key": "title", "label": "Título da Seção" },
      { "type": "textarea", "key": "text", "label": "Texto de Contato" }
    ]
  }
}', true);

$content = $configTemplate->content ?? [];
@endphp


@extends('panel.templates.master')

@section('title', 'Configuração do Template')

@section('content')

<section class="container-fluid">
<div class="row">
<div class="col-12">

<div class="card shadow-sm">
<div class="card-body">

<form method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

@foreach($schema as $sectionKey => $section)

    <div class="mt-5 mb-3 border-bottom pb-2">
        <h4 class="fw-bold text-primary">{{ $section['title'] }}</h4>
    </div>

    {{-- =======================
       | SEÇÃO REPEATABLE
       ======================= --}}
    @if(!empty($section['repeatable']))

        @php
            $items = $content[$sectionKey] ?? [];
        @endphp

        <div id="{{ $sectionKey }}-wrapper">

            @foreach($items as $index => $item)
                <div class="card mb-3 shadow-sm repeatable-item">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge bg-secondary">Item {{ $index + 1 }}</span>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                ➖ Remover
                            </button>
                        </div>

                        @foreach($section['fields'] as $field)
                            @php
                                $name  = "{$sectionKey}[{$index}][{$field['key']}]";
                                $value = $item[$field['key']] ?? '';
                            @endphp

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ $field['label'] }}</label>

                                @if($field['type'] === 'text')
                                    <input type="text"
                                           name="{{ $name }}"
                                           class="form-control"
                                           value="{{ $value }}">

                                @elseif($field['type'] === 'textarea')
                                    <textarea name="{{ $name }}"
                                              class="form-control"
                                              rows="3">{{ $value }}</textarea>

                                @elseif($field['type'] === 'image')
                                    <input type="file"
                                           name="{{ $name }}"
                                           class="form-control">
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

    {{-- =======================
       | SEÇÃO SIMPLES
       ======================= --}}
    @else

        <div class="row">
            @foreach($section['fields'] as $field)
                @php
                    $value = $content[$sectionKey][$field['key']] ?? '';
                @endphp

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">{{ $field['label'] }}</label>

                    @if($field['type'] === 'text')
                        <input type="text"
                               name="{{ $sectionKey }}[{{ $field['key'] }}]"
                               class="form-control"
                               value="{{ $value }}">

                    @elseif($field['type'] === 'textarea')
                        <textarea name="{{ $sectionKey }}[{{ $field['key'] }}]"
                                  class="form-control"
                                  rows="3">{{ $value }}</textarea>

                    @elseif($field['type'] === 'image')
                        <label class="d-block" style="cursor:pointer">
                            <img src="{{ $value ? Storage::url($value) : 'https://i0.wp.com/espaferro.com.br/wp-content/uploads/2024/06/placeholder-103.png?ssl=1' }}"
                                 class="img-thumbnail mb-2 image-preview"
                                 width="200">

                            <input type="file"
                                   name="{{ $sectionKey }}[{{ $field['key'] }}]"
                                   class="d-none image-input">
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
