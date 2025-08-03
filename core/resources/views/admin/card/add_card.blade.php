@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.card.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 form-group">
                            <label for="sub_category">@lang('Sub Category')</label>
                            <select name="sub_category" class="select2-basic" required>
                                @foreach ($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}">{{ __($subCategory->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn--success w-100 addBtn"> <i class="la la-plus"></i> @lang('Add New Card')</button>
                        </div>
                    </div>
                    <div class="row base-area">
                        {{-- Template para novo cartão será inserido aqui dinamicamente --}}
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Save')</button>
                </div>
            </form>
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.card.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> @lang('Go Back')
    </a>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";

        function toggleDisponivelArea(selector) {
            $(selector).find('.revender-select').each(function () {
                var $this = $(this),
                    $disponivelArea = $this.closest('.card-body').find('.disponivel-area');
                if ($this.val() == '1') {
                    $disponivelArea.slideDown();
                } else {
                    $disponivelArea.slideUp();
                }
            });
        }

        function addNewCard() {
            let baseCard = `
                <div class="col-md-6 mt-5">
                    <div class="card border--primary">
                        <div class="card-body">
                            <div class="text-right">
                                <span class="badge removeBtn badge--danger cursor">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="revender">@lang('Revender após a compra ?')</label>
                                        <select name="revender[]" class="select2-basic revender-select" required>
                                            <option value="0">@lang('Não')</option>
                                            <option value="1">@lang('Sim')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 disponivel-area" style="display: none;">
                                    <div class="form-group">
                                        <label for="disponivel">@lang('Quantidade De vezes que vai ser revendido')</label>
                                        <input type="number" class="form-control" name="disponivel[]" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="card_validity">@lang('Validade do produto (Dias)')</label>
                                        <input type="number" class="form-control" name="card_validity[]" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="wef">@lang('Card Image (optional)')</label>
                                        <input type="file" class="form-control" name="image[]">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label for="details">@lang('Card Details')</label>
                                        <textarea rows="2" class="form-control border-radius-5" name="details[]" placeholder="@lang('Card Details')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('.base-area').append(baseCard);
            toggleDisponivelArea('.base-area .col-md-6:last-child');
        }

        $('.addBtn').on('click', function () {
            addNewCard();
        });

        $(document).on('change', '.revender-select', function () {
            toggleDisponivelArea($(this).closest('.card-body'));
        });

        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.col-md-6').remove();
        });

    })(jQuery);
</script>
@endpush
