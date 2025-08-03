<?php
    $header = getContent('header.content', true);
    $socialMedias = getContent('social_icon.element');
?>

<!-- Header Section -->
<header class="header-section header-to-hide">
    <div class="header-top">
        <div class="container">
            <ul class="header-top-area">
                <li class="me-auto">
                    <ul class="social">
                        <?php $__currentLoopData = $socialMedias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e($media->data_values->url); ?>" target="_blank">
                                    <?php
                                        echo $media->data_values->social_icon;
                                    ?>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="<?php echo e(route('home')); ?>">
                        <img src="" alt="<?php echo app('translator')->get('logo'); ?>">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('card')); ?>"><?php echo app('translator')->get('Cards'); ?></a>
                    </li>
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('pages',[$data->slug])); ?>">
                                <?php echo e(__($data->name)); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <!--<a href="<?php echo e(route('blogs')); ?>"><?php echo app('translator')->get('Blog'); ?></a>-->
                    </li>
                    <li>
                        <a href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a>
                    </li>
                    <li class="d-md-none">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('user.home')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Dashboard'); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('user.login')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Sign in'); ?></a>
                            <a href="<?php echo e(route('user.register')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Criar conta'); ?></a>
                        <?php endif; ?>
                    </li>
                </ul>
                <div class="lang-select">
                    <select class="langSel">
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->code); ?>" <?php if(session('lang') == $item->code): ?> selected  <?php endif; ?>>
                                <?php echo e(__($item->name)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="right-area d-none d-md-flex">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('user.home')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Dashboard'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo e(route('user.login')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Sign in'); ?></a>
                        <a href="<?php echo e(route('user.register')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Criar conta'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="header-bar ms-3 me-0">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Section -->

<!-- JavaScript para ocultar o cabeçalho e os itens -->
<!--<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Selecione o cabeçalho e os itens que deseja ocultar
        //var headerToHide = document.querySelector(".header-to-hide");
        var socialToHide = document.querySelectorAll(".social-to-hide");
        var mailToHide = document.querySelectorAll(".mail-to-hide");

        // Oculte o cabeçalho e os itens
        headerToHide.style.display = "none";
        socialToHide.forEach(function (item) {
            item.style.display = "none";
        });
        mailToHide.forEach(function (item) {
            item.style.display = "none";
        });
    });
</script>-->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/partials/header.blade.php ENDPATH**/ ?>