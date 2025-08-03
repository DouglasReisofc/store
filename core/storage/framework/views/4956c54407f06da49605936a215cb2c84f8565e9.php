<?php $__env->startSection('content'); ?>
<div class="container <?php echo e(Auth::user() ? '' : 'pt-80 pb-80'); ?>">
    <div class="message__chatbox bg--section">
        <div class="message__chatbox__header">
            <h5 class="title">
                <?php if($my_ticket->status == 0): ?>
                    <span class="badge badge--success"><?php echo app('translator')->get('Open'); ?></span>
                <?php elseif($my_ticket->status == 1): ?>
                    <span class="badge badge--primary"><?php echo app('translator')->get('Answered'); ?></span>
                <?php elseif($my_ticket->status == 2): ?>
                    <span class="badge badge--warning"><?php echo app('translator')->get('Replied'); ?></span>
                <?php elseif($my_ticket->status == 3): ?>
                    <span class="badge badge--dark"><?php echo app('translator')->get('Closed'); ?></span>
                <?php endif; ?>
                <span class="text--base">#<?php echo e($my_ticket->ticket); ?></span>
            </h5>
            <?php if($my_ticket->status != 3): ?>
                <a href="#0" class="cmn--btn btn--sm" data-bs-toggle="modal" data-bs-target="#DelModal"><?php echo app('translator')->get('Close'); ?></a>
            <?php endif; ?>
        </div>
        <div class="message__chatbox__body">
            <form class="message__chatbox__form row" method="post" action="<?php echo e(route('ticket.reply', $my_ticket->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="replayTicket" value="1">
                <div class="form--group col-sm-12">
                    <textarea class="form-control form--control" name="message"></textarea>
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
                    <button type="submit" class="cmn--btn btn--lg"><?php echo app('translator')->get('Reply'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="message__chatbox bg--section mt-5">
        <div class="message__chatbox__header">
            <h5 class="title"><?php echo app('translator')->get('Conversation'); ?></h5>
        </div>
        <div class="message__chatbox__body">
            <ul class="reply-message-area">
                <li>
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($message->admin_id == 0): ?>
                            <li>
                                <div class="reply-item">
                                    <div class="name-area">
                                        <h6 class="title"><?php echo e($message->ticket->name); ?></h6>
                                    </div>
                                    <div class="content-area">
                                        <span class="meta-date">
                                            <?php echo app('translator')->get('Posted on'); ?> <span class="cl-theme"><?php echo e($message->created_at->format('l, dS F Y @ H:i')); ?></span>
                                        </span>
                                        <p><?php echo e($message->message); ?></p>
                                        <?php if($message->attachments()->count() > 0): ?>
                                            <div class="mt-2">
                                                <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('ticket.download',encrypt($image->id))); ?>" class="mr-3"><i class="fa fa-file"></i>  <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?> </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php else: ?>
                            <ul>
                                <li>
                                    <div class="reply-item">
                                        <div class="name-area">
                                            <h6 class="title"><?php echo e($message->admin->name); ?></h6>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                <?php echo app('translator')->get('Posted on'); ?>, <span class="cl-theme"><?php echo e($message->created_at->format('l, dS F Y @ H:i')); ?></span>
                                            </span>
                                            <p><?php echo e($message->message); ?></p>
                                            <?php if($message->attachments()->count() > 0): ?>
                                                <div class="mt-2">
                                                    <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(route('ticket.download',encrypt($image->id))); ?>" class="mr-3"><i class="fa fa-file"></i>  <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?> </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="modal fade cmn--modal" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?php echo e(route('ticket.reply', $my_ticket->id)); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="replayTicket" value="2">
                <div class="modal-header">
                    <h5 class="modal-title"> <?php echo app('translator')->get('Confirmation'); ?>!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong ><?php echo app('translator')->get('Are you sure you want to close this support ticket'); ?>?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--md btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <button type="submit" class="btn btn--md btn--success"><?php echo app('translator')->get("Confirm"); ?>
                    </button>
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
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });

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

<?php echo $__env->make($extends, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/user/support/view.blade.php ENDPATH**/ ?>