@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.card.edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $card->id }}">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-12 form-group">
                            <label for="sub_category">@lang('Sub Category')</label>
                            <select name="sub_category" class="select2-basic" required>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" {{ $subCategory->id == $card->sub_category_id ? 'selected' : '' }}>
                                        {{ __($subCategory->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="revender">@lang('Revender')</label>
                                <select name="revender" class="form-control" required>
                                    <option value="1" {{ $card->revender == 1 ? 'selected' : '' }}>@lang('Sim')</option>
                                    <option value="0" {{ $card->revender == 0 ? 'selected' : '' }}>@lang('Não')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="card_validity">@lang('Validade do Cartão (Dias)')</label>
                                <input type="number" class="form-control" name="card_validity" value="{{ $card->card_validity ?? '' }}" min="1">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="disponivel">@lang('Quantidade Disponível')</label>
                                <input type="number" class="form-control" name="disponivel" value="{{ $card->disponivel ?? '' }}" min="1">
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label for="details">@lang('Card Details')</label>
                                <textarea rows="6" class="form-control border-radius-5" name="details" placeholder="@lang('Card Details')">{{ $card->details }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label>@lang('Card Image (optional)')</label>
                                <input type="file" class="form-control" name="image">
                                @if($card->image)
                                    <div class="mt-3">
                                        <img src="{{ getImage(imagePath()['card']['path'].'/'.$card->image, imagePath()['card']['size']) }}" alt="image" class="w-25">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Update')</button>
                </div>
            </form>
        </div><!-- card end -->
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        // Função para alternar a visibilidade do campo disponível
        function toggleDisponivelField() {
            const revenderStatus = $('select[name="revender"]').val();
            if (revenderStatus == '1') {
                $('input[name="disponivel"]').closest('.form-group').show();
            } else {
                $('input[name="disponivel"]').closest('.form-group').hide();
                $('input[name="disponivel"]').val('1'); // Define automaticamente o valor como 1 se revender for 0
            }
        }

        // Monitora mudanças no seletor de revender para alternar a visibilidade do campo disponível
        $('select[name="revender"]').change(function() {
            toggleDisponivelField();
        });

        // Chamada inicial para configurar corretamente a visibilidade ao carregar a página
        toggleDisponivelField();

    })(jQuery);
</script>
@endpush
