<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('User'); ?></th>
                                <th><?php echo app('translator')->get('Email-Phone'); ?></th>
                                <th><?php echo app('translator')->get('Country'); ?></th>
                                <th><?php echo app('translator')->get('Joined At'); ?></th>
                                <th><?php echo app('translator')->get('Balance'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('User'); ?>">
                                        <span class="font-weight-bold"><?php echo e($user->fullname); ?></span>
                                        <br>
                                        <span class="small">
                                            <a href="<?php echo e(route('admin.users.detail', $user->id)); ?>"><span>@</span><?php echo e($user->username); ?></a>
                                        </span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Email-Phone'); ?>">
                                        <?php echo e($user->email); ?><br><?php echo e($user->mobile); ?>

                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Country'); ?>">
                                        <span class="font-weight-bold" data-toggle="tooltip" data-original-title="<?php echo e(@$user->address->country); ?>"><?php echo e($user->country_code); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Joined At'); ?>">
                                        <?php echo e(showDateTime($user->created_at)); ?> <br> <?php echo e(diffForHumans($user->created_at)); ?>

                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Balance'); ?>">
                                        <span class="font-weight-bold"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($user->balance)); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Action'); ?>">
    <a href="<?php echo e(route('admin.users.detail', $user->id)); ?>" class="icon-btn" data-toggle="tooltip" title="" data-original-title="<?php echo app('translator')->get('Details'); ?>">
        <i class="fas fa-desktop text--shadow mr-2"></i>
    </a>
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal<?php echo e($user->id); ?>">
        <i class="fas fa-trash-alt ml-2"></i>
    </button>
    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Apagar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Você Tem certeza que deseja Apagar este Usuário do Painel ?<br> Essa Ação Não poderá Ser desfeita e Todos os dados dele serão Removidos do sistema</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete User Modal -->
</td>

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
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <form action="<?php echo e(route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName()))); ?>" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Username or email'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/users/list.blade.php ENDPATH**/ ?>