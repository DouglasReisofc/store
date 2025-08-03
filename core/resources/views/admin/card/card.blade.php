@extends('admin.layouts.app')

@section('panel')
<div class="row mb-4">
    <div class="col-lg-12">
        <form action="{{ route('admin.card.index') }}" method="GET" class="form-inline">
            @csrf
            <div class="card-body">
    <div class="row align-items-center justify-content-between"> <!-- Adicionada a classe align-items-center -->
        <div class="form-group mr-3">
            <label for="subcategoryId">@lang('Subcategoria')</label>
            <select class="form-control select2-basic" name="subcategoryId" id="subcategoryId">
                <option value="">{{ __('Todas as Subcategorias') }}</option>
                @foreach($subCategories as $subCategory)
                    <option value="{{ $subCategory->id }}" {{ request()->subcategoryId == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mr-3">
            <input type="text" name="trx" class="form-control" placeholder="Buscar por ID" value="{{ request()->trx }}">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Sub Category')</th>
                                <th>@lang('ID')</th>
                                <th>@lang('Criado Dia')</th>
                                <th>@lang('Editado Dia')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cards as $card)
                            <tr>
                                <td data-label="@lang('Sub Category')">{{ __($card->subCategory->name) }}</td>
                                <td data-label="@lang('ID')">{{ $card->trx ?? __('') }}</td>
                                <td data-label="@lang('Criado Dia')">{{ $card->created_at ? $card->created_at->format('d/m/Y') : __('N/A') }}</td>
                                <td data-label="@lang('Editado Dia')">{{ $card->updated_at ? $card->updated_at->format('d/m/Y') : __('N/A') }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.card.edit.page', $card->id) }}" class="icon-btn" data-toggle="tooltip" data-original-title="@lang('Edit')">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="icon-btn deleteBtn" data-id="{{ $card->id }}" data-toggle="modal" data-target="#deleteModal" style="background-color: red;">
                                        <i class="las la-trash text-white"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Paginação --}}
                    {{ $cards->appends(['subcategoryId' => request()->subcategoryId, 'trx' => request()->trx])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.card.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="deleteId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">@lang('Confirme a Exclusão')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('Deseja realmente apagar este produto?')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancelar')</button>
                    <button type="submit" class="btn btn-danger">@lang('Deletar')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.card.add.page') }}" class="btn btn-sm btn--primary box--shadow1 text--small">
    <i class="las la-plus"></i> @lang('Add New')
</a>
@endpush

@push('script')
<script>
    $(document).ready(function() {
    // Inicializa o Select2 para os campos especificados
    $('.select2-basic').select2();
    
    // Script para manipulação do botão de deletar, se necessário
    $('.deleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });
});
$(document).ready(function() {
    $('.deleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });
});
</script>
@endpush
