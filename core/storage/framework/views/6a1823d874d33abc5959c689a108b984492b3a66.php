<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="message__chatbox bg--section">

                    <div class="message__chatbox__body">

                        <form action="" method="post" class="register">
                            <?php echo csrf_field(); ?>
                            <div class="form--group">
                                <label for="password" class="form--label"><?php echo app('translator')->get('Current Password'); ?></label>
                                <input id="password" type="password" class="form-control form--control" name="current_password" required autocomplete="current-password">
                            </div>
                            <div class="form--group hover-input-popup">
                                <label for="password" class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                <input id="password" type="password" class="form-control form--control" name="password" required autocomplete="current-password">
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
                            <div class="form--group">
                                <label for="confirm_password" class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                <input id="password_confirmation" type="password" class="form-control form--control" name="password_confirmation" required autocomplete="current-password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="cmn--btn" value="<?php echo app('translator')->get('Change Password'); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/password.blade.php ENDPATH**/ ?>