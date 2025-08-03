@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body">
                <form action="{{ route('admin.giftcards.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Código'):</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Valor'):</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary">@lang('Salvar Gift Card')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
