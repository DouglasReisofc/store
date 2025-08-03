@php
    $counters = getContent('counter.element');
@endphp
<!-- Counter Section -->
<div class="counter-section bg--section pt-80 pb-80">
    <div class="container">
        <div class="row g-4">

            @foreach($counters as $count)
                <div class="col-sm-6 col-lg-3">
                    <div class="counter__item">
                        <div class="counter__header">
                            <h3 class="title rafcounter" data-counter-end="{{ $count->data_values->heading }}">00</h3>
                        </div>
                        <div class="counter__content">
                            {{ $count->data_values->sub_heading }}
                        </div>
                        <div class="icon">
                            @php
                                echo $count->data_values->icon;
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Counter Section -->
