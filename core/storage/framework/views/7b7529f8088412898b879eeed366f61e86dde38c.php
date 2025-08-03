<?php
    $work = getContent('howToWork.content', true);
    $works = getContent('howToWork.element');
?>
<!-- How Section -->
<section class="how-section pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category"><?php echo e(__(@$work->data_values->title)); ?></span>
                    <h3 class="section__title"><?php echo e(__(@$work->data_values->heading)); ?></h3>
                    <p>
                        <?php echo e(__(@$work->data_values->sub_heading)); ?>

                    </p>
                </div>
            </div>
        </div>
        <div class="row g-0 gy-5 justify-content-center">

            <?php $__currentLoopData = $works->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleWork): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4">
                    <div class="how__item">
                        <div class="shape-bg">
                            <?php if($loop->odd): ?>
                                <img src="<?php echo e($activeTemplateTrue.'css/icons/how-shape.png'); ?>" alt="css">
                            <?php else: ?>
                                <img src="<?php echo e($activeTemplateTrue.'css/icons/how-shape2.png'); ?>" alt="css">
                            <?php endif; ?>
                        </div>
                        <div class="how__thumb">
                            <?php
                                echo $singleWork->data_values->icon;
                            ?>
                        </div>
                        <div class="how__content">
                            <h5 class="title"><?php echo e(__($singleWork->data_values->text)); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</section>
<!-- How Section -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/sections/howToWork.blade.php ENDPATH**/ ?>