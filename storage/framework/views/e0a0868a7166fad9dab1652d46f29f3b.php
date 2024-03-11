<?php $__env->startSection('title'); ?> Company Card Edit <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">COMPANY CARD EDIT</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="<?php echo e(url('company_card_edit')); ?>/<?php echo e($getCompany->company_id); ?>" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?> 
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="name" class="form-label">Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e($getCompany->name); ?>" required="" placeholder="11.111.111-1"> 
                            <span style="color: red;"><?php if($errors->has('name')): ?>
                                <?php echo e($errors->first('name')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="rut" class="form-label">RUT <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="rut" id="rut" value="<?php echo e($getCompany->rut); ?>" required> 
                            <span style="color: red;"><?php if($errors->has('rut')): ?>
                                <?php echo e($errors->first('rut')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="business" class="form-label">Business </label>
                            <input type="text" class="form-control" name="business_activity" value="<?php echo e($getCompany->business_activity); ?>" id="business" > 
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="logo" class="form-label">Logo <span style="color: red">*</span></label>
                            <input type="file" class="form-control" name="logo" id="logo" value="<?php echo e($getCompany->logo); ?>" > <br>
                            
                            <img src="<?php echo e(url('/')); ?>/images/company/<?php echo e($getCompany->logo); ?>" style="width: 100px;height: 100px">
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="webpage_url" class="form-label">Webpage </label>
                            <input type="text" class="form-control" name="webpage_url" id="webpage_url" value="<?php echo e($getCompany->webpage_url); ?>"> 
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="rrss_url" class="form-label">Main Url RRSS </label>
                            <input type="text" class="form-control" name="rrss_url" id="rrss_url" value="<?php echo e($getCompany->rrss_url); ?>"> 
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="rrss" class="form-label">&nbsp; </label>
                            <select class="form-control form-select" id="rrss" name="rrss_type_id"  >
                                <option value="">Select RRSS Type</option>
                                <?php if(isset($listRsstype)): ?>
                                <?php $__currentLoopData = $listRsstype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rrsstype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rrsstype->rrss_type_id); ?>" <?php echo e(($getCompany->rrss_type_id == $rrsstype->rrss_type_id ? "selected" : "")); ?> ><?php echo e($rrsstype->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="address_line_1" class="form-label">Address Line 1 <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="address_line_1" id="address_line_1" value="<?php echo e($getCompany->address_line_1); ?>" required> 
                            <span style="color: red;"><?php if($errors->has('address_line_1')): ?>
                                <?php echo e($errors->first('address_line_1')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="address_line_2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" name="address_line_2" id="address_line_2" value="<?php echo e($getCompany->address_line_2); ?>"> 
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="region_id" class="form-label">Region </label>
                            <select class="form-control form-select" id="region_id" name="region_id" value="<?php echo e($getCompany->region_id); ?>" required="">
                                <option value="">Select Region</option>
                                <?php if(isset($listRegion)): ?>
                                <?php $__currentLoopData = $listRegion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->region_id); ?>" <?php echo e(($getCompany->region_id == $value->region_id ? "selected" : "")); ?> ><?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('region_id')): ?>
                                <?php echo e($errors->first('region_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="comuna_id" class="form-label">Comuna</label>
                            <select class="form-control form-select" id="comuna_id" name="comuna_id" required="">
                                <option value="">Select Comuna</option> 
                            </select>
                            <span style="color: red;"><?php if($errors->has('comuna_id')): ?>
                                <?php echo e($errors->first('comuna_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative form-check form-switch form-switch-lg">
                            <label class="form-check-label" for="customSwitchsizelg">Status</label>
                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" <?php echo e(($getCompany->status == 1 ? "checked" : "")); ?>>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-2">
                            <a href="javascript:window.history.back()" class="btn btn-danger" ><i class="ri-close-line"></i> Cancel</a>
                        </div>
                        <div class="col-md-3 position-relative">
                            <a href="<?php echo e(url('company_card_delete')); ?>/<?php echo e($getCompany->company_id); ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger" ><i class="ri-delete-bin-line"></i> Delete</a>
                        </div>
                        <div class="col-md-2 position-relative">
                            <button class="btn btn-primary" type="submit"><i class="ri-edit-line"></i> Update</button>
                        </div> 
                        <div class="col-md-2 position-relative"></div>
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



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/configure/company_card_edit.blade.php ENDPATH**/ ?>