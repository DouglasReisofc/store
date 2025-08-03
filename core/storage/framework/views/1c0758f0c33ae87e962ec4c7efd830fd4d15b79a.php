<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row gy-4 justify-content-center">
        <?php if($cardDetail->image): ?>
            <div class="col-lg-4">
                <div class="card custom--card h-100">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo app('translator')->get('Card Image'); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="two-factor-content">
                            <div class="two-factor-scan text-center my-4">
                                <img src="<?php echo e(getImage(imagePath()['vencimento']['path'].'/'.$cardDetail->image, imagePath()['vencimento']['size'])); ?>" alt="<?php echo app('translator')->get('Image'); ?>" class="img-fluid" width="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-8">
            <div class="card custom--card h-100">
                <div class="card-header">
                    <h4 class="card-title"><?php echo app('translator')->get('Card Details'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="two-factor-content">
                        <h6 class="subtitle text-center">
                            <?php echo app('translator')->get('Category'); ?>: <?php echo e(__($cardDetail->subCategory->category->name)); ?>

                            <br>
                            <?php echo app('translator')->get('Sub Category'); ?>: <?php echo e(__($cardDetail->subCategory->name)); ?>

                        </h6>
                        <p class="two__fact__text" id="cardDetails">
                            <?php echo nl2br(__($cardDetail->details)); ?>

                        </p>
                        <button onclick="copyToClipboard('#cardDetails')" class="btn btn-primary">
                            <i class="fa fa-copy"></i> <?php echo app('translator')->get('Copiar'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(element) {
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    alert("<?php echo app('translator')->get('Copiado para area de transferência'); ?>"); // Ou utilize uma notificação mais sofisticada se preferir
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/card_details.blade.php ENDPATH**/ ?>