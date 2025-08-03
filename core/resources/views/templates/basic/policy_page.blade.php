@extends($activeTemplate.'layouts.frontend')

@section('content')

<section class="contact-section pt-120 pb-60 privacy-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @php
                    echo $content->data_values->details;
                @endphp
            </div>
        </div>
    </div>
</section>

@endsection
