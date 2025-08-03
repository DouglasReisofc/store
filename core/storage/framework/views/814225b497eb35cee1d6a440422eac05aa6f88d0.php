<?php
    $choose = getContent('choose.content', true);
    $chooses = getContent('choose.element');
?>
<!-- Why Choose Section -->
<section class="why-choose-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-between gy-5">
            <div class="col-lg-5">
                <div class="section__header">
                    <span class="section__category"><?php echo e(__(@$choose->data_values->heading)); ?></span>
                    <h3 class="section__title"><?php echo e(__(@$choose->data_values->sub_heading)); ?></h3>
                </div>
                <a href="<?php echo e(@$choose->data_values->button_link); ?>" class="cmn--btn">
                    <?php echo e(__(@$choose->data_values->button_text)); ?>

                </a>
            </div>
            <div class="col-lg-7 col-xl-6">
                <div class="choose-wrapper">
                    <div class="row g-4 gy-lg-0 gy-xl-5">

                    <?php $__currentLoopData = $chooses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleChoose): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-6">
                            <div class="choose__item">
                                <div class="choose__icon">
                                    <?php
                                        echo $singleChoose->data_values->icon;
                                    ?>
                                </div>
                                <div class="choose__content">
                                    <h5 class="choose__title"><?php echo e(__($singleChoose->data_values->title)); ?></h5>
                                    <p>
                                        <?php echo e(__($singleChoose->data_values->description)); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Section -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/sections/choose.blade.php ENDPATH**/ ?>