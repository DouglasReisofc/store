@php
    $deal = getContent('deals.content', true);
    $lastDeals = App\Models\Card::with('subCategory.category')
                                ->where('user_id', '!=', 0)
                                ->orderBy('purchase_at', 'Desc')
                                ->take(12)
                                ->get();
@endphp
<!-- Deals of The Day Section -->
<section class="deals-of-the-day-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">@lang('Last Deals')</span>
                    <h3 class="section__title">{{ __(@$deal->data_values->heading) }}</h3>
                    <p>
                        {{ __(@$deal->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-3 g-sm-4 justify-content-center card-wrapper">
            @foreach($lastDeals as $lastDeal)
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="card-item">
                        <div class="discount">
                            @lang('Sold')
                        </div>
                        <div class="card-thumb">
                            <a href="javascript:void(0)">
                                <img src="{{ getImage(imagePath()['category']['path'].'/'.$lastDeal->subCategory->category->image) }}" alt="@lang('card')">
                            </a>
                        </div>
                        <h5 class="title">
                            <a href="javascript:void(0)">{{ __($lastDeal->subCategory->name) }}</a>
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Deals of The Day Section -->
