<?php
    $top = getContent('topSell.content', true);
    $topSells = App\Models\Card::with('subCategory.category')
                                  ->whereHas('subCategory.category', function($q){
                                      $q->where('status', 1);
                                   })
                                  ->where('user_id', '!=', 0)
                                  ->groupBy('sub_category_id')
                                  ->selectRaw('sub_category_id, count(sub_category_id) as sold, id')
                                  ->orderBy('sold', 'DESC')
                                  ->take(12)
                                  ->get();
?>
<!-- Top Sell Card Section -->
<section class="latest-card-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xxl-6">
                <div class="section__header text-center">
                    <span class="section__category">
                        <?php echo e(__(@$top->data_values->title)); ?>

                    </span>
                    <h3 class="section__title">
                        <?php echo e(__(@$top->data_values->heading)); ?>

                    </h3>
                    <p>
                        <?php echo e(__(@$top->data_values->sub_heading)); ?>

                    </p>
                </div>
            </div>
        </div>
        <div class="row g-3 g-sm-4 justify-content-center card-wrapper">
            <?php $__currentLoopData = $topSells; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topSell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="card-item">
                        <div class="card-thumb">
                                <a href="<?php echo e(route('card.details', ['name'=>slug($topSell->subCategory->name), 'id'=>$topSell->subCategory->id])); ?>">
                                <img src="<?php echo e(getImage(imagePath()['sub_category']['path'].'/'.$topSell->subCategory->image)); ?>" alt="<?php echo app('translator')->get('card'); ?>">
                            </a>
                        </div>
                        <h5 class="title">
                                <a href="<?php echo e(route('card.details', ['name'=>slug($topSell->subCategory->name), 'id'=>$topSell->subCategory->id])); ?>">
                                <?php echo e(__($topSell->subCategory->name)); ?>

                            </a>
                        </h5>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- Top Sell Card Section -->
<?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/sections/topSell.blade.php ENDPATH**/ ?>