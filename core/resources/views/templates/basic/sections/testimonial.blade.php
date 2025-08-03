@php
    $testimonial = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element');
@endphp
<!-- Testimonial Section -->
<section class="testimonial-section pt-120 pb-120">
    <div class="container">
        <div class="section__header">
            <span class="section__category">{{ __(@$testimonial->data_values->title) }}</span>
            <h3 class="section__title">{{ __(@$testimonial->data_values->heading) }}</h3>
            <p>
                {{ __(@$testimonial->data_values->sub_heading) }}
            </p>
        </div>
        <div class="testimonial-slider owl-theme owl-carousel">

            @foreach($testimonials as $data)
                <div class="testimonial-item">
                    <div class="testimonial-thumb">
                        <img src="{{ getImage('assets/images/frontend/testimonial/' .@$data->data_values->image, '100x100') }}" alt="@lang('client')">
                    </div>
                    <div class="quote">
                        <i class="las la-quote-right"></i>
                    </div>
                    <div class="testimonial-content">
                        <div class="testimonial-header">
                            <div class="name">
                                <h6 class="title">{{ __($data->data_values->name) }}</h6>
                                <span class="info">{{ __($data->data_values->designation) }}</span>
                            </div>
                            <div class="ratings">
                                @for($i = 0; $i < $data->data_values->rating; $i++)
                                    <i class="las la-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p>
                            {{ __($data->data_values->say) }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Testimonial Section -->
