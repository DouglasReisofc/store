<?php $__env->startSection('content'); ?>
<style>
    @keyframes  colorChange {
        0% { color: rgb(255, 0, 0); }
        50% { color: rgb(0, 255, 0); }
        100% { color: rgb(255, 0, 0); }
    }
</style>

<div class="<?php echo e(Auth::user() ? '' : 'pt-80 pb-80'); ?>">
    <div class="deposit-preview bg--section">
        <div class="deposit-thumb">
            <img src="<?php echo e(getImage(imagePath()['sub_category']['path'].'/'.$subCategory->image)); ?>" alt="payment">
        </div>
        <div class="deposit-content text-center">
            <form action="<?php echo e(route('user.card.purchase')); ?>" method="post" class="form">
                <?php echo csrf_field(); ?>
                <input type="hidden" required name="id" value="<?php echo e($subCategory->id); ?>">
                <ul>
                    <li>
                        <?php echo app('translator')->get('Category'); ?>: <span class="text--success">
                            <?php echo e(__($subCategory->category->name)); ?>

                        </span>
                    </li>
                    <li>
                        <?php echo app('translator')->get('Sub Category'); ?>: <span class="text--success">
                            <?php echo e(__($subCategory->name)); ?>

                        </span>
                    </li>
                    <li>
                        <?php echo app('translator')->get('Price'); ?>: <span class="text--success">
                            <?php echo e(showAmount($subCategory->price)); ?> <?php echo e(__($general->cur_text)); ?>

                        </span>
                    </li>
                    <li>
                        <?php echo app('translator')->get('Available'); ?>: <span class="text--success">
                          <?php
$totalDisponiveis = 0;
?>

<?php $__currentLoopData = $subCategory->card; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    <?php if($singleCard->user_id == 0 && $singleCard->revender == 0): ?>
        <?php $totalDisponiveis++; ?>
    <?php endif; ?>

    
    <?php if($singleCard->revender == 1): ?>
        <?php $totalDisponiveis += intval($singleCard->disponivel); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php echo e($totalDisponiveis); ?>

                        </span>
                    </li>
                    <li>
                        <span class="d-block mb-2"><?php echo app('translator')->get('Quantity'); ?>:</span>
                        <div class="quantity quantity-wrapper">
                            <input type="number" name="quantity" value="1" min="1" class="text--base text-center bg-transparent border-0">
                        </div>
                    </li>
                </ul>
                <input type="hidden" name="client_ip" id="client_ip" value="">
                <button type="submit" class="cmn--btn w-100 justify-content-center mt-3"><?php echo app('translator')->get('Comprar'); ?></button>
            </form>
            <div class="sub-category-details mt-5 text-center">
                <h5 class="mb-2 text-sm" style="color: rgb(255, 0, 0); animation: colorChange 8s infinite; margin-bottom: 1.5rem;"><?php echo app('translator')->get('DESCRIÇÃO DO ANÚNCIO'); ?></h5>
                <br>
                <p class="text-sm" style="font-size: 0.8rem;"><?php echo nl2br(e($subCategory->detalhes)); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cmn--modal" id="confirm" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title"><?php echo app('translator')->get('Confirmation'); ?></h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <?php echo app('translator')->get('Você tem certeza que deseja comprar este item ?'); ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
            <div class="prevent-double-click">
                <button type="submit" class="btn btn--success confirmBtn"><?php echo app('translator')->get('Confirm'); ?></button>
            </div>
        </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>

    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="fa fa-plus"></i></div><div class="quantity-button quantity-down"><i class="fa fa-minus"></i></div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function () {
        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.on('click', function () {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.on('click', function () {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });
    });

    $('.form').on('submit', function(e){
        e.preventDefault();
        $('#confirm').modal('show');

        $('.confirmBtn').on('click', function(){
            e.currentTarget.submit();
        });
    });
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('client_ip').value = data.ip;
        })
        .catch(err => {
            console.error('Erro ao obter IP:', err);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($extends, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/card_details.blade.php ENDPATH**/ ?>