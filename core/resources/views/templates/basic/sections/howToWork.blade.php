@php
    $work = getContent('howToWork.content', true);
    $works = getContent('howToWork.element');
@endphp
<!-- How Section -->
<section class="how-section pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">{{ __(@$work->data_values->title) }}</span>
                    <h3 class="section__title">{{ __(@$work->data_values->heading) }}</h3>
                    <p>
                        {{ __(@$work->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-0 gy-5 justify-content-center">

            @foreach($works->reverse() as $singleWork)
                <div class="col-lg-4">
                    <div class="how__item">
                        <div class="shape-bg">
                            @if($loop->odd)
                                <img src="{{ $activeTemplateTrue.'css/icons/how-shape.png' }}" alt="css">
                            @else
                                <img src="{{ $activeTemplateTrue.'css/icons/how-shape2.png' }}" alt="css">
                            @endif
                        </div>
                        <div class="how__thumb">
                            @php
                                echo $singleWork->data_values->icon;
                            @endphp
                        </div>
                        <div class="how__content">
                            <h5 class="title">{{ __($singleWork->data_values->text) }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- How Section -->
