<!-- navbar-wrapper start -->
<nav class="navbar-wrapper">
    <form class="navbar-search" onsubmit="return false;">
        <button type="submit" class="navbar-search__btn">
            <i class="las la-search"></i>
        </button>
        <input type="search" name="navbar-search__field" id="navbar-search__field"
               placeholder="Search...">
        <button type="button" class="navbar-search__close"><i class="las la-times"></i></button>

        <div id="navbar_search_result_area">
            <ul class="navbar_search_result"></ul>
        </div>
    </form>

    <div class="navbar__left">
        <button class="res-sidebar-open-btn"><i class="las la-bars"></i></button>
        <button type="button" class="fullscreen-btn">
            <i class="fullscreen-open las la-compress" onclick="openFullscreen();"></i>
            <i class="fullscreen-close las la-compress-arrows-alt" onclick="closeFullscreen();"></i>
        </button>
    </div>

    <div class="navbar__right">
        <ul class="navbar__action-list">
            <li>
                <button type="button" class="navbar-search__btn-open">
                    <i class="las la-search"></i>
                </button>
            </li>


            <li class="dropdown">
                <button type="button" class="primary--layer" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                  <i class="las la-bell text--primary"></i>
                  <?php if($adminNotifications->count() > 0): ?>
                    <span class="pulse--primary"></span>
                  <?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu--md p-0 border-0 box--shadow1 dropdown-menu-right">
                  <div class="dropdown-menu__header">
                    <span class="caption"><?php echo app('translator')->get('Notification'); ?></span>
                    <?php if($adminNotifications->count() > 0): ?>
                        <p><?php echo app('translator')->get('You have'); ?> <?php echo e($adminNotifications->count()); ?> <?php echo app('translator')->get('unread notification'); ?></p>
                    <?php else: ?>
                        <p><?php echo app('translator')->get('No unread notification found'); ?></p>
                    <?php endif; ?>
                  </div>
                  <div class="dropdown-menu__body">
                    <?php $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.notification.read',$notification->id)); ?>" class="dropdown-menu__item">
                      <div class="navbar-notifi">
                        <div class="navbar-notifi__left bg--green b-radius--rounded"><img src="<?php echo e(getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])); ?>" alt="<?php echo app('translator')->get('Profile Image'); ?>"></div>
                        <div class="navbar-notifi__right">
                          <h6 class="notifi__title"><?php echo e(__($notification->title)); ?></h6>
                          <span class="time"><i class="far fa-clock"></i> <?php echo e($notification->created_at->diffForHumans()); ?></span>
                        </div>
                      </div><!-- navbar-notifi end -->
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                  <div class="dropdown-menu__footer">
                    <a href="<?php echo e(route('admin.notifications')); ?>" class="view-all-message"><?php echo app('translator')->get('View all notification'); ?></a>
                  </div>
                </div>
            </li>


            <li class="dropdown">
                <button type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                  <span class="navbar-user">
                    <span class="navbar-user__thumb"><img src="<?php echo e(getImage('assets/admin/images/profile/'. auth()->guard('admin')->user()->image)); ?>" alt="image"></span>
                    <span class="navbar-user__info">
                      <span class="navbar-user__name"><?php echo e(auth()->guard('admin')->user()->username); ?></span>
                    </span>
                    <span class="icon"><i class="las la-chevron-circle-down"></i></span>
                  </span>
                </button>
                <div class="dropdown-menu dropdown-menu--sm p-0 border-0 box--shadow1 dropdown-menu-right">
                    <a href="<?php echo e(route('admin.profile')); ?>"
                       class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                        <i class="dropdown-menu__icon las la-user-circle"></i>
                        <span class="dropdown-menu__caption"><?php echo app('translator')->get('Profile'); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.password')); ?>"
                       class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                        <i class="dropdown-menu__icon las la-key"></i>
                        <span class="dropdown-menu__caption"><?php echo app('translator')->get('Password'); ?></span>
                    </a>

                    <a href="<?php echo e(route('admin.logout')); ?>"
                       class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                        <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                        <span class="dropdown-menu__caption"><?php echo app('translator')->get('Logout'); ?></span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- navbar-wrapper end -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/partials/topnav.blade.php ENDPATH**/ ?>