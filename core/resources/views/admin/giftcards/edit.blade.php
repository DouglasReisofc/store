@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-header">
                <h5 class="card-title">@lang('Editar Gift Card')</h5>
                <a href="{{ url()->previous() }}" class="btn btn--primary float-right">@lang('Voltar')</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.giftcards.update', $giftcard->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Código'):</label>
                        <input type="text" class="form-control" name="code" value="{{ $giftcard->code }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Valor'):</label>
                        <input type="number" class="form-control" name="amount" value="{{ $giftcard->amount }}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary">@lang('Atualizar Gift Card')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
