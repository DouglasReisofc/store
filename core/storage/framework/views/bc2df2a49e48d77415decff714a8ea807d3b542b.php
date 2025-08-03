<?php
    $about = getContent('about.content', true);
?>
<!-- About Section -->
<section class="about-section overlay-hidden">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-between align-items-center">
            <div class="col-lg-7 col-xl-6 align-self-end">
                <div class="about-thumb">
                    <img src="<?php echo e(getImage('assets/images/frontend/about/' .@$about->data_values->image, '985x700')); ?>" alt="<?php echo app('translator')->get('about'); ?>">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="pt-max-lg-0 pb-max-lg-50 pt-60 pb-120">
                    <div class="section__header mb-low">
                        <span class="section__category"><?php echo e(__(@$about->data_values->title)); ?></span>
                        <h3 class="section__title"><?php echo e(__(@$about->data_values->heading)); ?></h3>
                        <p class="mb-4">
                            <?php echo e(__(@$about->data_values->description)); ?>

                        </p>
                    </div>
                    <a href="<?php echo e(@$about->data_values->button_link); ?>" class="cmn--btn">
                        <?php echo e(__(@$about->data_values->button_text)); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/sections/about.blade.php ENDPATH**/ ?>