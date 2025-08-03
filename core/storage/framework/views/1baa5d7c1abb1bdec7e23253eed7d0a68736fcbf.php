<?php
    $bgImage = getContent('authentication.content', true);
?>

<?php $__env->startSection('content'); ?>
<!-- Account Section Starts Here -->
<div class="account-section bg-img" style="background-image: url(<?php echo e(getImage('assets/images/frontend/authentication/' .@$bgImage->data_values->image)); ?>); background-position: center; background-repeat: no-repeat; background-size: cover;">

    <div class="left">
        <div class="left-inner w-100">
            <div class="logo text-center mb-lg-5 mb-4">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('caminho/para/sua/imagem.png')); ?>" alt="<?php echo app('translator')->get('logo'); ?>" style="max-width: 200px; display: block; margin: 0 auto;">
                </a>
            </div>
            <form class="account-form row g-4" method="POST" action="<?php echo e(route('user.login')); ?>" onsubmit="return submitUserForm();">
                <?php echo csrf_field(); ?>
                <div class="col-md-12">
                    <label for="username" class="form--label"><?php echo app('translator')->get('Username or Email'); ?></label>
                    <input type="text" id="username" name="username" value="<?php echo e(old('username')); ?>" class="form-control form--control" required>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                    <input id="password" type="password" class="form-control form--control" name="password" required>
                </div>
                <!--<div class="col-md-12 g-cap">
                    <?php echo loadReCaptcha() ?>
                </div>

                <?php echo $__env->make($activeTemplate.'partials.custom_captcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->

                <div class="col-lg-12 text-end mt-0">
                    <a href="<?php echo e(route('user.password.request')); ?>" class="text--base">
                        <?php echo app('translator')->get('Forgot Password'); ?> ?
                    </a>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center"><?php echo app('translator')->get('Sign In'); ?></button>
                </div>
                <p class="mt-2"><?php echo app('translator')->get("Don't have an account"); ?>?.
                    <a href="<?php echo e(route('user.register')); ?>" class="text--base">
                        <?php echo app('translator')->get('Create Account'); ?>
                    </a>
                </p>
            </form>
        </div>
    </div>
    <div class="right text-center">
        <div class="right-inner w-100">
            <h4 class="title text-white"><?php echo app('translator')->get('Área de Login'); ?></h4>
        </div>
    </div>
</div>
<!-- Account Section Ends Here -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .account-section {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger"><?php echo app('translator')->get("Captcha field is required."); ?></span>';
                return false;
            }
            return true;
        }

        $('#rc-anchor-container').css({
            width: '100% !important'
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/login.blade.php ENDPATH**/ ?>