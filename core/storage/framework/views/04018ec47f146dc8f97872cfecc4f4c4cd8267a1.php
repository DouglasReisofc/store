<?php $__env->startSection('content'); ?>
<style>
    .deposit-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 2px solid #ddd;
        padding: -300px;
        border-radius: 15px;
        margin: -100px 0 300%; /* Ajuste este valor conforme necessário */
    }

    #deposit-thumb {
        max-width: 100%;
        height: auto;
        overflow: hidden;
        border-radius: 50%;
        margin-bottom: 15px; /* Ajuste este valor conforme necessário */
    }

    .deposit-thumb img {
    max-width: 100%;
        height: auto;
        height: auto; /* Ajuste para altura automática para manter a proporção */
        object-fit: contain; /* Alterado para 'contain' para ajustar a imagem mantendo a proporção */
        border-radius: 0%; /* Para garantir que a imagem seja circular */
    }

    .deposit-content {
        margin-top: 15px;
    }

    .deposit-content ul {
        list-style: none;
        padding: 0;
    }

    .deposit-content li {
        margin-bottom: 10px;
    }

    .mt-3 {
        margin-top: 15px;
    }
</style>

<!-- Restante do seu código -->

<div class="container">
    <div class="row justify-content-center g-4">
        <div class="col-xxl-6 col-xl-8 col-lg-6">
            <div class="deposit-item">
                <div class="deposit-thumb">
                    <img src="<?php echo e($data->gatewayCurrency()->methodImage()); ?>" alt="<?php echo app('translator')->get('image'); ?>" class="custom-image">
                </div>
                <div class="deposit-content fs-sm">
                    <ul>
                        <li>
                            <?php echo app('translator')->get('Valor'); ?>:
                            <strong><?php echo e(showAmount($data->amount)); ?> </strong> <?php echo e(__($general->cur_text)); ?>

                        </li>
                        <li>
                            <?php echo app('translator')->get('Taxa'); ?>:
                            <strong><?php echo e(showAmount($data->charge)); ?></strong> <?php echo e(__($general->cur_text)); ?>

                        </li>
                        <li>
                            <?php echo app('translator')->get('A pagar'); ?>:
                            <strong> <?php echo e(showAmount($data->amount + $data->charge)); ?></strong> <?php echo e(__($general->cur_text)); ?>

                        </li>
                        <li>
                            <?php echo app('translator')->get('Taxa de conversão'); ?>:
                            <strong>1 <?php echo e(__($general->cur_text)); ?> = <?php echo e(showAmount($data->rate)); ?>  <?php echo e(__($data->baseCurrency())); ?></strong>
                        </li>
                        <li>
                            <?php echo app('translator')->get('Valor Final'); ?> <?php echo e($data->baseCurrency()); ?>:
                            <strong><?php echo e(showAmount($data->final_amo)); ?></strong>
                        </li>
                    </ul>
                    <div class="mt-30">
                        <?php if( 1000 >$data->method_code): ?>
                            <a href="<?php echo e(route('user.deposit.confirm')); ?>" class="cmn--btn w-100 justify-content-center">
                                <?php echo app('translator')->get('Pay Now'); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('user.deposit.manual.confirm')); ?>" class="cmn--btn w-100 justify-content-center">
                                <?php echo app('translator')->get('Pay Now'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/payment/preview.blade.php ENDPATH**/ ?>