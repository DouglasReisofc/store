<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo app('translator')->get('Produto'); ?></th>
                            <th><?php echo app('translator')->get('Vencimento'); ?></th>
                            <th><?php echo app('translator')->get('Trx'); ?></th>
                            <th><?php echo app('translator')->get('Details'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('Produto'); ?>">
                                <?php echo e(__($data->subCategory->name)); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Vencimento'); ?>">
                                <?php
                                    // Certifique-se que card_validity é uma instância de Carbon ou converta usando Carbon::parse()
                                    $hoje = \Carbon\Carbon::now();
                                    $dataVencimento = \Carbon\Carbon::parse($data->card_validity);
                                    $diasRestantes = $hoje->diffInDays($dataVencimento, false);
                                    $isExpired = $diasRestantes < 0;
                                    $isCloseToExpire = $diasRestantes >= 0 && $diasRestantes <= 5;
                                ?>
                                <span class="<?php echo e($isCloseToExpire || $isExpired ? 'text-danger' : 'text-primary'); ?>">
                                    <?php echo e($isExpired ? '0' : $diasRestantes); ?> <?php echo app('translator')->get('dias'); ?>
                                </span>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Trx'); ?>">
                                <?php echo e($data->trx); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Details'); ?>">
                                <a href="<?php echo e(route('user.card.details', $data->id)); ?>" class="bg--primary text-white btn-sm">
                                    <i class="fas fa-folder-open"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4"><?php echo app('translator')->get('Data Not Found'); ?>!</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($cards->count() > 0): ?>
                <?php echo e($cards->links()); ?>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/card.blade.php ENDPATH**/ ?>