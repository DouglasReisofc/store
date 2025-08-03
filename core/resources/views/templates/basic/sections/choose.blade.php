@php
    $choose = getContent('choose.content', true);
    $chooses = getContent('choose.element');
@endphp
<!-- Why Choose Section -->
<section class="why-choose-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-between gy-5">
            <div class="col-lg-5">
                <div class="section__header">
                    <span class="section__category">{{ __(@$choose->data_values->heading) }}</span>
                    <h3 class="section__title">{{ __(@$choose->data_values->sub_heading) }}</h3>
                </div>
                <a href="{{ @$choose->data_values->button_link }}" class="cmn--btn">
                    {{ __(@$choose->data_values->button_text) }}
                </a>
            </div>
            <div class="col-lg-7 col-xl-6">
                <div class="choose-wrapper">
                    <div class="row g-4 gy-lg-0 gy-xl-5">

                    @foreach($chooses as $singleChoose)
                        <div class="col-sm-6">
                            <div class="choose__item">
                                <div class="choose__icon">
                                    @php
                                        echo $singleChoose->data_values->icon;
                                    @endphp
                                </div>
                                <div class="choose__content">
                                    <h5 class="choose__title">{{ __($singleChoose->data_values->title) }}</h5>
                                    <p>
                                        {{ __($singleChoose->data_values->description) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Section -->
