@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('SL')</th>
                                <th>@lang('Category Name')</th>
                                <th>@lang('Sub Category')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Sold')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cards as $card)
                            <tr>

                                <td data-label="@lang('SL')">
                                    {{ $loop->index + 1 }}
                                </td>

                                <td data-label="@lang('Category Name')">
                                    <span class="font-weight-bold">
                                        {{ __($card->subCategory->category->name) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Sub Category')">
                                    {{ __($card->subCategory->name) }}
                                </td>

                                <td data-label="@lang('Price')">
                                    <span class="font-weight-bold">
                                        {{ showAmount($card->subCategory->price, 2) }}
                                        {{ __($general->cur_text) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Sold')">
                                    {{ $card->sold }}
                                    @lang('PS')
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}!</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($cards) }}
                </div>
            </div>
        </div>
    </div>
@endsection

