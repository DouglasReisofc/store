

<?php $__env->startSection('panel'); ?>
<div class="row mb-4">
    <div class="col-lg-12">
        <form action="<?php echo e(route('admin.card.index')); ?>" method="GET" class="form-inline">
            <?php echo csrf_field(); ?>
            <div class="card-body">
    <div class="row align-items-center justify-content-between"> <!-- Adicionada a classe align-items-center -->
        <div class="form-group mr-3">
            <label for="subcategoryId"><?php echo app('translator')->get('Subcategoria'); ?></label>
            <select class="form-control select2-basic" name="subcategoryId" id="subcategoryId">
                <option value=""><?php echo e(__('Todas as Subcategorias')); ?></option>
                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subCategory->id); ?>" <?php echo e(request()->subcategoryId == $subCategory->id ? 'selected' : ''); ?>><?php echo e($subCategory->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group mr-3">
            <input type="text" name="trx" class="form-control" placeholder="Buscar por ID" value="<?php echo e(request()->trx); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Sub Category'); ?></th>
                                <th><?php echo app('translator')->get('ID'); ?></th>
                                <th><?php echo app('translator')->get('Criado Dia'); ?></th>
                                <th><?php echo app('translator')->get('Editado Dia'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td data-label="<?php echo app('translator')->get('Sub Category'); ?>"><?php echo e(__($card->subCategory->name)); ?></td>
                                <td data-label="<?php echo app('translator')->get('ID'); ?>"><?php echo e($card->trx ?? __('')); ?></td>
                                <td data-label="<?php echo app('translator')->get('Criado Dia'); ?>"><?php echo e($card->created_at ? $card->created_at->format('d/m/Y') : __('N/A')); ?></td>
                                <td data-label="<?php echo app('translator')->get('Editado Dia'); ?>"><?php echo e($card->updated_at ? $card->updated_at->format('d/m/Y') : __('N/A')); ?></td>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <a href="<?php echo e(route('admin.card.edit.page', $card->id)); ?>" class="icon-btn" data-toggle="tooltip" data-original-title="<?php echo app('translator')->get('Edit'); ?>">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="icon-btn deleteBtn" data-id="<?php echo e($card->id); ?>" data-toggle="modal" data-target="#deleteModal" style="background-color: red;">
                                        <i class="las la-trash text-white"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php echo e($cards->appends(['subcategoryId' => request()->subcategoryId, 'trx' => request()->trx])->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.card.delete')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="deleteId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"><?php echo app('translator')->get('Confirme a Exclusão'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo app('translator')->get('Deseja realmente apagar este produto?'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->get('Cancelar'); ?></button>
                    <button type="submit" class="btn btn-danger"><?php echo app('translator')->get('Deletar'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.card.add.page')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small">
    <i class="las la-plus"></i> <?php echo app('translator')->get('Add New'); ?>
</a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    $(document).ready(function() {
    // Inicializa o Select2 para os campos especificados
    $('.select2-basic').select2();
    
    // Script para manipulação do botão de deletar, se necessário
    $('.deleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });
});
$(document).ready(function() {
    $('.deleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/card/card.blade.php ENDPATH**/ ?>