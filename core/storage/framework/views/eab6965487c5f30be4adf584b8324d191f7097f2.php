<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="message__chatbox bg--section">

        <div class="message__chatbox__body">
            <form class="message__chatbox__form row" action="<?php echo e(route('ticket.store')); ?>"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                <?php echo csrf_field(); ?>
                <div class="form--group col-sm-6">
                    <label for="name" class="form--label"><?php echo app('translator')->get('Name'); ?></label>
                    <input type="text" name="name" id="name" value="<?php echo e(@$user->firstname . ' '.@$user->lastname); ?>" class="form-control form--control" readonly>
                </div>
                <div class="form--group col-sm-6">
                    <label for="email" class="form--label"><?php echo app('translator')->get('Email address'); ?></label>
                    <input type="email" name="email" id="" value="<?php echo e(@$user->email); ?>" class="form-control form--control" readonly>
                </div>
                <div class="form--group col-sm-6">
                    <label for="subject" class="form--label"><?php echo app('translator')->get('Subject'); ?></label>
                    <input type="text" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" class="form-control form--control">
                </div>
                <div class="form--group col-sm-6">
                    <label for="subject" class="form--label"><?php echo app('translator')->get('Priority'); ?></label>
                    <div class="select-item">
                        <select name="priority" id="select" class="form--control select-bar m-0">
                            <option value="3"><?php echo app('translator')->get('High'); ?></option>
                            <option value="2"><?php echo app('translator')->get('Medium'); ?></option>
                            <option value="1"><?php echo app('translator')->get('Low'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form--group col-sm-12">
                    <label for="inputMessage" class="form--label"><?php echo app('translator')->get('Message'); ?></label>
                    <textarea name="message" id="inputMessage" rows="6" class="form-control form--control"><?php echo e(old('message')); ?></textarea>
                </div>
                <div class="form--group col-sm-12">
                    <div class="d-flex">
                        <div class="left-group col p-0">
                            <label for="file" class="form--label"><?php echo app('translator')->get('Attachments'); ?></label>
                            <input type="file" class="overflow-hidden form-control form--control mb-2" name="attachments[]" id="inputAttachments">
                            <span class="info fs--14">
                                <?php echo app('translator')->get('Allowed File Extensions'); ?>: .<?php echo app('translator')->get('jpg'); ?>, .<?php echo app('translator')->get('jpeg'); ?>, .<?php echo app('translator')->get('png'); ?>, .<?php echo app('translator')->get('pdf'); ?>, .<?php echo app('translator')->get('doc'); ?>, .<?php echo app('translator')->get('docx'); ?>
                            </span>
                        </div>
                        <div class="add-area">
                            <label class="form--label d-block">&nbsp;</label>
                            <button class="cmn--btn btn--sm bg--primary form--control ms-2 ms-md-4 addFile" type="button"><i class="las la-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div id="fileUploadsContainer"></div>

                <div class="form--group col-sm-12 mt-2 mb-0">
                    <button type="submit" class="cmn--btn btn--lg"><?php echo app('translator')->get('Create Ticket'); ?></button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="form--group col-sm-12">
                    <div class="d-flex">
                        <div class="left-group col p-0">
                            <input type="file" class="overflow-hidden form-control form--control mb-2" name="attachments[]" id="inputAttachments">
                        </div>
                        <div class="add-area">
                            <button class="cmn--btn btn--sm bg-danger form--control ms-2 ms-md-4 remove-btn" type="button"><i class="las la-times"></i></button>
                        </div>
                    </div>
                </div>`
                )
            });

            $(document).on('click','.remove-btn',function(){
                $(this).closest('.form--group').remove();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/support/create.blade.php ENDPATH**/ ?>