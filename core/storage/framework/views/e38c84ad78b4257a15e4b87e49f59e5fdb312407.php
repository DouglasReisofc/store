<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?php echo e(route('admin.card.add')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 form-group">
                            <label for="sub_category"><?php echo app('translator')->get('Sub Category'); ?></label>
                            <select name="sub_category" class="select2-basic" required>
                                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subCategory->id); ?>"><?php echo e(__($subCategory->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn--success w-100 addBtn"> <i class="la la-plus"></i> <?php echo app('translator')->get('Add New Card'); ?></button>
                        </div>
                    </div>
                    <div class="row base-area">
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block"><?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div><!-- card end -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.card.index')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small">
        <i class="la la-fw la-backward"></i> <?php echo app('translator')->get('Go Back'); ?>
    </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";

        function toggleDisponivelArea(selector) {
            $(selector).find('.revender-select').each(function () {
                var $this = $(this),
                    $disponivelArea = $this.closest('.card-body').find('.disponivel-area');
                if ($this.val() == '1') {
                    $disponivelArea.slideDown();
                } else {
                    $disponivelArea.slideUp();
                }
            });
        }

        function addNewCard() {
            let baseCard = `
                <div class="col-md-6 mt-5">
                    <div class="card border--primary">
                        <div class="card-body">
                            <div class="text-right">
                                <span class="badge removeBtn badge--danger cursor">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="revender"><?php echo app('translator')->get('Revender após a compra ?'); ?></label>
                                        <select name="revender[]" class="select2-basic revender-select" required>
                                            <option value="0"><?php echo app('translator')->get('Não'); ?></option>
                                            <option value="1"><?php echo app('translator')->get('Sim'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 disponivel-area" style="display: none;">
                                    <div class="form-group">
                                        <label for="disponivel"><?php echo app('translator')->get('Quantidade De vezes que vai ser revendido'); ?></label>
                                        <input type="number" class="form-control" name="disponivel[]" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="card_validity"><?php echo app('translator')->get('Validade do produto (Dias)'); ?></label>
                                        <input type="number" class="form-control" name="card_validity[]" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="wef"><?php echo app('translator')->get('Card Image (optional)'); ?></label>
                                        <input type="file" class="form-control" name="image[]">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label for="details"><?php echo app('translator')->get('Card Details'); ?></label>
                                        <textarea rows="2" class="form-control border-radius-5" name="details[]" placeholder="<?php echo app('translator')->get('Card Details'); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('.base-area').append(baseCard);
            toggleDisponivelArea('.base-area .col-md-6:last-child');
        }

        $('.addBtn').on('click', function () {
            addNewCard();
        });

        $(document).on('change', '.revender-select', function () {
            toggleDisponivelArea($(this).closest('.card-body'));
        });

        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.col-md-6').remove();
        });

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/card/add_card.blade.php ENDPATH**/ ?>