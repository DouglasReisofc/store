@php
    $partners = getContent('partner.element');
@endphp
<!-- Partner Section -->
<section class="partner-section bg--section pt-80 pb-80">
    <div class="container">
        <div class="partner-slider owl-theme owl-carousel">

            @foreach($partners as $singlePartner)
                <div class="partner-thumb">
                    <img src="{{ getImage('assets/images/frontend/partner/' .@$singlePartner->data_values->image, '300x150') }}" alt="partner">
                    <img src="{{ getImage('assets/images/frontend/partner/' .@$singlePartner->data_values->image, '300x150') }}" alt="partner">
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Partner Section -->
