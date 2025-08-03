@php
    $featured = getContent('featured.content', true);
    $featuredCards = App\Models\Category::with('subCategory')
                                        ->where('featured', 1)
                                        ->where('status', 1)
                                        ->latest()
                                        ->take(12)
                                        ->get();
@endphp
<!-- Featured Card Section -->
<section class="top-selling-card-section bg--section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">
                        {{ __(@$featured->data_values->title) }}
                    </span>
                    <h3 class="section__title">
                        {{ __(@$featured->data_values->heading) }}
                    </h3>
                    <p>
                        {{ __(@$featured->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-slider owl-theme owl-carousel">
            @foreach($featuredCards as $featuredCard)
                <div class="card-item">
                    <div class="card-thumb">
                        <a href="{{ route('category', ['name'=>slug($featuredCard->name), 'id'=>$featuredCard->id]) }}">
                            <img src="{{ getImage(imagePath()['category']['path'].'/'.$featuredCard->image) }}" alt="@lang('card')">
                        </a>
                    </div>
                    <h5 class="title">
                        <a href="{{ route('category', ['name'=>slug($featuredCard->name), 'id'=>$featuredCard->id]) }}">
                            {{ __($featuredCard->name) }}
                        </a>
                    </h5>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Card Section -->
