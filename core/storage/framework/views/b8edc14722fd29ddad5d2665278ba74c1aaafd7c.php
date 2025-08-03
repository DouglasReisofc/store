<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="profile-wrapper bg--section">
        <div class="profile-user mb-lg-0">
            <div class="thumb">
                <img src="<?php echo e(getImage(imagePath()['profile']['user']['path'].'/'. @$user->image,imagePath()['profile']['user']['size'])); ?>" alt="<?php echo app('translator')->get('user'); ?>">
            </div>
            <div class="content">
                <h6 class="title"><?php echo app('translator')->get('Name'); ?>: <?php echo e(__($user->fullname)); ?></h6>
                <span class="subtitle"><?php echo app('translator')->get('Username'); ?>: <?php echo e(__($user->username)); ?></span>
            </div>
            <div class="remove-image">
                <i class="las la-times"></i>
            </div>
        </div>
        <div class="profile-form-area">
            <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form--group col-md-6">
                    <label class="form--label" for="InputFirstname"><?php echo app('translator')->get('First Name'); ?></label>
                    <input type="text" class="form-control form--control" id="InputFirstname" name="firstname"
                     value="<?php echo e($user->firstname); ?>" minlength="3">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="lastname"><?php echo app('translator')->get('Last Name'); ?></label>
                    <input type="text" class="form-control form--control" id="lastname" name="lastname" value="<?php echo e($user->lastname); ?>" required>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="email"><?php echo app('translator')->get('E-mail Address'); ?></label>
                    <input class="form-control form--control" id="email" value="<?php echo e($user->email); ?>" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="phone"><?php echo app('translator')->get('Mobile Number'); ?></label>
                    <input class="form-control form--control" id="phone" value="<?php echo e($user->mobile); ?>" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="address"><?php echo app('translator')->get('Address'); ?></label>
                    <input type="text" class="form-control form--control" id="address" name="address" placeholder="<?php echo app('translator')->get('Address'); ?>" value="<?php echo e(@$user->address->address); ?>" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="state"><?php echo app('translator')->get('State'); ?></label>
                    <input type="text" class="form-control form--control" id="state" name="state" placeholder="<?php echo app('translator')->get('state'); ?>" value="<?php echo e(@$user->address->state); ?>" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="zip"><?php echo app('translator')->get('Zip Code'); ?></label>
                    <input type="text" class="form-control form--control" id="zip" name="zip" placeholder="<?php echo app('translator')->get('Zip Code'); ?>" value="<?php echo e(@$user->address->zip); ?>" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="city"><?php echo app('translator')->get('City'); ?></label>
                    <input type="text" class="form-control form--control" id="city" name="city" placeholder="<?php echo app('translator')->get('City'); ?>" value="<?php echo e(@$user->address->city); ?>" required="">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="country"><?php echo app('translator')->get('Country'); ?></label>
                    <input class="form-control form--control" id="country" value="<?php echo e(@$user->address->country); ?>" disabled>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label" for="profile-image">Alterar foto do perfil</label>
                    <input type="file" class="form-control form--control" name="image" id="profile-image" accept="image/*">
                </div>
                <div class="form--group w-100 col-md-6 mb-0 text-end">
                    <button type="submit" class="cmn--btn"><?php echo app('translator')->get('Update Profile'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset($activeTemplateTrue.'css/bootstrap-fileinput.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/build/css/intlTelInput.css')); ?>">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;!important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/profile_setting.blade.php ENDPATH**/ ?>