@php
/* ==========================
| SIMULANDO DADOS DO BANCO
|==========================*/

$schema = json_decode('{
  "header": {
    "title": "Cabeçalho",
    "fields": [
      {
        "type": "text",
        "key": "title",
        "label": "Título Principal"
      },
      {
        "type": "textarea",
        "key": "text",
        "label": "Texto do Cabeçalho"
      },
      {
        "type": "text",
        "key": "button_text",
        "label": "Texto do Botão"
      },
      {
        "type": "image",
        "key": "image",
        "label": "Imagem do Cabeçalho"
      }
    ]
  },

  "services": {
    "title": "Serviços",
    "repeatable": true,
    "fields": [
      {
        "type": "image",
        "key": "image",
        "label": "Imagem do Serviço"
      },
      {
        "type": "text",
        "key": "title",
        "label": "Título do Serviço"
      },
      {
        "type": "textarea",
        "key": "text",
        "label": "Descrição do Serviço"
      }
    ]
  },

  "details": {
    "title": "Detalhes",
    "fields": [
      {
        "type": "image",
        "key": "image",
        "label": "Imagem dos Detalhes"
      },
      {
        "type": "text",
        "key": "title",
        "label": "Título dos Detalhes"
      },
      {
        "type": "textarea",
        "key": "text",
        "label": "Texto dos Detalhes"
      },
      {
        "type": "text",
        "key": "button_text",
        "label": "Texto do Botão"
      }
    ]
  },

  "contact": {
    "title": "Contato",
    "fields": [
      {
        "type": "text",
        "key": "title",
        "label": "Título da Seção"
      },
      {
        "type": "textarea",
        "key": "text",
        "label": "Texto de Contato"
      }
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
                                                    <img src="{{ $value ? Storage::url($value) : asset('images/placeholder.png') }}"
                                                         class="img-thumbnail mb-2 image-preview"
                                                         width="200">
                                                    <input type="file"
                                                           name="{{ $field['key'] }}"
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

    // Pré-visualização de imagem
    $(document).on('change', '.image-input', function() {
        const file = this.files[0];
        const preview = $(this).siblings('.image-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

});
</script>
@endpush
