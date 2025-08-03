<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="redeem-giftcard-container bg--section">
                <h6 class="title"><?php echo app('translator')->get('Resgatar Saldo'); ?></h6>
                <div class="money-penguin-gif"></div> <!-- GIF de erro -->
                <form method="POST" action="<?php echo e(route('user.redeemGiftcard.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <input id="code" type="text" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="code" placeholder="<?php echo app('translator')->get('Código de Resgate'); ?>" value="<?php echo e(old('code')); ?>" required autocomplete="code" autofocus>
                        <?php $__errorArgs = ['code'];
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
                    <button type="submit" class="cmn--btn">
                        <?php echo app('translator')->get('Resgatar'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php if(session('success') || session('error')): ?>
    <div id="messageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(session('success') ? 'Success' : 'Error'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalButton">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
<?php if(session('success')): ?>
    <div class="success-gif"></div> <!-- GIF de sucesso -->
    <p><?php echo e(session('success')); ?></p>
    <p>Valor do Resgate: <?php echo e(session('giftcard_amount')); ?></p>
    <p>Seu saldo após o resgate: <?php echo e(session('balance')); ?></p>
<?php else: ?>
    <div class="error-gif"></div> <!-- GIF de erro -->
    <p><?php echo e(session('error')); ?></p>
<?php endif; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalFooterButton"><?php echo app('translator')->get('Close'); ?></button> <!-- Corrigido aqui -->
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            // Abra o modal quando a página carregar
            $('#messageModal').modal('show');

            // Feche o modal quando o botão "Close" no canto superior for clicado
            $('#closeModalButton').on('click', function() {
                $('#messageModal').modal('hide');
            });

            // Feche o modal quando o botão na parte de baixo for clicado
            $('#closeModalFooterButton').on('click', function() {
                $('#messageModal').modal('hide');
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/redeem_giftcard.blade.php ENDPATH**/ ?>