@php
    $top = getContent('topSell.content', true);
    $topSells = App\Models\Card::with('subCategory.category')
                                  ->whereHas('subCategory.category', function($q){
                                      $q->where('status', 1);
                                   })
                                  ->where('user_id', '!=', 0)
                                  ->groupBy('sub_category_id')
                                  ->selectRaw('sub_category_id, count(sub_category_id) as sold, id')
                                  ->orderBy('sold', 'DESC')
                                  ->take(12)
                                  ->get();
@endphp
<!-- Top Sell Card Section -->
<section class="latest-card-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">
                        {{ __(@$top->data_values->title) }}
                    </span>
                    <h3 class="section__title">
                        {{ __(@$top->data_values->heading) }}
                    </h3>
                    <p>
                        {{ __(@$top->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-3 g-sm-4 justify-content-center card-wrapper">
            @foreach($topSells as $topSell)
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="card-item">
                        <div class="card-thumb">
                                <a href="{{ route('card.details', ['name'=>slug($topSell->subCategory->name), 'id'=>$topSell->subCategory->id]) }}">
                                <img src="{{ getImage(imagePath()['sub_category']['path'].'/'.$topSell->subCategory->image) }}" alt="@lang('card')">
                            </a>
                        </div>
                        <h5 class="title">
                                <a href="{{ route('card.details', ['name'=>slug($topSell->subCategory->name), 'id'=>$topSell->subCategory->id]) }}">
                                {{ __($topSell->subCategory->name) }}
                            </a>
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Top Sell Card Section -->
