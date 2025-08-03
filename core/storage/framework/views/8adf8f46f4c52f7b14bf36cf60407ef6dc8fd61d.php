<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 col-md-12">
                <?php if(Auth::user()->ts): ?>
                    <div class="card custom--card h-100">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo app('translator')->get('Two Factor Authenticator'); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="two-factor-content">
                                <h6 class="subtitle">
                                    <?php echo app('translator')->get('SUA VERIFICAÇÃO 2FA ESTÁ ATIVADA. SE VOCÊ DESEJA DESATIVAR A VERIFICAÇÃO 2FA, VOCÊ PRECISA DO CÓDIGO AUTENTICADOR DO GOOGLE'); ?>
                                </h6>
                            </div>
                            <div class="form-group mx-auto text-center">
                                <a href="#0" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#disableModal">
                                    <?php echo app('translator')->get('Desative o autenticador de dois fatores'); ?></a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card custom--card h-100">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo app('translator')->get('Autenticador de dois fatores'); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="<?php echo e($secret); ?>" class="form-control form--control form-control-lg" id="referralURL" readonly>
                                    <span class="input-group-text copytext bg--base" id="copyBoard">
                                        <i class="fa fa-copy"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="two-factor-scan text-center my-4">
                                <img class="mx-auto" src="<?php echo e($qrCodeUrl); ?>">
                            </div>
                            <div class="form-group mx-auto text-center">
                                <a href="#0" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#enableModal"><?php echo app('translator')->get('Habilitar Autenticador de Dois Fatores'); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card custom--card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo app('translator')->get('Google Authenticator'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="two-factor-content">
                            <h6 class="subtitle">
                                <?php echo app('translator')->get('USE O AUTENTICADOR DO GOOGLE PARA VERIFICAR O CÓDIGO QR OU USAR O CÓDIGO'); ?>
                            </h6>
                            <p><?php echo app('translator')->get('O Google Authenticator é um aplicativo multifatorial para dispositivos móveis. Ele gera códigos cronometrados usados ​​durante o processo de verificação em duas etapas. Para usar o Google Authenticator, instale o aplicativo Google Authenticator'); ?></p>
                            <a class="cmn--btn" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank"><?php echo app('translator')->get('BAIXAR APLICATIVO'); ?>
                            </a>
                        </div>
                    </div>
                </div><!-- //. single service item -->
            </div>
        </div>
    </div>


    <!--Enable Modal -->
    <div id="enableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo app('translator')->get('Verifique seu OTP'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('user.twofactor.enable')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="<?php echo e($secret); ?>">
                            <input type="text" class="form-control form--control" name="code" placeholder="<?php echo app('translator')->get('Digite o código do autenticador do Google'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--md btn--success"><?php echo app('translator')->get('Verificar'); ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo app('translator')->get('Verify Your Otp Disable'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('user.twofactor.disable')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form--control" name="code" placeholder="<?php echo app('translator')->get('Enter Google Authenticator Code'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--md btn--success"><?php echo app('translator')->get('Verify'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($){
            "use strict";
            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/twofactor.blade.php ENDPATH**/ ?>