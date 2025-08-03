<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="table-responsive">
            <table class="table cmn--table">
            <thead class="thead-dark">
              <tr>
                <th><?php echo app('translator')->get('Date'); ?></th>
                <th><?php echo app('translator')->get('Trx'); ?></th>
                <th><?php echo app('translator')->get('Amount'); ?></th>
                <th><?php echo app('translator')->get('Charge'); ?></th>
                <th><?php echo app('translator')->get('Post Balance'); ?></th>
                <th><?php echo app('translator')->get('Details'); ?></th>
              </tr>
            </thead>
            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td data-label="<?php echo app('translator')->get('Date'); ?>">
                    <?php echo e(showDateTime($data->created_at)); ?>

                </td>
                <td data-label="<?php echo app('translator')->get('Trx'); ?>"><?php echo e($data->trx); ?></td>
                <td data-label="<?php echo app('translator')->get('Amount'); ?>">
                    <strong>
                        <?php echo e($data->trx_type); ?>

                        <?php echo e(showAmount($data->amount)); ?>

                        <?php echo e(__($general->cur_text)); ?>

                    </strong>
                </td>
                <td data-label="<?php echo app('translator')->get('Charge'); ?>"><?php echo e(showAmount($data->charge)); ?> <?php echo e(__($general->cur_text)); ?></td>
                <td data-label="<?php echo app('translator')->get('Post Balance'); ?>">
                    <strong>
                        <?php echo e(showAmount($data->post_balance)); ?>

                        <?php echo e(__($general->cur_text)); ?>

                    </strong>
                </td>
                <td data-label="<?php echo app('translator')->get('Details'); ?>"><?php echo e(__($data->details)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                </tr>
            <?php endif; ?>

            </tbody>
          </table>
        </div>

        <?php echo e($logs->links()); ?>


      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/trx_log.blade.php ENDPATH**/ ?>