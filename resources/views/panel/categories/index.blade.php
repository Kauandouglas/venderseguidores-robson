@extends('panel.templates.master')
@section('title', 'Categorias')
@section('content')
    <style>
        .move-up, .move-down {
            cursor: pointer;
        }

        .arrow-container {
            display: flex;
            flex-direction: column;
        }
    </style>
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <a href="{{ route('panel.categories.create') }}" class="btn btn-primary">
            <i class="mb-1" data-feather="plus" width="20"></i> Cadastrar categoria
        </a>
        <a href="https://youtu.be/yJd4sx_Rf4o" target="_blank" class="btn btn-danger">
            <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
        </a>
        <button type="button" class="btn btn-success" id="copyDataBtnCategories" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border: none;color: white;font-weight: bold;">
            <i class="mb-1" data-feather="copy" width="20"></i> Copiar Categorias e Serviços
        </button>
    </div>
    <section class="section">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body overflow-auto">
                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody class="category">
                    @foreach($categories as $category)
                        <tr class="ui-state-default" id="categories_{{ $category->id }}">
                            <td>
                                <div class="arrow-container">
                                    <svg class="move-up" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path d="M10 4l6 6H4z"/>
                                    </svg>
                                    <svg class="move-down" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path d="M10 16l-6-6h12z"/>
                                    </svg>
                                </div>
                            </td>
                            <td>{{ $category->name }}
                            <td>
                                @if($category->status == 0)
                                    <span class="badge badge-danger">{{ $category->status_string }}</span>
                                @else
                                    <span class="badge badge-success">{{ $category->status_string }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('panel.categories.edit', ['category' => $category]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i data-feather="edit" width="20"></i>
                                    </a>
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                       data-target="#deleteModal"
                                       data-delete="{{ route('panel.categories.destroy', ['category' => $category]) }}">
                                        <i data-feather="trash-2" width="20"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

        <!-- Modal Selecionar Categoria para Clonar -->
        <div class="modal fade" id="selectCategoryCloneModal" tabindex="-1" aria-labelledby="selectCategoryCloneModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectCategoryCloneModalLabel">Escolher Categoria para Clonar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="cloneCategoryForm">
                            <div class="mb-3">
                                <label for="categoryToClone" class="form-label">Selecione a categoria do template:</label>
                                <select class="form-select" id="categoryToClone" name="category_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach(\App\Models\Category::where('user_id', 18)->get() as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Clonar Categoria</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Remover categoria</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Você realmente deseja remover essa categoria?
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var action = button.data('delete')
                var modal = $(this)

                modal.find('form').attr('action', action)
            })

            {{--$(".category").sortable({--}}
            {{--    handle: ".handle",--}}
            {{--    update: function () {--}}
            {{--        var categories = $(this).sortable("serialize");--}}
            {{--        displayLoading('show');--}}

            {{--        $.post("{{ route('panel.categories.order') }}", categories, function (response) {--}}
            {{--            displayLoading('hide');--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}
        });

        function moveRowUp(row) {
            var prev = row.prev();
            if (prev.length) {
                row.insertBefore(prev);
            }
        }

        function moveRowDown(row) {
            var next = row.next();
            if (next.length) {
                row.insertAfter(next);
            }
        }

        function updateOrder() {
            var categories = $('.category').sortable("serialize");
            displayLoading('show');

            $.post("{{ route('panel.categories.order') }}", categories, function (response) {
                displayLoading('hide');
            });
        }

        $(document).ready(function () {
            $('.category').sortable({
                handle: '.arrow-container',
                axis: 'y',
                update: function () {
                    updateOrder();
                }
            });

            $('.move-up').on('click', function () {
                var row = $(this).closest('tr');
                moveRowUp(row);
                updateOrder();
            });

            $('.move-down').on('click', function () {
                var row = $(this).closest('tr');
                moveRowDown(row);
                updateOrder();
            });

            // Copiar categorias e serviços (selecionar categoria específica do template)
            $('#copyDataBtnCategories').off('click').on('click', function(e) {
                e.preventDefault();
                $('#selectCategoryCloneModal').modal('show');
            });

            $('#cloneCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var categoryId = $('#categoryToClone').val();
                if (!categoryId) {
                    Swal.fire('Selecione uma categoria!', '', 'warning');
                    return;
                }
                displayLoading('show');
                $.post("{{ route('panel.copyData.copyCategoryFromTemplate') }}", {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    category_id: categoryId
                }, function(response) {
                    displayLoading('hide');
                    Swal.fire({
                        title: 'Sucesso!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(function() {
                        window.location.reload();
                    });
                }).fail(function(xhr) {
                    displayLoading('hide');
                    var message = 'Erro ao copiar categoria.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Erro',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    });
                });
            });
        });
    </script>
@endpush

