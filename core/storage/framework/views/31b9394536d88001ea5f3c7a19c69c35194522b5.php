<?php $__env->startSection('content'); ?>
<!-- Blog Section Starts Here -->
<section class="blog-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="row g-4 justify-content-center">

            <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post__item">
                        <div class="post__thumb">
                            <a href="<?php echo e(route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id])); ?>">
                                <img src="<?php echo e(getImage('assets/images/frontend/blog/' .@$blog->data_values->image, '700x450')); ?>" alt="blog">
                            </a>
                            <span class="category">
                                <i class="fa fa-eye"></i>
                                <?php echo e($blog->view); ?>

                            </span>
                        </div>
                        <div class="post__content">
                            <h6 class="post__title">
                                <a href="<?php echo e(route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id])); ?>">
                                    <?php echo e(__($blog->data_values->title)); ?>

                                </a>
                            </h6>
                            <div class="meta__date">
                                <div class="meta__item">
                                    <i class="las la-calendar"></i>
                                    <?php echo e(showDateTime($blog->created_at)); ?>

                                </div>
                                <div class="meta__item">
                                    <i class="las la-user"></i>
                                    <?php echo app('translator')->get('Admin'); ?>
                                </div>
                            </div>
                            <a href="<?php echo e(route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id])); ?>" class="post__read">
                                <?php echo app('translator')->get('Read More'); ?>
                                <i class="las la-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <h6 class="text-center"><?php echo app('translator')->get('Data Not Found'); ?></h6>
            <?php endif; ?>

        </div>
        <?php echo e($blogs->links()); ?>

    </div>
</section>
<!-- Blog Section Ends Here -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/blogs.blade.php ENDPATH**/ ?>