<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body ">

                    <h6 class="card-title  mb-4">
                        <div class="row">
                            <div class="col-sm-8 col-md-6">
                                <?php if($ticket->status == 0): ?>
                                    <span class="badge badge--success py-1 px-2"><?php echo app('translator')->get('Open'); ?></span>
                                <?php elseif($ticket->status == 1): ?>
                                    <span class="badge badge--primary py-1 px-2"><?php echo app('translator')->get('Answered'); ?></span>
                                <?php elseif($ticket->status == 2): ?>
                                    <span class="badge badge--warning py-1 px-2"><?php echo app('translator')->get('Customer Reply'); ?></span>
                                <?php elseif($ticket->status == 3): ?>
                                    <span class="badge badge--dark py-1 px-2"><?php echo app('translator')->get('Closed'); ?></span>
                                <?php endif; ?>
                                [<?php echo app('translator')->get('Ticket#'); ?><?php echo e($ticket->ticket); ?>] <?php echo e($ticket->subject); ?>

                            </div>
                            <div class="col-sm-4  col-md-6 text-sm-right mt-sm-0 mt-3">
                                <?php if($ticket->status != 3): ?>
                                <button class="btn btn--danger btn-sm" type="button" data-toggle="modal" data-target="#DelModal">
                                    <i class="fa fa-lg fa-times-circle"></i> <?php echo app('translator')->get('Close Ticket'); ?>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </h6>



                    <form action="<?php echo e(route('admin.ticket.reply', $ticket->id)); ?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                        <?php echo csrf_field(); ?>
                        

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="message" rows="3" id="inputMessage" placeholder="<?php echo app('translator')->get('Your Message'); ?>"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="inputAttachments"><?php echo app('translator')->get('Attachments'); ?></label>
                                    </div>
                                    <div class="col-9 ">
                                        <div class="file-upload-wrapper" data-text="<?php echo app('translator')->get('Select your file!'); ?>">
                                            <input type="file" name="attachments[]" id="inputAttachments"
                                            class="file-upload-field"/>
                                        </div>
                                        <div id="fileUploadsContainer"></div>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn--dark extraTicketAttachment"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-md-12 ticket-attachments-message text-muted mt-3">
                                        <?php echo app('translator')->get('Allowed File Extensions'); ?>: .<?php echo app('translator')->get('jpg'); ?>, .<?php echo app('translator')->get('jpeg'); ?>, .<?php echo app('translator')->get('png'); ?>, .<?php echo app('translator')->get('pdf'); ?>, .<?php echo app('translator')->get('doc'); ?>, .<?php echo app('translator')->get('docx'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-3">
                                <button class="btn btn--primary btn-block mt-4" type="submit" name="replayTicket"
                                        value="1"><i class="la la-fw la-lg la-reply"></i> <?php echo app('translator')->get('Reply'); ?>
                                </button>
                            </div>
                        </div>
                    </form>


                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($message->admin_id == 0): ?>

                            <div class="row border border-primary border-radius-3 my-3 mx-2">

                                <div class="col-md-3 border-right text-right">
                                    <h5 class="my-3"><?php echo e($ticket->name); ?></h5>
                                    <?php if($ticket->user_id != null): ?>
                                        <p><a href="<?php echo e(route('admin.users.detail', $ticket->user_id)); ?>" >&#64;<?php echo e($ticket->name); ?></a></p>
                                    <?php else: ?>
                                        <p>@<span><?php echo e($ticket->name); ?></span></p>
                                    <?php endif; ?>
                                    <button data-id="<?php echo e($message->id); ?>" type="button" data-toggle="modal" data-target="#DelMessage" class="btn btn-danger btn-sm my-3 delete-message"><i class="la la-trash"></i> <?php echo app('translator')->get('Delete'); ?></button>
                                </div>

                                <div class="col-md-9">
                                    <p class="text-muted font-weight-bold my-3">
                                        <?php echo app('translator')->get('Posted on'); ?> <?php echo e(showDateTime($message->created_at, 'l, dS F Y @ H:i')); ?></p>
                                    <p><?php echo e($message->message); ?></p>
                                    <?php if($message->attachments()->count() > 0): ?>
                                        <div class="my-3">
                                            <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(route('admin.ticket.download',encrypt($image->id))); ?>" class="mr-3"><i class="fa fa-file"></i><?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row border border-warning border-radius-3 my-3 mx-2 admin-bg-reply">

                                <div class="col-md-3 border-right text-right">
                                    <h5 class="my-3"><?php echo e(@$message->admin->name); ?></h5>
                                    <p class="lead text-muted"><?php echo app('translator')->get('Staff'); ?></p>
                                    <button data-id="<?php echo e($message->id); ?>" type="button" data-toggle="modal" data-target="#DelMessage" class="btn btn-danger btn-sm my-3 delete-message"><i class="la la-trash"></i> <?php echo app('translator')->get('Delete'); ?></button>
                                </div>

                                <div class="col-md-9">
                                    <p class="text-muted font-weight-bold my-3">
                                        <?php echo app('translator')->get('Posted on'); ?> <?php echo e(showDateTime($message->created_at,'l, dS F Y @ H:i')); ?></p>
                                    <p><?php echo e($message->message); ?></p>
                                    <?php if($message->attachments()->count() > 0): ?>
                                        <div class="my-3">
                                            <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(route('admin.ticket.download',encrypt($image->id))); ?>" class="mr-3"><i class="fa fa-file"></i>  <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?> </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <?php echo app('translator')->get('Close Support Ticket!'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong><?php echo app('translator')->get('Are you want to close this support ticket?'); ?></strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="<?php echo e(route('admin.ticket.reply', $ticket->id)); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?> </button>
                        <button type="submit" class="btn btn--success" name="replayTicket" value="2"> <?php echo app('translator')->get('Close Ticket'); ?> </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="DelMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo app('translator')->get('Delete Reply!'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong><?php echo app('translator')->get('Are you sure to delete this?'); ?></strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="<?php echo e(route('admin.ticket.delete')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="message_id" class="message_id">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('No'); ?> </button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-trash"></i> <?php echo app('translator')->get('Delete'); ?> </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.ticket')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> <?php echo app('translator')->get('Go Back'); ?> </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            })
            $('.extraTicketAttachment').on('click',function(){
                $("#fileUploadsContainer").append(`
                <div class="file-upload-wrapper" data-text="<?php echo app('translator')->get('Select your file!'); ?>"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>`)
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/admin/support/reply.blade.php ENDPATH**/ ?>