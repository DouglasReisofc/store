<?php
	$captcha = loadCustomCaptcha();
?>
<?php if($captcha): ?>
    <div class="col-md-12 captha">
        <?php echo $captcha ?>
    </div>
    <div class="col-md-12">
        <input type="text" name="captcha" class="form-control form--control">
    </div>
<?php endif; ?>

<?php $__env->startPush('style'); ?>
<style>
    .captha div{
        width: 100% !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/partials/custom_captcha.blade.php ENDPATH**/ ?>