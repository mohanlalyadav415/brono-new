<?php $__env->startSection('title'); ?> Project List <?php $__env->stopSection(); ?>
<!-- <?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?> -->
<?php $__env->startSection('content'); ?>
<style type="text/css">
    li {
        list-style-type: none;
    }
    
</style>
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">PROJECT LIST</h5>
            </div>
            <div class="card-body">   


                <br><br><br>
                <div class="row">
                    <div class="col-md-3">
                        <select name="company_id" class="company_id form-control form-select">
                            <option value="">Company</option> 
                            <?php
                            foreach ($companyList as $key => $value) { ?>
                                <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="business_name form-control form-select">
                            <option value="">Business line</option> 
                            <?php 
                            foreach ($businesslineList as $key => $value) { ?>
                                <option value="<?php echo $value->name; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat businessProjectExportBtn"
                        href="<?php echo e(route('business.line.project.export')); ?>" style="float: right;">
                        <i class="ri-export-fill"></i> Export</a> 
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo e(url('/')); ?>/business-line-list" class="btn btn-primary" ><i class="ri-add-box-line"></i> Business Line List</a> 
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo e(url('/')); ?>/project_card" class="btn btn-primary"><i class="ri-add-box-line"></i> New Project</a>
                    </div>
                </div>

                <!-- <div class="row"> 
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat"
                        href="<?php echo e(route('company.export')); ?>">
                        <i class="fa fa-download"></i> Export</a> 
                        <a href="<?php echo e(url('/')); ?>/company_card" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</a>
                    </div>
                </div> <br>  -->
                
                
                <br> 
                <table id="projectTable" class="display table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Business Line ID</th>
                            <th>Business Line Name</th>
                            <th>Project ID</th>
                            <th>Project Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody> 
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

    var table = $('#projectTable').DataTable({
        processing: true,
        serverSide: true, 
        responsive: true,
        pageLength: 25,
        ajax: {
            url: '<?php echo e(url("/projectlist")); ?>',
            type: 'POST',
            dataType:"json",
            data: function (d) {
                d._token = '<?php echo e(csrf_token()); ?>';
                d.action = 'listProjects'; 
                d.name = $('.business_name').val(); 
                d.company_id = $('.company_id').val(); 
                d.status = $('.status').val(); 
            }
        },
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
        columns: [
        { data: 'business_line_id', name: 'business_line_id' },
        { data: 'name', name: 'name' },
        {
            data: 'project_id',
            name: 'project_id',
            render: function (data, type, row) {
                return type === 'display' ? stripHtmlTags(data) : data;
            }
        },
        {
            data: 'project_name',
            name: 'project_name',
            render: function (data, type, row) {
                return type === 'display' ? stripHtmlTags(data) : data;
            }
        },
        {
            data: 'status',
            name: 'status',
            render: function (data, type, row) {
                return type === 'display' ? stripHtmlTags(data) : data;
            }
        },
        {
            data: 'edit',
            name: 'edit',
            render: function (data, type, row, meta) {
                return type === 'display' ? stripHtmlTags(data) : data;
            }
        },
        ]
    });
 

   /* $(".business_name,.company_id, .status").on('change',function(){ 
        table.draw();
    }); */


    $(document).on('change', '.business_name, .company_id', function () {

        var company_id = $('.company_id').val();
        var business_id = $('.business_name').val(); 

        var url = '<?php echo url('/'); ?>/business-line-project-export?company_id=' + company_id + '&name=' + business_id;
        console.log(url)
        $('.businessProjectExportBtn').attr('href', url);
        table.draw();
    });


    function stripHtmlTags(html) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        return doc.body.textContent || "";
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/budget/projectlist.blade.php ENDPATH**/ ?>