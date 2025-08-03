<?php
    $bgImage = getContent('authentication.content', true);
?>

<?php $__env->startSection('content'); ?>

<!-- Account Section Starts Here -->
<div class="account-section bg-img" style="background-image: url( <?php echo e(getImage('assets/images/frontend/authentication/' .@$bgImage->data_values->image, '1920x1080')); ?> );">
    <div class="left">
        <div class="left-inner w-100">
                        <div class="logo text-center mb-lg-5 mb-4">
    <a href="<?php echo e(route('home')); ?>">
        <img src="<?php echo e(asset('caminho/para/sua/imagem.png')); ?>" alt="<?php echo app('translator')->get('logo'); ?>" style="max-width: 200px; display: block; margin: 0 auto;">
    </a>
</div>
            <form class="account-form row g-4" method="POST" action="<?php echo e(route('user.password.update')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                <input type="hidden" name="token" value="<?php echo e($token); ?>">
                <div class="col-md-12 hover-input-popup">
                    <label for="password" class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                    <input type="password" id="password" name="password" class="form-control form--control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>

                    <?php if($general->secure_password): ?>
                        <div class="input-popup">
                            <p class="error lower"><?php echo app('translator')->get('1 small letter minimum'); ?></p>
                            <p class="error capital"><?php echo app('translator')->get('1 capital letter minimum'); ?></p>
                            <p class="error number"><?php echo app('translator')->get('1 number minimum'); ?></p>
                            <p class="error special"><?php echo app('translator')->get('1 special character minimum'); ?></p>
                            <p class="error minimum"><?php echo app('translator')->get('6 character password'); ?></p>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="col-md-12">
                    <label for="password-confirm" class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                    <input id="password-confirm" type="password" class="form-control form--control" name="password_confirmation" required required>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center"><?php echo app('translator')->get('Reset Password'); ?></button>
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-between">
                        <a href="<?php echo e(route('user.login')); ?>" class="text--base">
                            <?php echo app('translator')->get('Login Here'); ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Account Section Ends Here -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
<script src="<?php echo e(asset('assets/global/js/secure_password.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";
        <?php if($general->secure_password): ?>
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        <?php endif; ?>
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate .'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/passwords/reset.blade.php ENDPATH**/ ?>