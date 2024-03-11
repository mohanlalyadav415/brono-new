<?php $__env->startSection('title'); ?> Project Budget <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mb-0">PROJECT BUDGET</h5>
            </div>
            <div class="card-body"> 
                <?php if(session('success')): ?> 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b><?php echo e(session('success')); ?>.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
                <?php endif; ?>   
                <div class="row">
                    <div class="col-md-2">
                        <select class="company_id form-control form-select">
                            <option value="">Company</option> 
                            <?php 
                            foreach ($companyList as $key => $value) { ?>
                                <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="project_id form-control form-select">
                            <option value="">Project</option> 
                            <?php 
                            foreach ($projectList as $key => $value) { ?>
                                <option value="<?php echo $value->project_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="budget_type_id form-control form-select">
                            <option value="">Budget Type</option> 
                            <?php 
                            foreach ($budgetTypeList as $key => $value) { ?>
                                <option value="<?php echo $value->budget_type_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div> 
                    <div class="col-md-2">
                        <select class="expense_type_id form-control form-select">
                            <option value="">Expense Type</option> 
                            <?php 
                            foreach ($expenseTypeList as $key => $value) { ?>
                                <option value="<?php echo $value->expense_type_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div style="float: right;">

                            <a class="btn btn-xs btn-primary" id="importPopup" href="#" ><i class="ri-import-fill"></i> Import</a> 
                            <a class="btn btn-xs btn-primary budgetExportBtn"href="<?php echo e(route('budget.export')); ?>" ><i class="ri-export-fill"></i> Export</a> 

                            <button type="button" name="add" id="addRecord" class="btn btn-primary" ><i class="ri-add-box-line"></i> New</button>

                        </div>
                    </div>
                </div> <br>  


                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>ID</th>                    
                            <th>Expense Type</th>                   
                            <th>Year</th>                   
                            <th>Month</th>                   
                            <th>Amount</th>                   
                            <th>Qty</th>                   
                            <th style="width: 150px;">Status</th>
                            <th>Action</th>              
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                

                <div class="modal" id="recordModal">
                    <div class="modal-dialog modal-lg">
                        <form method="post" id="recordForm" class="row g-3 needs-validation" novalidate>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Project Budget</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_id" class="control-label">Company</label>
                                                <select name="company_id" id="company_id" class="company_id form-control form-select" required="">
                                                    <option value="">Company</option> 
                                                    <?php
                                                    foreach ($companyList as $key => $value) { ?>
                                                        <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="project_id" class="control-label">Project</label>
                                                <select name="project_id" id="project_id" class="project_id form-control form-select" required="">
                                                    <option value="">Project</option> 
                                                    <?php
                                                    foreach ($projectList as $key => $value) { ?>
                                                        <option value="<?php echo $value->project_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="budget_type_id" class="control-label">Budget Type</label>
                                                <select name="budget_type_id" id="budget_type_id" class="budget_type_id form-control form-select" required="">
                                                    <option value="">Budget Type</option> 
                                                    <?php
                                                    foreach ($budgetTypeList as $key => $value) { ?>
                                                        <option value="<?php echo $value->budget_type_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="expense_type_id" class="control-label">All Expense Type</label>
                                                <select name="expense_type_id" id="expense_type_id" class="expense_type_id form-control form-select" required="">
                                                    <option value="">All Expense Type</option>  
                                                    <?php 
                                                    foreach ($expenseTypeList as $key => $value) { ?>
                                                        <option value="<?php echo $value->expense_type_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="movement_type_id" class="control-label">All Movement</label>
                                                <select name="movement_type_id" id="movement_type_id" class="movement_type_id form-control form-select" required="">
                                                    <option value="">All Movement</option> 
                                                    <?php
                                                    foreach ($movementList as $key => $value) { ?>
                                                        <option value="<?php echo $value->movement_type_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="year" class="control-label">Year</label>
                                                <select name="year" id="year" class="year form-control form-select" required="">
                                                    <option value="">Year</option>  
                                                    <option value="2024">2024</option> 
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="month_id" class="control-label">Month</label>
                                                <select name="month_id" id="month_id" class="month_id form-control form-select" required="">
                                                    <option value="">Month</option> 
                                                    <?php
                                                    foreach ($monthList as $key => $value) { ?>
                                                        <option value="<?php echo $value->month_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="amount" class="control-label">Amount</label>
                                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" required="">   
                                                <span style="color: red;" class="amountError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="qty" class="control-label">Qty</label>
                                                <input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" required="">
                                                <span style="color: red;" class="qtyError"> </span>     
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="customSwitchsizelg" class="control-label">Status</label>
                                                <div class="form-switch form-switch-lg">
                                                    <input type="checkbox" class="form-check-input checkSta" id="customSwitchsizelg" name="status[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                                <div class="modal-footer"> 
                                    <input type="hidden" name="budget_id" id="budget_id" />
                                    <input type="hidden" name="action" id="action" value="" /> 
                                    <button type="submit" name="save" id="save" class="btn btn-primary"><i class="ri-save-line"></i> Save</button> 
                                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>



                <div class="modal" id="importModal">
                    <div class="modal-dialog modal-lg">
                        <form action="<?php echo e(url('/budget-import')); ?>" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            <?php echo csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Import Budget</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_id" class="control-label">Choose Excel File</label>
                                                <input type="file" name="file" class="form-control" accept=".xlsx, .csv" required> 
                                            </div>
                                        </div>    
                                    </div>  
                                </div> 
                                <div class="modal-footer"> 
                                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save</button> 
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div> 
                            </div>
                        </form>
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

    $('#importPopup').click(function(){
        $('#importModal').modal('show');

    });

    var table = $('#recordListing').DataTable({
        processing: true,
        serverSide: true, 
        "ordering": false,
        pageLength: 25,
        ajax: {
            url:'<?php echo e(url("/")); ?>/budget-project-list', 
            dataType:"json",
            type:"POST",
            data: function (d) {
                d.action = 'listRecords';
                d._token = '<?php echo e(csrf_token()); ?>'; 
                d.company_id = $('.company_id').val();  
                d.project_id = $('.project_id').val();  
                d.budget_type_id = $('.budget_type_id').val();  
                d.expense_type_id = $('.expense_type_id').val();  
            }
        },
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
        columns: [ 
        {data: 'budget_id', name: 'budget_id'},
        {data: 'expense_name', name: 'expense_name'}, 
        {data: 'year', name: 'year'}, 
        {data: 'month_name', name: 'month_name'}, 
        {data: 'amount', name: 'amount'}, 
        {data: 'qty', name: 'qty'}, 
        {
            data: 'status',
            name: 'status',
            render: function (data, type, row) {
                return data == 1 ? '<div class="col-md-6 position-relative form-check form-switch form-switch-lg"style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "")+ '></div>' : '<div class="col-md-6 position-relative form-check form-switch form-switch-lg"style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "")+ '></div>';
            }
        },
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        /*,initComplete: function () {
            var selectArray = [];

            this.api().columns().every(function (indexVar) {
                if (indexVar < selectArray.length) {

                    var column = this;
                    var select = $('<select><option value="">' + selectArray[indexVar] + '</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                    if (selectArray[indexVar] === 'Status') {
                        select.append('<option value="1">Active</option>');
                        select.append('<option value="0">Inactive</option>');
                    } else {
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });

                    }
                }
            });
        }*/
    });  
    

    $(".company_id, .project_id, .budget_type_id, .expense_type_id").on('change',function(){
        var company_id = $('.company_id').val();
        var project_id = $('.project_id').val();
        var budget_type_id = $('.budget_type_id').val();
        var expense_type_id = $('.expense_type_id').val();

        var url = '<?php echo url('/'); ?>/budget-export?company_id=' + company_id +
        '&project_id=' + project_id +
        '&budget_type_id=' + budget_type_id +
        '&expense_type_id=' + expense_type_id;
        $('.budgetExportBtn').attr('href', url);
        table.draw();
    });

    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Project Budget");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "<?php echo e(csrf_token()); ?>"});
        $.ajax({
            url:'<?php echo e(url("/")); ?>/budget-project-list',
            method:"POST",
            data:formData,
            success:function(data){             
                if(data){
                    $('#recordForm')[0].reset();
                    $('#recordModal').modal('hide');                
                    $('#save').attr('disabled', false);
                    table.ajax.reload();
                }
            },

            error: function (xhr) {
                $('.amountError').html('');
                $.each(xhr.responseJSON.errors, function(key,value) {
                    if(key=='amount'){
                        $('.amountError').text(value);
                    }
                    if(key=='qty'){
                        $('.qtyError').text(value);
                    }
                });  
                $('#save').attr('disabled', false);
            }

        })
    });     

    $("#recordListing").on('click', '.update', function(){
        var id = $(this).attr("id");
        var action = 'getRecord';
        $.ajax({
            url:'<?php echo e(url("/")); ?>/budget-project-list',
            method:"POST",
            data:{id:id, action:action,"_token": "<?php echo e(csrf_token()); ?>"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#budget_id').val(data.budget_id);
                $('#company_id').val(data.company_id).change();
                $('#project_id').val(data.project_id).change();
                $('#budget_type_id').val(data.budget_type_id).change();
                $('#expense_type_id').val(data.expense_type_id).change();
                $('#movement_type_id').val(data.movement_type_id).change();
                $('#year').val(data.year).change();
                $('#month_id').val(data.month_id).change();
                $('#amount').val(data.amount);  
                $('#qty').val(data.qty);  
                $('.delete').attr('id',data.budget_id);

                $('.checkSta').val(data.status);    
                if(data.status==1){ 
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }
                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Project Budget");
                $('#action').val('updateRecord');
                $('#save').val('Save');
            }
        })
    });

    $("body").on('click', '.delete', function(){
        var id = $(this).attr("id");        
        var action = "deleteRecord";
        if(confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                url:'<?php echo e(url("/")); ?>/budget-project-list',
                method:"POST",
                data:{id:id, action:action,"_token": "<?php echo e(csrf_token()); ?>"},
                success:function(data) {                    
                    table.ajax.reload();
                    $('#recordModal').modal('hide');
                }
            })
        } else {
            return false;
        }
    });  
</script> 
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/budget/budget_project_list.blade.php ENDPATH**/ ?>