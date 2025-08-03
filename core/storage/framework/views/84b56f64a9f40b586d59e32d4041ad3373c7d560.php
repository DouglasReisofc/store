

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
            <form class="account-form row g-4" id="smsForm" action="<?php echo e(route('user.verify.sms')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="col-md-12 text-center">
                    <label for="username" class="form--label"><?php echo app('translator')->get('Telefone/whatsapp'); ?>:
                        <strong><?php echo e(auth()->user()->mobile); ?></strong>
                    </label>
                    <!-- Altere o botão para um link -->
                <div class="col-md-12">
                    <a href="#" id="changeMobileLink"><?php echo app('translator')->get('Alterar'); ?></a>
                </div>
                </div>

                <div class="col-md-12">
                    <label for="code" class="form--label"><?php echo app('translator')->get('Verification Code'); ?></label>
                    <input type="text" name="sms_verified_code" id="code" class="form-control form--control">
                </div>
                <div class="col-md-12">
                    <button type="button" class="cmn--btn btn--lg w-100 justify-content-center" id="submitBtn"><?php echo app('translator')->get('Submit'); ?></button>
                </div>
                <div class="col-md-12">
                    <?php echo app('translator')->get('Se você não receber nenhum código'); ?>
                    <a href="<?php echo e(route('user.send.verify.code')); ?>?type=phone" class="text--base">
                        <?php echo app('translator')->get('Try again'); ?>
                    </a>

                    <?php if($errors->has('resend')): ?>
                        <br/>
                        <small class="text-danger"><?php echo e($errors->first('resend')); ?></small>
                    <?php endif; ?>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changeMobileModal" tabindex="-1" role="dialog" aria-labelledby="changeMobileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeMobileModalLabel"><?php echo app('translator')->get('Alterar número de Telefone'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Adicione um formulário para editar o número de telefone aqui -->
                <form action="<?php echo e(route('user.send.verify.mobile')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="type" value="phone">
                    <div class="col-md-12">
                        <label for="new_mobile_modal" class="form--label"><?php echo app('translator')->get('Seu novo número'); ?></label>
                        <input type="tel" required="required" maxlength="11" name="new_mobile" id="new_mobile_modal" class="form-control form--control" placeholder="<?php echo app('translator')->get('(xx) 9xxxx-xxxx'); ?>" value="">
                        <small class="form-text text-muted">Digite apenas o DDD e o número, sem espaços ou caracteres especiais.</small>
                    </div>
                    <button type="submit" class="btn btn--base btn-block mt-3"><?php echo app('translator')->get('Alterar'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function($){
        "use strict";

        // Abre o modal quando o link é clicado
        $('#changeMobileLink').on('click', function (e) {
            e.preventDefault(); // Evita que o link seja seguido
            $('#changeMobileModal').modal('show');
        });

        // Fecha o modal quando o botão é clicado
        $('#closeModalBtn').on('click', function () {
            $('#changeMobileModal').modal('hide');
        });

        // Envie o formulário quando o botão de envio do modal é clicado
        $('#submitBtn').on('click', function () {
            $('#smsForm').submit();
        });

        $('#code').on('input change', function () {
            var xx = document.getElementById('code').value;
            $(this).val(function (index, value) {
                value = value.substr(0, 7);
                return value.replace(/\D/g, '').replace(/(.{3})/g, '$1 ');
            });
        });

        var newMobileModal = $('#new_mobile_modal');

        // Certifica-se de que apenas números sejam inseridos no campo do modal
        newMobileModal.on('input', function () {
            var input = $(this);
            var value = input.val().replace(/\D/g, '');

            // Atualiza o valor no campo
            input.val(value);
        });
    })(jQuery)
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate .'layouts.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/auth/authorization/sms.blade.php ENDPATH**/ ?>