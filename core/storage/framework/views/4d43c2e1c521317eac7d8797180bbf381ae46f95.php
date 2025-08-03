<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> <?php echo e($general->sitename(__($pageTitle))); ?></title>
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/line-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/owl.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/nice-select.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/bootstrap-fileinput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/main.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue. 'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color)); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/custom.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>

    <?php echo $__env->yieldPushContent('style'); ?>

</head>

<body id="version">

    <div class="preloader">
        <div class="loader-inner">
            <div class="loader-circle">
                <img src="<?php echo e(asset('assets/images/logoIcon/favicon.png')); ?>" alt="<?php echo app('translator')->get('Preloader'); ?>">
            </div>
            <div class="loader-line-mask">
            <div class="loader-line"></div>
            </div>
        </div>
    </div>

    <a href="#0" class="scrollToTop"><i class="las la-angle-up"></i></a>
    <div class="overlay"></div>

    <?php echo $__env->yieldContent('content'); ?>

    <?php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    ?>

    <!-- cookies default start -->
    <?php if(@$cookie->data_values->status && !session('cookie_accepted')): ?>

    <div class="cookies-card bg--default radius--10px text-center style--lg">
      <div class="cookies-card__icon">
        <i class="fas fa-cookie-bite"></i>
      </div>
      <div class="cookies-card__content">
      <h5 class="text-dark mb-2"><?php echo app('translator')->get('Cookie Policy'); ?></h5>
      <p><?php echo @$cookie->data_values->description ?></p>
       or <a href="<?php echo e(@$cookie->data_values->link); ?>" target="_blank"><?php echo app('translator')->get('Read Policy'); ?></a>
    </div>
      <div class="cookies-card__btn">
        <a href="<?php echo e(route('cookie.accept')); ?>" class="cookies-btn"><?php echo app('translator')->get('Accept'); ?></a>
      </div>
    </div>
    <?php endif; ?>
    <!-- cookies default end -->

    <script>
        "use strict";
        function setVersion(){
            if(!<?php echo e($general->dark); ?>){
                $('#version').addClass('light-version');
                $('.logo img').attr('src', '<?php echo e(getImage(imagePath()['logoIcon']['path'] .'/logo.png')); ?>');

            }else{
                $('#version').removeClass('light-version');
                $('.logo img').attr('src', '<?php echo e(getImage(imagePath()['logoIcon']['path'] .'/darkLogo.png')); ?>');
            }
        }
    </script>

    <script src="<?php echo e(asset($activeTemplateTrue.'js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/rafcounter.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/nice-select.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/owl.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/main.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <?php echo $__env->yieldPushContent('script'); ?>

    <?php echo $__env->make('partials.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        $(document).ready(function (){

            "use strict";

            if(!<?php echo e($general->dark); ?>){
                $('#version').addClass('light-version');
                $('.logo img').attr('src', '<?php echo e(getImage(imagePath()['logoIcon']['path'] .'/logo.png')); ?>');

            }else{
                $('#version').removeClass('light-version');
                $('.logo img').attr('src', '<?php echo e(getImage(imagePath()['logoIcon']['path'] .'/darkLogo.png')); ?>');
            }

        });
    </script>

</body>
</html>
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/layouts/auth_master.blade.php ENDPATH**/ ?>