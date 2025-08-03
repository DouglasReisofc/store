@php
    $banner = getContent('banner.content', true);
@endphp

@if(request()->routeIs('home'))
<!-- Banner Section -->
<section class="banner-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 align-self-center">
                <div class="banner-content">
                    <div class="container p-lg-0">
                        <h1 class="banner-title">{{ __(@$banner->data_values->heading) }}</h1>
                        <p class="banner-txt">
                            {{ __(@$banner->data_values->sub_heading) }}
                        </p>
                        <div class="btn__grp">
                            <a href="{{ route('card') }}" class="cmn--btn">@lang('Buy Now')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 bg--section banner-thumb-bg">
                <div class="h-100 d-flex flex-wrap align-items-end">
                    <div class="banner-thumb">
    <img src="{{ getImage('assets/images/frontend/banner/' .@$banner->data_values->image, '50%') }}" alt="banner">
</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section -->
@else
<!-- Page Header Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h2 class="title">
                @if(request()->routeIs('blog.details'))
                    @lang('Single Blog')
                @else
                    {{ __($pageTitle) }}
                @endif
            </h2>
        </div>
    </div>
</section>
<!-- Page Header Section -->
@endif
