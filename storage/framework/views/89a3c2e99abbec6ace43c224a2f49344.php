<?php $__env->startSection('title'); ?> Userlist <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">USERS LIST</h5>
            </div>
            <div class="card-body">
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
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat expenseTypeExportBtn"
                        href="<?php echo e(route('user.export')); ?>">
                        <i class="ri-export-fill"></i> Export</a> 
                        <a href="<?php echo e(url('/')); ?>/user_card" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</a>
                    </div>
                </div> <br> 

                <div class="table-responsive">
                    <table id="UserTable" class="display table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Creation</th>
                                <th>Registered by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($listUsers)): ?> 
                            <?php $__currentLoopData = $listUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $userData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($userData->user_id); ?></td>
                                <td><?php echo e($userData->dni); ?></td>
                                <td><?php echo e($userData->name); ?></td>
                                <td>
                                    <?php 
                                    if($userData->superadmin == 1){
                                        echo "Superadmin";
                                    }else{
                                        $getListRole = DB::table('tbl_users_access')->where('user_id',$userData->user_id)->get();
                                        if(isset($getListRole) && !empty($getListRole)){
                                            foreach ($getListRole as $key => $value) {
                                                $cheifStandard = "";
                                                if($value->role_id == 1){
                                                    $cheifStandard = "Chief";
                                                }else{
                                                    $cheifStandard = "Standard";
                                                }
                                                $getCompanyName = DB::table('tbl_companies')->where('company_id',$value->company_id)->first();

                                                echo $getCompanyName->name .' - '. $cheifStandard.'<br>';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><div class="col-md-6 position-relative form-check form-switch form-switch-lg" style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" <?php echo e(($userData->status==1 ? "checked" : "")); ?>></div></td>


                                <td><?php echo e($userData->created_at); ?></td> 
                                <td><?php echo e($userData->register_by); ?></td> 
                                <td>
                                    <?php if($index !=0): ?>
                                    <a href="<?php echo e(url('/').'/user_card_edit/'); ?><?php echo e($userData->user_id); ?>" class="btn btn-primary"><i class="ri-edit-2-line"></i> Edit</a>

                                    <!-- <a href="<?php echo e(url('/').'/user_card_delete/'); ?><?php echo e($userData->user_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?')"><i class="ri-delete-bin-line"></i> Delete</a> -->
                                    <?php endif; ?>
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
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

<script type="text/javascript">
    var table = $('#UserTable').DataTable({
        processing: true, 
        responsive: true,
        pageLength: 25,
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/configure/userlist.blade.php ENDPATH**/ ?>