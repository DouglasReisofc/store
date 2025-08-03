

<?php $__env->startSection('content'); ?>
<div class="payment-section ptb-80">
    <div class="container">

        <div class="row justify-content-center">
            <?php echo app('translator')->get('Current Balance'); ?> - <?php echo e(__($general->cur_sym)); ?> <?php echo e(showAmount(Auth::user()->balance, 2)); ?>

            <div class="col-lg-6">
                <div class="select-item">
                    <select class="method form--control select-bar m-0">
                        <option value="">
                            <?php echo app('translator')->get('Select Payment Gateway'); ?>
                        </option>
                        
                        <?php $__currentLoopData = $gatewayCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($loop->index + 1); ?>"
                                data-name="<?php echo e($data->name); ?>"
                                data-currency="<?php echo e($data->currency); ?>"
                                data-method_code="<?php echo e($data->method_code); ?>"
                                data-min_amount="<?php echo e(showAmount($data->min_amount)); ?>"
                                data-max_amount="<?php echo e(showAmount($data->max_amount)); ?>"
                                data-base_symbol="<?php echo e($data->baseSymbol()); ?>"
                                data-fix_charge="<?php echo e(showAmount($data->fixed_charge)); ?>"
                                data-percent_charge="<?php echo e(showAmount($data->percent_charge)); ?>"
                            >
                                <?php echo e(__($data->name)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="mt-4">
                    <button type="submit" class="cmn--btn deposit w-100 justify-content-center">
                        <?php echo app('translator')->get('Pay Now'); ?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade cmn--modal" id="depositModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title method-name" id="depositModalLabel"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('user.deposit.insert')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text--base depositLimit"></p>
                    <p class="text--base depositCharge"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency">
                        <input type="hidden" name="method_code" class="edit-method-code">
                    </div>
                    <div class="form-group">
                        <label class="text--base"><?php echo app('translator')->get('Insira o valor'); ?>:</label>
                        <div class="input-group">
                            <input id="amount" type="text" class="form-control form--control" name="amount" required value="<?php echo e(old('amount')); ?>" inputmode="numeric">
                            <span class="input-group-text bg--base"><?php echo e(__($general->cur_text)); ?></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <div class="prevent-double-click">
                        <button type="submit" class="btn btn--md btn--success"><?php echo app('translator')->get('Confirm'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";

        $('#amount').on('input', function() {
            // Substitua vírgulas por pontos
            var inputValue = $(this).val().replace(',', '.');
            $(this).val(inputValue);
        });

        $('.deposit').on('click', function () {
            var selected =  $(".method option:selected");

            if(!selected.val()){
                return false;
            }

            var name = selected.data('name');
            var currency = selected.data('currency');
            var method_code = selected.data('method_code');
            var minAmount = selected.data('min_amount');
            var maxAmount = selected.data('max_amount');
            var baseSymbol = "<?php echo e($general->cur_text); ?>";
            var fixCharge = selected.data('fix_charge');
            var percentCharge = selected.data('percent_charge');

            var depositLimit = `<?php echo app('translator')->get('Limite de Pagamento'); ?>: ${minAmount} - ${maxAmount}  ${baseSymbol}`;
            $('.depositLimit').text(depositLimit);
            var depositCharge = `<?php echo app('translator')->get('Charge'); ?>: ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
            $('.depositCharge').text(depositCharge);
            $('.method-name').text(`<?php echo app('translator')->get('Pagamento via '); ?> ${name}`);
            $('.currency-addon').text(baseSymbol);
            $('.edit-currency').val(currency);
            $('.edit-method-code').val(method_code);

            $('#depositModal').modal('show');
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/payment/deposit.blade.php ENDPATH**/ ?>