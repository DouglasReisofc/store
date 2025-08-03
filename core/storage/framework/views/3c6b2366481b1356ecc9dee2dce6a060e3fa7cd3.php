<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Subject'); ?></th>
                                <th><?php echo app('translator')->get('Submitted By'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Priority'); ?></th>
                                <th><?php echo app('translator')->get('Last Reply'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('Subject'); ?>">
                                        <a href="<?php echo e(route('admin.ticket.view', $item->id)); ?>" class="font-weight-bold"> [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($item->ticket); ?>] <?php echo e($item->subject); ?> </a>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Submitted By'); ?>">
                                        <?php if($item->user_id): ?>
                                        <a href="<?php echo e(route('admin.users.detail', $item->user_id)); ?>"> <?php echo e(@$item->user->fullname); ?></a>
                                        <?php else: ?>
                                            <p class="font-weight-bold"> <?php echo e($item->name); ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                        <?php if($item->status == 0): ?>
                                            <span class="badge badge--success"><?php echo app('translator')->get('Open'); ?></span>
                                        <?php elseif($item->status == 1): ?>
                                            <span class="badge  badge--primary"><?php echo app('translator')->get('Answered'); ?></span>
                                        <?php elseif($item->status == 2): ?>
                                            <span class="badge badge--warning"><?php echo app('translator')->get('Customer Reply'); ?></span>
                                        <?php elseif($item->status == 3): ?>
                                            <span class="badge badge--dark"><?php echo app('translator')->get('Closed'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Priority'); ?>">
                                        <?php if($item->priority == 1): ?>
                                            <span class="badge badge--dark"><?php echo app('translator')->get('Low'); ?></span>
                                        <?php elseif($item->priority == 2): ?>
                                            <span class="badge  badge--warning"><?php echo app('translator')->get('Medium'); ?></span>
                                        <?php elseif($item->priority == 3): ?>
                                            <span class="badge badge--danger"><?php echo app('translator')->get('High'); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Last Reply'); ?>">
                                        <?php echo e(diffForHumans($item->last_reply)); ?>

                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                        <a href="<?php echo e(route('admin.ticket.view', $item->id)); ?>" class="icon-btn  ml-1" data-toggle="tooltip" title="" data-original-title="<?php echo app('translator')->get('Details'); ?>">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    <?php echo e(paginateLinks($items)); ?>

                </div>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/support/tickets.blade.php ENDPATH**/ ?>