<nav aria-label="...">
    <ul class="pagination justify-content-end mb-0">
        <?php if($paginator->onFirstPage()): ?>

        <?php else: ?>
            <li class="page-item ">
                <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" tabindex="-1">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only"><?php echo app('translator')->get('Previous'); ?></span>
                </a>
            </li>
        <?php endif; ?>


        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)">
                        <?php echo e(__($element)); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php if(count($element) < 2): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active">
                                <a class="page-link" href="javascript:void(0)"><?php echo e(__($page)); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="page-item ">
                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e(__($page)); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($paginator->hasMorePages()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only"><?php echo app('translator')->get('Next'); ?></span>
                </a>
            </li>
        <?php else: ?>
            <li>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/partials/paginate.blade.php ENDPATH**/ ?>