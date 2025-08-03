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
            <form class="account-form row g-4" method="POST" action="<?php echo e(route('user.password.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="col-md-12">
                    <label for="type" class="form--label"><?php echo app('translator')->get('Select One'); ?></label>

                    <div class="select-item">
                        <select name="type" id="type" class="form--control select-bar m-0">
                            <option value=""><?php echo app('translator')->get('Select An Option'); ?></option>
                            <option value="email"><?php echo app('translator')->get('E-Mail Address'); ?></option>
                            <option value="username"><?php echo app('translator')->get('Username'); ?></option>
                        </select>
                    </div>

                </div>
                <div class="col-md-12">
                    <label for="input" class="form--label my_value"></label>
                    <input id="input" type="text" class="form-control form--control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="value" required autofocus="off">

                    <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center"><?php echo app('translator')->get('Send Password Code'); ?></button>
                </div>

                <div class="col-md-12">
                    <?php echo app('translator')->get('Enter your email and we’ll help you create a new password'); ?>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- Account Section Ends Here -->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/passwords/email.blade.php ENDPATH**/ ?>