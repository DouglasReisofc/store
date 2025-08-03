<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?php echo e(route('admin.card.edit')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($card->id); ?>">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-lg-12 form-group">
                            <label for="sub_category"><?php echo app('translator')->get('Sub Category'); ?></label>
                            <select name="sub_category" class="select2-basic" required>
                                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subCategory->id); ?>" <?php echo e($subCategory->id == $card->sub_category_id ? 'selected' : ''); ?>>
                                        <?php echo e(__($subCategory->name)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="revender"><?php echo app('translator')->get('Revender'); ?></label>
                                <select name="revender" class="form-control" required>
                                    <option value="1" <?php echo e($card->revender == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('Sim'); ?></option>
                                    <option value="0" <?php echo e($card->revender == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('Não'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="card_validity"><?php echo app('translator')->get('Validade do Cartão (Dias)'); ?></label>
                                <input type="number" class="form-control" name="card_validity" value="<?php echo e($card->card_validity ?? ''); ?>" min="1">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="disponivel"><?php echo app('translator')->get('Quantidade Disponível'); ?></label>
                                <input type="number" class="form-control" name="disponivel" value="<?php echo e($card->disponivel ?? ''); ?>" min="1">
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label for="details"><?php echo app('translator')->get('Card Details'); ?></label>
                                <textarea rows="6" class="form-control border-radius-5" name="details" placeholder="<?php echo app('translator')->get('Card Details'); ?>"><?php echo e($card->details); ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Card Image (optional)'); ?></label>
                                <input type="file" class="form-control" name="image">
                                <?php if($card->image): ?>
                                    <div class="mt-3">
                                        <img src="<?php echo e(getImage(imagePath()['card']['path'].'/'.$card->image, imagePath()['card']['size'])); ?>" alt="image" class="w-25">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block"><?php echo app('translator')->get('Update'); ?></button>
                </div>
            </form>
        </div><!-- card end -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";

        // Função para alternar a visibilidade do campo disponível
        function toggleDisponivelField() {
            const revenderStatus = $('select[name="revender"]').val();
            if (revenderStatus == '1') {
                $('input[name="disponivel"]').closest('.form-group').show();
            } else {
                $('input[name="disponivel"]').closest('.form-group').hide();
                $('input[name="disponivel"]').val('1'); // Define automaticamente o valor como 1 se revender for 0
            }
        }

        // Monitora mudanças no seletor de revender para alternar a visibilidade do campo disponível
        $('select[name="revender"]').change(function() {
            toggleDisponivelField();
        });

        // Chamada inicial para configurar corretamente a visibilidade ao carregar a página
        toggleDisponivelField();

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/card/edit_card.blade.php ENDPATH**/ ?>