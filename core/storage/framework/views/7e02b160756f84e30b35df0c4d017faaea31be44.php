<?php
    $header = getContent('header.content', true);
    $socialIcons = getContent('social_icon.element');
    $footer = getContent('footer.content', true);
    $allPolicy = getContent('policy_pages.element');
?>
<!-- Footer Section -->
<footer>
    <div class="container">
        <div class="footer-top pt-80 pb-4">
            <div class="logo footer-logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="" alt="<?php echo app('translator')->get('logo'); ?>">
                </a>
            </div>
            <div class="footer__txt">
                <p>
                    <?php echo e(__(@$footer->data_values->text)); ?>

                </p>
            </div>
            <ul class="footer-links">
                <li>
                    <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                </li>
                <?php $__currentLoopData = $allPolicy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singlePolicy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('policy.page', ['slug'=>slug($singlePolicy->data_values->title), 'id'=>$singlePolicy->id])); ?>" target="_blank">
                        <?php echo e(__($singlePolicy->data_values->title)); ?>

                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('blogs')); ?>"><?php echo app('translator')->get('Blog'); ?></a>
                </li>
                <li>
                    <a href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a>
                </li>
            </ul>
        </div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://wa.me/<?php echo e(str_replace([' ', '-'], '', @$header->data_values->phone)); ?>?text=Preciso de suporte" 
   style="position:fixed; width:60px; height:60px; bottom:40px; right:15px; background-color:#25d366; color:#FFF; border-radius:50px; text-align:center; font-size:30px; box-shadow: 1px 1px 2px #888; z-index:1000;" 
   target="_blank" 
   aria-label="Preciso de suporte via WhatsApp" 
   title="Fale conosco pelo WhatsApp">
    <i style="margin-top:16px" class="fa fa-whatsapp"></i>
</a>

        <div class="footer-bottom d-flex flex-wrap-reverse justify-content-between align-items-center py-3">
            <div class="copyright">
                <?php echo e(__(@$footer->data_values->copy_right_text)); ?>

            </div>
            <ul class="social-icons">

            <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($icon->data_values->url); ?>" target="_blank">
                        <?php
                            echo $icon->data_values->social_icon;
                        ?>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
        </div>
    </div>
</footer>
<!-- Footer Section -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>