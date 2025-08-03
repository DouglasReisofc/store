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
            <form class="account-form row g-4" action="<?php echo e(route('user.password.verify.code')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="email" value="<?php echo e($email); ?>">

                <div class="col-md-12">
                    <label for="code" class="form--label"><?php echo app('translator')->get('Verification Code'); ?></label>
                    <input id="code" type="text" class="form-control form--control" name="code" required required>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center"><?php echo app('translator')->get('Verify Code'); ?></button>
                </div>

                <div class="col-md-12">
                    <?php echo app('translator')->get('Check including your Junk/Spam Folder. if not found, you can'); ?>
                    <a href="<?php echo e(route('user.password.request')); ?>" class="text--base">
                        <?php echo app('translator')->get('Try to send again'); ?>
                    </a>
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
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate .'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/passwords/code_verify.blade.php ENDPATH**/ ?>