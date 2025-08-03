<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Subcategoria'); ?></th>
                                    <th><?php echo app('translator')->get('ID'); ?></th>
                                    <th><?php echo app('translator')->get('Comprador'); ?></th>
                                    <th><?php echo app('translator')->get('Dias Restantes'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $vencimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vencimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('Subcategoria'); ?>"><?php echo e($vencimento->subCategory->name ?? 'N/A'); ?></td>
                                    <td data-label="<?php echo app('translator')->get('ID'); ?>"><?php echo e($vencimento->trx ?? __('N/A')); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Comprador'); ?>"><?php echo e(optional($vencimento->user)->email ?? 'N/A'); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Dias Restantes'); ?>">
                                        <?php
                                            $hoje = \Carbon\Carbon::now();
                                            $diasRestantes = $hoje->diffInDays($vencimento->card_validity, false);
                                        ?>
                                        <?php if($diasRestantes > 0): ?>
                                            <?php echo e($diasRestantes); ?> <?php echo app('translator')->get('dias'); ?>
                                        <?php else: ?>
                                            <?php echo app('translator')->get('Vencido'); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center"><?php echo app('translator')->get('Nenhuma venda encontrada.'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/card/vendidos.blade.php ENDPATH**/ ?>