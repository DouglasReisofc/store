

<?php
    $policyPages = getContent('policy_pages.element');
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
                <form class="account-form row g-4" action="<?php echo e(route('user.register')); ?>" method="POST" onsubmit="return submitUserForm();">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-6">
                        <label for="firstname" class="form--label"><?php echo app('translator')->get('First Name'); ?></label>
                        <input id="firstname" type="text" class="form-control form--control" name="firstname" value="<?php echo e(old('firstname')); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form--label"><?php echo app('translator')->get('Last Name'); ?></label>
                        <input id="lastname" type="text" class="form-control form--control" name="lastname" value="<?php echo e(old('lastname')); ?>" required>
                    </div>
                    
                    <div class="col-md-6 visually-hidden">
                        <label for="country" class="form--label"><?php echo app('translator')->get('Country'); ?></label>
                        <div class="select-item">
                            <select name="country" id="country" class="form--control select-bar m-0">
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-mobile_code="<?php echo e($country->dial_code); ?>" value="<?php echo e($country->country); ?>" data-code="<?php echo e($key); ?>"><?php echo e(__($country->country)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
<div class="col-md-6">
    <label for="mobile" class="form--label"><?php echo app('translator')->get('Mobile'); ?>
        <small class="text-danger mobileExist"></small>
    </label>
    <div class="input-group">
        <span class="input-group-text visually-hidden" id="basic-addon1"></span>
        <input type="tel" name="mobile" id="mobile" value="<?php echo e(old('mobile')); ?>" class="form-control form--control checkUser" placeholder="<?php echo app('translator')->get('11 97129-XXXX'); ?>">
    </div>
    <input type="hidden" name="mobile_code">
    <input type="hidden" name="country_code">
</div>



                    <div class="col-md-6">
                        <label for="username" class="form--label"><?php echo app('translator')->get('Username'); ?>
                            <small class="text-danger usernameExist"></small>
                        </label>
                        <input id="username" type="text" class="form-control form--control checkUser" name="username" value="<?php echo e(old('username')); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form--label"><?php echo app('translator')->get('E-Mail Address'); ?></label>
                        <input id="email" type="email" class="form-control form--control checkUser" name="email" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    <div class="col-md-6 hover-input-popup">
                        <label for="password" class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                        <input id="password" type="password" class="form-control form--control" name="password" required>
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
                    <div class="col-md-6">
                        <label for="password-confirm" class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                        <input id="password-confirm" type="password" class="form-control form--control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <!--<div class="col-md-12">
                        <?php echo loadReCaptcha() ?>
                    </div>

                    <?php echo $__env->make($activeTemplate.'partials.custom_captcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->

                    <div class="col-md-12">
                        <button type="submit" class="cmn--btn btn--lg w-100 justify-content-center"><?php echo app('translator')->get('Sign Up'); ?></button>
                    </div>
                    <p class="mt-2"><?php echo app('translator')->get('Already have an account'); ?>?
                        <a href="<?php echo e(route('user.login')); ?>" class="text--base">
                            <?php echo app('translator')->get('Sign In'); ?>
                        </a></p>
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between">
                            <?php if($general->agree): ?>
                                <div class="form-check form--check">
                                    <input class="form-check-input" type="checkbox" name="agree" id="tos">
                                    <label class="form-check-label" for="tos">
                                        <?php echo app('translator')->get('I accept all'); ?>
                                        <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singlepage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('policy.page', ['slug'=>slug($singlepage->data_values->title), 'id'=>$singlepage->id])); ?>" class="text--base" target="_blank">
                                                <?php echo e(__($singlepage->data_values->title)); ?>

                                            </a>
                                            <?php echo e($loop->last ? '' : ', '); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="right text-center">
            <div class="right-inner w-100">
                <h4 class="title text-white"><?php echo app('translator')->get('Área de Cadastro'); ?></h4>
            </div>
        </div>
    </div>
    <!-- Account Section Ends Here -->

    <div class="modal fade cmn--modal" id="existModalCenter" tabindex="-1" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('You are with us'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo app('translator')->get('You already have an account please Sign in'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <a href="<?php echo e(route('user.login')); ?>" class="btn btn--success"><?php echo app('translator')->get('Login'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

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
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger"><?php echo app('translator')->get("Captcha field is required."); ?></span>';
                return false;
            }
            return true;
        }

        (function ($) {
            <?php if($mobile_code): ?>
            $(`option[data-code=<?php echo e($mobile_code); ?>]`).attr('selected', '');
            <?php endif; ?>

            $('select[name=country]').change(function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            <?php if($general->secure_password): ?>
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });
            <?php endif; ?>

            $('.checkUser').on('focusout', function (e) {
                var url = '<?php echo e(route('user.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile: mobile, _token: token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email: value, _token: token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username: value, _token: token}
                }
                $.post(url, data, function (response) {
                    if (response['data'] && response['type'] == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} Já Existe !!`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);

        document.addEventListener('DOMContentLoaded', function () {
            // Seletor do input de número de telefone
            var mobileInput = document.getElementById('mobile');

            // Adiciona um listener para o evento 'input'
            mobileInput.addEventListener('input', function () {
                // Remove todos os caracteres não numéricos
                mobileInput.value = mobileInput.value.replace(/\D/g, '');
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/register.blade.php ENDPATH**/ ?>