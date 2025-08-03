<?php $__env->startSection('content'); ?>
<!-- Dashboard -->
<div class="container">
    <div class="pb-80">
        <div class="row justify-content-center g-4">
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-wallet"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <h6 class="title"><?php echo app('translator')->get('Olá'); ?> <?php echo e($user->username); ?> <br><?php echo app('translator')->get('seu saldo Atual é de'); ?> </h6>
<h4 class="title"><?php echo e($general->cur_sym); ?> <?php echo e(number_format($user->balance, 2)); ?></h4>
                        </div>
                        <br>
                        <a href="<?php echo e(route('user.deposit')); ?>" class="btn btn-custom"><font color="#fff">Adicionar Saldo</font></a>
                        <!--<a href="<?php echo e(route('user.redeemGiftcard')); ?>" class="btn btn-custom"><font color="#fff">Resgatar</font></a>-->
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="fas fa-cart-arrow-down"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="<?php echo e(route('user.card')); ?>">
                            <h6 class="title"><?php echo app('translator')->get('total de contas compradas'); ?> </h6>
                            <br>
                                <h3 class="title rafcounter" data-counter-end="<?php echo e($countCard); ?>">0</h3>
                            </a>
                        </div>
                        <br>
                        <a href="<?php echo e(route('card')); ?>" class="btn btn-custom"><font color="#fff"><?php echo app('translator')->get('Comprar Conta'); ?></font></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-exchange-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="<?php echo e(route('user.trx.log')); ?>">
                            <h6 class="title"><?php echo app('translator')->get('Você tem Um histórico de'); ?> </h6>
                            <br>
                                <h3 class="title rafcounter" data-counter-end="<?php echo e($countTrx); ?>">0</h3>
                            </a>
                        </div>
                        <a href="<?php echo e(route('user.trx.log')); ?>"><h6 class="title"><?php echo app('translator')->get('Transaction'); ?></a></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xxl-3">
                <div class="dashboard__item bg--section">
                    <span class="dashboard__icon bg--base">
                        <i class="las la-ticket-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__header">
                            <a href="<?php echo e(route('ticket')); ?>">
                    <h6 class="title"><?php echo app('translator')->get('Ticket'); ?> </h6>
                    <br>
                                <h3 class="title rafcounter" data-counter-end="<?php echo e($countTicket); ?>">0</h3>
                            </a>
                        </div>
                        <br>
                    <a href="<?php echo e(route('ticket.open')); ?>" class="btn btn-custom"><font color="#fff"><?php echo app('translator')->get('Solicitar suporte'); ?></font></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="title mb-3"><?php echo app('translator')->get('Latest Transaction Logs'); ?></h5>
    <table class="table cmn--table">
        <thead>
            <tr>
                <th><?php echo app('translator')->get('Date'); ?></th>
                <th><?php echo app('translator')->get('Trx'); ?></th>
                <th><?php echo app('translator')->get('Amount'); ?></th>
                <th><?php echo app('translator')->get('Post Balance'); ?></th>
                <th><?php echo app('translator')->get('Details'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $latestTrxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td data-label="<?php echo app('translator')->get('Date'); ?>">
                   <?php echo e(showDateTime($trx->created_at)); ?>

                </td>
                <td data-label="<?php echo app('translator')->get('Trx'); ?>">
                   <?php echo e($trx->trx); ?>

                </td>
                <td data-label="<?php echo app('translator')->get('Amount'); ?>">
                    <strong>
                        <?php echo e(showAmount($trx->amount, 2)); ?>

                        <?php echo e(__($general->cur_text)); ?>

                    </strong>
                </td>
                <td data-label="<?php echo app('translator')->get('Post Balance'); ?>">
                    <strong>
                        <?php echo e(showAmount($trx->post_balance, 2)); ?>

                        <?php echo e(__($general->cur_text)); ?>

                    </strong>
                </td>
                <td data-label="<?php echo app('translator')->get('Details'); ?>">
                    <?php echo e(__($trx->details)); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="100%"><?php echo app('translator')->get('Data Not Found'); ?></td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</div>
<!-- Dashboard -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/dashboard.blade.php ENDPATH**/ ?>