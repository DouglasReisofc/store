<?php
    $header = getContent('header.content', true);
    $socialMedias = getContent('social_icon.element');
?>
<!-- Header Section -->
    <header class="header-section">
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
                    <!--<li class="mail">
                        <i class="las la-phone-alt"></i>
                        <a href="Tel:<?php echo e(@$header->data_values->phone); ?>"><?php echo e(@$header->data_values->phone); ?></a>
                    </li>
                    <li class="mail">
                        <i class="las la-envelope"></i>
                        <a href="Mailto:<?php echo e(@$header->data_values->email); ?>"><?php echo e(@$header->data_values->email); ?></a>
                    </li>-->
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
                            <a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                        </li>
                        <li>
                            <a href="#0"><?php echo app('translator')->get('Deposit'); ?></a>
                            <ul class="submenu">
                                <li>
                                    <a href="<?php echo e(route('user.deposit')); ?>"><?php echo app('translator')->get('Deposit'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.deposit.history')); ?>"><?php echo app('translator')->get('Deposit History'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.redeemGiftcard')); ?>"><?php echo app('translator')->get('Resgate'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo e(route('card')); ?>"><?php echo app('translator')->get('Cards'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('user.card')); ?>"><?php echo app('translator')->get('My Cards'); ?></a>
                        </li>
                        <li>
                            <a href="#0"><?php echo app('translator')->get('Support'); ?></a>
                            <ul class="submenu">
                                <li>
                                    <a href="<?php echo e(route('ticket.open')); ?>"><?php echo app('translator')->get('New Ticket'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('ticket')); ?>"><?php echo app('translator')->get('My Tickets'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#0"><?php echo app('translator')->get('Account'); ?></a>
                            <ul class="submenu">
                                <li>
                                    <a href="<?php echo e(route('user.profile.setting')); ?>"><?php echo app('translator')->get('Profile'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.twofactor')); ?>"><?php echo app('translator')->get('Two Factor'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.change.password')); ?>"><?php echo app('translator')->get('Change Password'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.trx.log')); ?>"><?php echo app('translator')->get('Transaction Logs'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.logout')); ?>"><?php echo app('translator')->get('Logout'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="d-md-none">
                            <a href="<?php echo e(route('user.logout')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Logout'); ?></a>
                        </li>
                    </ul>
                    <div class="select-bar">
                        <select class="langSel">
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->code); ?>" <?php if(session('lang') == $item->code): ?> selected  <?php endif; ?>>
                                    <?php echo e(__($item->name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="right-area d-none d-md-flex">
                        <a href="<?php echo e(route('user.logout')); ?>" class="cmn--btn py-0 m-1"><?php echo app('translator')->get('Logout'); ?></a>
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
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/partials/auth_header.blade.php ENDPATH**/ ?>