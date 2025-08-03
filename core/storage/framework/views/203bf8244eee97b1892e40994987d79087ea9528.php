<?php $__env->startSection('content'); ?>
    <div class="page-wrapper default-version">
        <div class="form-area bg_img" data-background="<?php echo e(asset('assets/admin/images/1.jpg')); ?>">
            <div class="form-wrapper">
                <h4 class="logo-text mb-15"><?php echo app('translator')->get('Welcome to'); ?> <strong><?php echo e(__($general->sitename)); ?></strong></h4>
                <p><?php echo app('translator')->get('Painel Admin area restrita'); ?></p>
                <form action="<?php echo e(route('admin.login')); ?>" method="POST" class="cmn-form mt-30">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="email"><?php echo app('translator')->get('Username'); ?></label>
                        <input type="text" name="username" class="form-control b-radius--capsule" id="username" value="<?php echo e(old('username')); ?>" placeholder="<?php echo app('translator')->get('Enter your username'); ?>">
                        <i class="las la-user input-icon"></i>
                    </div>
                    <div class="form-group">
                        <label for="pass"><?php echo app('translator')->get('Password'); ?></label>
                        <input type="password" name="password" class="form-control b-radius--capsule" id="pass" placeholder="<?php echo app('translator')->get('Enter your password'); ?>">
                        <i class="las la-lock input-icon"></i>
                    </div>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('admin.password.reset')); ?>" class="text-muted text--small"><i class="las la-lock"></i><?php echo app('translator')->get('Forgot password?'); ?></a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn mt-25 b-radius--capsule"><?php echo app('translator')->get('Login'); ?> <i class="las la-sign-in-alt"></i></button>
                    </div>
                    <p> Se precisar renovar seu painel contate 5592991796111 no whatsapp</p>
                </form>
            </div>
        </div><!-- login-area end -->
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>