<?php $__env->startSection('title'); ?> Project Card <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">PROJECT CARD</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="<?php echo e(url('project_card')); ?>" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="ID" class="form-label">ID</label>
                            <input type="text" class="form-control" id="ID" value="<?php echo e($newInsertID); ?>" required="" disabled=""> 
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="name" class="form-label">Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>" required=""> 
                            <span style="color: red;"><?php if($errors->has('name')): ?>
                                <?php echo e($errors->first('name')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="business_line_id" class="form-label">Business Line <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="business_line_id" name="business_line_id" required="">
                                <option value="">Select Business Line</option>
                                <?php if(isset($listBusiness)): ?>
                                <?php $__currentLoopData = $listBusiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->business_line_id); ?>" <?php echo e(old('business_line_id') == $value->business_line_id ? 'selected' : ''); ?>><?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('business_line_id')): ?>
                                <?php echo e($errors->first('business_line_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

  
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative form-check form-switch form-switch-lg">
                            <label class="form-check-label" for="customSwitchsizelg">Status</label>
                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" checked="">
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-5">
                            <a href="javascript:window.history.back()" class="btn btn-danger" ><i class="ri-close-line"></i> Cancel</a>
                        </div>
                        <div class="col-md-3 position-relative">
                            <button class="btn btn-primary" type="submit"><i class="ri-save-line"></i> Save</button>
                        </div> 
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/budget/project_card.blade.php ENDPATH**/ ?>