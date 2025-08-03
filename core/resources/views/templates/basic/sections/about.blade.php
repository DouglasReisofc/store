@php
    $about = getContent('about.content', true);
@endphp
<!-- About Section -->
<section class="about-section overlay-hidden">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-between align-items-center">
            <div class="col-lg-7 col-xl-6 align-self-end">
                <div class="about-thumb">
                    <img src="{{ getImage('assets/images/frontend/about/' .@$about->data_values->image, '985x700') }}" alt="@lang('about')">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="pt-max-lg-0 pb-max-lg-50 pt-60 pb-120">
                    <div class="section__header mb-low">
                        <span class="section__category">{{ __(@$about->data_values->title) }}</span>
                        <h3 class="section__title">{{ __(@$about->data_values->heading) }}</h3>
                        <p class="mb-4">
                            {{ __(@$about->data_values->description) }}
                        </p>
                    </div>
                    <a href="{{ @$about->data_values->button_link }}" class="cmn--btn">
                        {{ __(@$about->data_values->button_text) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section -->
