@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Código')</th>
                                <th>@lang('Valor')</th>
                                <th>@lang('Usuário')</th>
                                <th>@lang('Ação')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($giftcards as $giftcard)
                            <tr>
                                <td data-label="@lang('Código')">{{ $giftcard->code }}</td>
                                <td data-label="@lang('Valor')">{{ showAmount($giftcard->amount) }} {{ __($general->cur_text) }}</td>
                                <td data-label="@lang('Usuário')">
                                    @if($giftcard->user_id)
                                            <span class="font-weight-bold">
                                                {{@$giftcard->user->fullname}}
                                            </span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $giftcard->user_id) }}">
                                                    <span>@</span>{{ @$giftcard->user->username }}
                                                </a>
                                            </span>
                                        @else
                                            <span class="badge badge--primary">@lang('N/A')</span>
                                        @endif
                                </td>
                                <td data-label="@lang('Ação')">
                                    <a href="{{ route('admin.giftcards.edit', $giftcard->id) }}" class="icon-btn editBtn">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    <a href="#" class="icon-btn deleteBtn bg--danger ml-2" data-id="{{ $giftcard->id }}">
                                        <i class="las la-trash text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">@lang('Nenhum gift card encontrado!')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmação de Exclusão')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>@lang('Você tem certeza de que deseja excluir este gift card? Esta ação é irreversível.')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancelar')</button>
                    <button type="submit" class="btn btn-danger">@lang('Excluir')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('breadcrumb-plugins')
    <a href="{{ route('admin.giftcards.create') }}" class="btn btn-sm btn--primary box--shadow1 text--small addNew">
        <i class="las la-plus"></i>
        @lang('Novo Gift Card')
    </a>
@endpush

@push('script')
<script>
    $(document).on('click', '.deleteBtn', function() {
        var giftCardId = $(this).data('id');
        var url = "{{ route('admin.giftcards.destroy', '') }}/" + giftCardId;
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    });
</script>
@endpush