<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/nice-select.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color) }}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    @stack('style-lib')

    @stack('style')

</head>

<body id="version">

    @stack('fbComment')

    <div class="preloader">
        <div class="loader-inner">
            <div class="loader-circle">
                <img src="{{ asset('assets/images/logoIcon/favicon.png') }}" alt="@lang('Preloader')">
            </div>
            <div class="loader-line-mask">
            <div class="loader-line"></div>
            </div>
        </div>
    </div>

    <a href="#0" class="scrollToTop"><i class="las la-angle-up"></i></a>
    <div class="overlay"></div>

    @include($activeTemplate.'partials.auth_header')
    @include($activeTemplate.'partials.banner')

    <section class="dashboard-section pt-80 pb-80">
        @yield('content')
    </section>

    @include($activeTemplate.'partials.footer')

    <script>
        "use strict";
        function setVersion(){
            if(!{{ $general->dark }}){
                $('#version').addClass('light-version');
                $('.logo img').attr('src', '{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}');

            }else{
                $('#version').removeClass('light-version');
                $('.logo img').attr('src', '{{getImage(imagePath()['logoIcon']['path'] .'/darkLogo.png')}}');
            }
        }
    </script>

    <script src="{{asset($activeTemplateTrue.'js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/nice-select.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')

    <script>
        $(document).ready(function (){

            "use strict";

            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });

            if(!{{ $general->dark }}){
                $('#version').addClass('light-version');
                $('.logo img').attr('src', '{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}');

            }else{
                $('#version').removeClass('light-version');
                $('.logo img').attr('src', '{{getImage(imagePath()['logoIcon']['path'] .'/darkLogo.png')}}');
            }

        });
    </script>

</body>
</html>
