<?php $__env->startSection('title'); ?> COMPANY LIST <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">COMPANY LIST</h5>
            </div>
            <div class="card-body changePageAction">
                <?php if(session('success_msg')): ?> 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b><?php echo e(session('success_msg')); ?>.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php elseif(session('error_msg')): ?> 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b><?php echo e(session('error_msg')); ?>.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>  

                <div class="row"> 
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat"
                        href="<?php echo e(route('company.export')); ?>">
                        <i class="ri-export-fill"></i> Export</a> 
                        <a href="<?php echo e(url('/')); ?>/company_card" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</a>
                    </div>
                </div> <br> 

                
                <table id="CompanyTable" class="display table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Creation</th>
                            <th>Registered by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($listCompany)): ?>
                        <?php $__currentLoopData = $listCompany; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($companyData->company_id); ?></td>
                            <td><?php echo e($companyData->name); ?></td>
                            <td><div class="col-md-6 position-relative form-check form-switch form-switch-lg" style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" <?php echo e(($companyData->status==1 ? "checked" : "")); ?>></div></td>
                            <td><?php echo e($companyData->created_at); ?></td> 
                            <td><?php echo e($companyData->register_by); ?></td> 
                            <td><a href="<?php echo e(url('/').'/company_card_edit/'); ?><?php echo e($companyData->company_id); ?>" class="btn btn-primary"><i class="ri-edit-2-line"></i> Edit</a>
                                <!-- <a href="<?php echo e(url('/').'/company_card_delete/'); ?><?php echo e($companyData->company_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?')"><i class="ri-delete-bin-line"></i> Delete</a> -->
                            </td> 
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            <?php endif; ?>
                        </table> 
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
    <script type="text/javascript">
        var table = $('#CompanyTable').DataTable({
            processing: true, 
            responsive: true,
            pageLength: 25,
            columnDefs: [
            {"className": "dt-center", "targets": "_all"}
            ],
        });
        
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/configure/companylist.blade.php ENDPATH**/ ?>