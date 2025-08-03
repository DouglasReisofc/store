<?php $__env->startSection('panel'); ?>
    <?php if(@$section->content): ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 mb-30">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.frontend.sections.content', $key)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="content">
                            <div class="row">
                                <?php
                                    $imgCount = 0;
                                ?>
                                <?php $__currentLoopData = $section->content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($k == 'images'): ?>
                                        <?php
                                            $imgCount = collect($item)->count();
                                        ?>
                                        <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgKey => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-4">
                                                <input type="hidden" name="has_image" value="1">
                                                <div class="form-group">
                                                    <label><?php echo e(__(inputTitle(@$imgKey))); ?></label>
                                                    <div class="image-upload">
                                                        <div class="thumb">
                                                            <div class="avatar-preview">
                                                                <div class="profilePicPreview" style="background-image: url(<?php echo e(getImage('assets/images/frontend/' . $key .'/'. @$content->data_values->$imgKey,@$section->content->images->$imgKey->size)); ?>)">
                                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="avatar-edit">
                                                                <input type="file" class="profilePicUpload" name="image_input[<?php echo e(@$imgKey); ?>]" id="profilePicUpload<?php echo e($loop->index); ?>" accept=".png, .jpg, .jpeg">
                                                                <label for="profilePicUpload<?php echo e($loop->index); ?>"
                                                                       class="bg--primary"><?php echo e(__(inputTitle(@$imgKey))); ?></label>
                                                                <small class="mt-2 text-facebook"><?php echo app('translator')->get('Supported files'); ?>: <b><?php echo app('translator')->get('jpeg'); ?>, <?php echo app('translator')->get('jpg'); ?>, <?php echo app('translator')->get('png'); ?></b>.
                                                                    <?php if(@$section->content->images->$imgKey->size): ?>
                                                                        | <?php echo app('translator')->get('Will be resized to'); ?>:
                                                                        <b><?php echo e(@$section->content->images->$imgKey->size); ?></b>
                                                                        <?php echo app('translator')->get('px'); ?>.
                                                                    <?php endif; ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="<?php if($imgCount > 1): ?> col-md-12 <?php else: ?> col-md-8 <?php endif; ?>">
                                            <?php $__env->startPush('divend'); ?>
                                        </div>
                                        <?php $__env->stopPush(); ?>
                                    <?php else: ?>
                                        <?php if($k != 'images'): ?>
                                            <?php if($item == 'icon'): ?>
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label class="form-control-label font-weight-bold"><?php echo e(__(inputTitle($k))); ?></label>
                                                        <div class="input-group has_append">
                                                            <input type="text" class="form-control icon" name="<?php echo e($k); ?>" value="<?php echo e(@$content->data_values->$k); ?>" required>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary iconPicker" data-icon="<?php echo e(@$content->data_values->$k ? substr(@$content->data_values->$k,10,-6) : 'las la-home'); ?>" role="iconpicker"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php elseif($item == 'textarea'): ?>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label  font-weight-bold"><?php echo e(__(inputTitle($k))); ?></label>
                                                        <textarea rows="10" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" required><?php echo e(@$content->data_values->$k); ?></textarea>
                                                    </div>
                                                </div>

                                            <?php elseif($item == 'textarea-nic'): ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label  font-weight-bold"><?php echo e(__(inputTitle($k))); ?></label>
                                                        <textarea rows="10" class="form-control nicEdit" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" ><?php echo e(@$content->data_values->$k); ?></textarea>
                                                    </div>
                                                </div>
                                            <?php elseif($k == 'select'): ?>
                                                <?php
                                                    $selectName = $item->name;
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label  font-weight-bold"><?php echo e(__(inputTitle(@$selectName))); ?></label>
                                                        <select class="form-control" name="<?php echo e(@$selectName); ?>">
                                                            <?php $__currentLoopData = $item->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectItemKey => $selectOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($selectItemKey); ?>" <?php if(@$content->data_values->$selectName == $selectItemKey): ?> selected <?php endif; ?>><?php echo e($selectOption); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label  font-weight-bold"><?php echo e(__(inputTitle($k))); ?></label>
                                                        <input type="text" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" value="<?php echo e(@$content->data_values->$k); ?>" required/>
                                                    </div>
                                                </div>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->yieldPushContent('divend'); ?>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn--dark btn-block btn-lg"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    

    <?php if(@$section->element): ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two custom-data-table">
                                <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('SL'); ?></th>
                                    <?php if(@$section->element->images): ?>
                                        <th><?php echo app('translator')->get('Image'); ?></th>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $section->element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($k !='modal'): ?>
                                            <?php if($type=='text' || $type=='icon'): ?>
                                                <th><?php echo e(__(inputTitle($k))); ?></th>
                                            <?php elseif($k == 'select'): ?>
                                                <th><?php echo e(inputTitle(@$section->element->$k->name)); ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__empty_1 = true; $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e($loop->iteration); ?></td>
                                        <?php if(@$section->element->images): ?>
                                        <?php $firstKey = collect($section->element->images)->keys()[0]; ?>
                                            <td data-label="<?php echo app('translator')->get('Image'); ?>">
                                                <div class="customer-details d-block">
                                                    <a href="javascript:void(0)" class="thumb">
                                                        <img src="<?php echo e(getImage('assets/images/frontend/' . $key .'/'. @$data->data_values->$firstKey,@$section->element->images->$firstKey->size)); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                                                    </a>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $section->element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($k !='modal'): ?>
                                                <?php if($type == 'text' || $type == 'icon'): ?>
                                                    <?php if($type == 'icon'): ?>
                                                        <td data-label="<?php echo app('translator')->get('Icon'); ?>"><?php echo @$data->data_values->$k; ?></td>
                                                    <?php else: ?>
                                                        <td data-label="<?php echo e(__(inputTitle($k))); ?>"><?php echo e(__(@$data->data_values->$k)); ?></td>
                                                    <?php endif; ?>
                                                <?php elseif($k == 'select'): ?>
                                                    <?php
                                                        $dataVal = @$section->element->$k->name;
                                                    ?>
                                                    <td data-label="<?php echo e(inputTitle(@$section->element->$k->name)); ?>"><?php echo e(@$data->data_values->$dataVal); ?></td>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                            <?php if($section->element->modal): ?>
                                            <?php
                                                $images = [];
                                                if(@$section->element->images){
                                                    foreach($section->element->images as $imgKey => $imgs){
                                                        $images[] = getImage('assets/images/frontend/' . $key .'/'. @$data->data_values->$imgKey,@$section->element->images->$imgKey->size);
                                                    }
                                                }
                                            ?>
                                                <button class="icon-btn updateBtn" 
                                                    data-id="<?php echo e($data->id); ?>" 
                                                    data-all="<?php echo e(json_encode($data->data_values)); ?>" 
                                                    <?php if(@$section->element->images): ?> 
                                                        data-images="<?php echo e(json_encode($images)); ?>" 
                                                    <?php endif; ?>>
                                                    <i class="la la-pencil-alt"></i>
                                                </button>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('admin.frontend.sections.element',[$key,$data->id])); ?>" class="icon-btn"><i class="la la-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <button class="icon-btn btn--danger removeBtn" data-id="<?php echo e($data->id); ?>"><i class="la la-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> <?php echo app('translator')->get('Add New'); ?> <?php echo e(__(inputTitle($key))); ?> <?php echo app('translator')->get('Item'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('admin.frontend.sections.content', $key)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="element">
                        <div class="modal-body">
                            <?php $__currentLoopData = $section->element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($k != 'modal'): ?>
                                    <?php if($type == 'icon'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <div class="input-group has_append">
                                                <input type="text" class="form-control icon" name="<?php echo e($k); ?>" required>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif($k == 'select'): ?>
                                    <div class="form-group">
                                        <label><?php echo e(inputTitle(@$section->element->$k->name)); ?></label>
                                        <select class="form-control" name="<?php echo e(@$section->element->$k->name); ?>">
                                            <?php $__currentLoopData = $section->element->$k->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectKey => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($selectKey); ?>"><?php echo e($options); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php elseif($k == 'images'): ?>
                                        <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgKey => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="has_image" value="1">
                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <div class="image-upload">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview" style="background-image: url(<?php echo e(getImage('/',@$section->element->images->$imgKey->size)); ?>)">
                                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input type="file" class="profilePicUpload" name="image_input[<?php echo e($imgKey); ?>]" id="addImage<?php echo e($loop->index); ?>" accept=".png, .jpg, .jpeg">
                                                        <label for="addImage<?php echo e($loop->index); ?>" class="bg--success"><?php echo e(__(inputTitle($imgKey))); ?></label>
                                                        <small class="mt-2 text-facebook"><?php echo app('translator')->get('Supported files'); ?>: <b><?php echo app('translator')->get('jpeg'); ?>, <?php echo app('translator')->get('jpg'); ?>, <?php echo app('translator')->get('png'); ?></b>.
                                                            <?php if(@$section->element->images->$imgKey->size): ?>
                                                                | <?php echo app('translator')->get('Will be resized to'); ?>: <b><?php echo e(@$section->element->images->$imgKey->size); ?></b> <?php echo app('translator')->get('px'); ?>.
                                                            <?php endif; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($type == 'textarea'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <textarea rows="4" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" required></textarea>
                                        </div>

                                    <?php elseif($type == 'textarea-nic'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <textarea rows="4" class="form-control nicEdit" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>"></textarea>
                                        </div>

                                    <?php else: ?>

                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" required/>
                                        </div>

                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Save'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        
        <div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> <?php echo app('translator')->get('Update'); ?>  <?php echo e(__(inputTitle($key))); ?> <?php echo app('translator')->get('Item'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('admin.frontend.sections.content', $key)); ?>" class="edit-route" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="element">
                        <input type="hidden" name="id">
                        <div class="modal-body">
                            <?php $__currentLoopData = $section->element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($k != 'modal'): ?>
                                    <?php if($type == 'icon'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(inputTitle($k)); ?></label>
                                            <div class="input-group has_append">
                                                <input type="text" class="form-control icon" name="<?php echo e($k); ?>" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                                </div>
                                            </div>
                                        </div>

                                    <?php elseif($k == 'select'): ?>
                                    <div class="form-group">
                                        <label><?php echo e(inputTitle(@$section->element->$k->name)); ?></label>
                                        <select class="form-control" name="<?php echo e(@$section->element->$k->name); ?>">
                                            <?php $__currentLoopData = $section->element->$k->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectKey => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($selectKey); ?>"><?php echo e($options); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <?php elseif($k == 'images'): ?>
                                        <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgKey => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="has_image" value="1">
                                        <div class="form-group">
                                            <label><?php echo e(__(inputTitle($k))); ?></label>
                                            <div class="image-upload">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview imageModalUpdate<?php echo e($loop->index); ?>">
                                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input type="file" class="profilePicUpload" name="image_input[<?php echo e($imgKey); ?>]" id="uploadImage<?php echo e($loop->index); ?>" accept=".png, .jpg, .jpeg">
                                                        <label for="uploadImage<?php echo e($loop->index); ?>" class="bg--success"><?php echo e(__(inputTitle($imgKey))); ?></label>
                                                        <small class="mt-2 text-facebook"><?php echo app('translator')->get('Supported files'); ?>: <b><?php echo app('translator')->get('jpeg'); ?>, <?php echo app('translator')->get('jpg'); ?>, <?php echo app('translator')->get('png'); ?></b>.
                                                            <?php if(@$section->element->images->$imgKey->size): ?>
                                                                | <?php echo app('translator')->get('Will be resized to'); ?>: <b><?php echo e(@$section->element->images->$imgKey->size); ?></b> <?php echo app('translator')->get('px'); ?>.
                                                            <?php endif; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($type == 'textarea'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(inputTitle($k)); ?></label>
                                            <textarea rows="4" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" required></textarea>
                                        </div>

                                    <?php elseif($type == 'textarea-nic'): ?>

                                        <div class="form-group">
                                            <label><?php echo e(inputTitle($k)); ?></label>
                                            <textarea rows="4" class="form-control nicEdit" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>"></textarea>
                                        </div>

                                    <?php else: ?>
                                        <div class="form-group">
                                            <label><?php echo e(inputTitle($k)); ?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo e(__(inputTitle($k))); ?>" name="<?php echo e($k); ?>" required/>
                                        </div>

                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Update'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        
        <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('Confirmation'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('admin.frontend.remove')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id">
                        <div class="modal-body">
                            <p class="font-weight-bold"><?php echo app('translator')->get('Are you sure to delete this item? Once deleted can not be undone.'); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn btn--danger"><?php echo app('translator')->get('Remove'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $__env->startPush('breadcrumb-plugins'); ?>
            <?php if($section->element->modal): ?>
                <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.frontend.sections.element',$key)); ?>" class="btn btn-sm btn--success box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
            <?php endif; ?>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
    


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>

    <script>
        (function ($) {
            "use strict";
            $('.removeBtn').on('click', function () {
                var modal = $('#removeModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.updateBtn').on('click', function () {
                var modal = $('#updateBtn');
                modal.find('input[name=id]').val($(this).data('id'));

                var obj = $(this).data('all');
                var images = $(this).data('images');
                if (images) {
                    for (var i = 0; i < images.length; i++) {
                        var imgloc = images[i];
                        $(`.imageModalUpdate${i}`).css("background-image", "url(" + imgloc + ")");
                    }
                }
                $.each(obj, function (index, value) {
                    modal.find('[name=' + index + ']').val(value);
                });

                modal.modal('show');
            });

            $('#updateBtn').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });
            $('#addModal').on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.iconPicker').iconpicker().on('change', function (e) {
                $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
            });
        })(jQuery);
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/frontend/index.blade.php ENDPATH**/ ?>