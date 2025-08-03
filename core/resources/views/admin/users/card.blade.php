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
                                <th>@lang('Category')</th>
                                <th>@lang('Sub Category')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Buyer')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cards as $card)
                            <tr>

                                <td data-label="@lang('SL')">
                                    {{ $loop->index + 1 }}
                                </td>

                                <td data-label="@lang('Category')">
                                    <span class="font-weight-bold">
                                        {{ __($card->subCategory->category->name) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Sub Category')">
                                    <span class="font-weight-bold">
                                        {{ __($card->subCategory->name) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Price')">
                                    {{ showAmount($card->subCategory->price, 2) }}
                                    {{ __($general->cur_text) }}
                                </td>

                                <td data-label="@lang('Buyer')">
                                    <span class="font-weight-bold">
                                        {{@$card->user->fullname}}
                                    </span>
                                    <br>
                                    <span class="small">
                                        <a href="{{ route('admin.users.detail', $card->user_id) }}">
                                            <span>@</span>{{ @$card->user->username }}
                                        </a>
                                    </span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.card.edit.page', $card->id) }}" class="icon-btn editBtn" data-toggle="tooltip" title="Details" data-original-title="@lang('Details')"
                                    data-name="{{ $card->name }}"
                                    data-id="{{ $card->id }}"
                                    >
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
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


