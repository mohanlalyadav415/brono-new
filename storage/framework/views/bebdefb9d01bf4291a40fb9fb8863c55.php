<?php $__env->startSection('title'); ?> Account List <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mb-0">ACCOUNT LIST</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2">
                        <label for="status_check"><input type="checkbox" checked class="status_check" id="status_check" name="status"> Hide inactive account</label>
                    </div> 
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
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat accountExportBtn"
                        href="<?php echo e(route('account.export')); ?>?status=1">
                        <i class="ri-export-fill"></i> Export</a>
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</button>
                    </div>
                </div> <br>  


                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>Account ID</th>                    
                            <th>Account External ID</th>                   
                            <th>Account</th>                   
                            <th style="width: 150px;">Status</th>
                            <th>Action</th>              
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <div class="modal" id="recordModal">
                    <div class="modal-dialog">
                        <form method="post" id="recordForm" class="row g-3 needs-validation" novalidate>
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Account</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="account_external_id" class="control-label">Account External ID</label>
                                        <input type="text" class="form-control" id="account_external_id" name="account_external_id" placeholder="Account External ID" required>      
                                    </div><br>
                                    <div class="form-group">
                                        <label for="company_id" class="control-label">Company</label>
                                        <select name="company_id" id="company_id" class="company_id form-control form-select" required="">
                                            <option value="">Company</option> 
                                            <?php
                                            foreach ($companyList as $key => $value) { ?>
                                                <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="account_name" class="control-label">Account Name</label>
                                        <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" required>      
                                    </div><br>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Status</label>
                                        <div class="form-switch form-switch-lg">
                                            <input type="checkbox" class="form-check-input checkSta" id="customSwitchsizelg" name="status[]">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer"> 
                                    <input type="hidden" name="account_id" id="account_id" />
                                    <input type="hidden" name="action" id="action" value="" /> 
                                    <button type="submit" name="save" id="save" class="btn btn-primary"><i class="ri-save-line"></i> Save</button> 
                                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button>

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
    var table = $('#recordListing').DataTable({
        processing: true,
        serverSide: true, 
        pageLength: 25,
        "ordering": false,
        ajax: {
            url:'<?php echo e(url("/")); ?>/account-list', 
            dataType:"json",
            type:"POST",
            data: function (d) {
                d.action = 'listRecords';
                d._token = '<?php echo e(csrf_token()); ?>'; 
                d.status = $('.status_check').is(':checked') ? 1 : 0;  
                d.company_id = $('.company_id').val();  
            }
        },
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
        columns: [ 
        {data: 'account_id', name: 'account_id'},
        {data: 'account_external_id', name: 'account_external_id'},
        {data: 'account_name', name: 'account_name'}, 
        {
            data: 'status',
            name: 'status',
            render: function (data, type, row) {
                return data == 1 ? '<div class="col-md-6 position-relative form-check form-switch form-switch-lg"style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "")+ '></div>' : '<div class="col-md-6 position-relative form-check form-switch form-switch-lg"style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "")+ '></div>';
            }
        },
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ] 
    });   

    $(document).on('change', '.status_check, .company_id', function () {

        if ($(this).hasClass('status_check')) {
            table.ajax.reload();
        }
        var company_id = $(this).val();
        var statusValue = $('.status_check').is(':checked') ? 1 : ''; 

        if(company_id=="on"){
            company_id = '';
        }

        var url = '<?php echo url('/'); ?>/account-export?company_id=' + company_id + '&status=' + statusValue;
        console.log(url)
        $('.accountExportBtn').attr('href', url);
        table.draw();
    });



    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Account");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "<?php echo e(csrf_token()); ?>"});
        $.ajax({
            url:'<?php echo e(url("/")); ?>/account-list',
            method:"POST",
            data:formData,
            success:function(data){             
                $('#recordForm')[0].reset();
                $('#recordModal').modal('hide');                
                $('#save').attr('disabled', false);
                table.ajax.reload();
            }
        })
    });     

    $("#recordListing").on('click', '.update', function(){
        var id = $(this).attr("id");
        var action = 'getRecord';
        $.ajax({
            url:'<?php echo e(url("/")); ?>/account-list',
            method:"POST",
            data:{id:id, action:action,"_token": "<?php echo e(csrf_token()); ?>"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#account_id').val(data.account_id);
                $('#account_name').val(data.account_name);  
                $('#account_external_id').val(data.account_external_id);
                $('#company_id').val(data.company_id).change();
                $('.delete').attr('id',data.account_id);  

                $('.checkSta').val(data.status);    
                if(data.status==1){ 
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }
                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Account");
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
                url:'<?php echo e(url("/")); ?>/account-list',
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



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/budget/account_list.blade.php ENDPATH**/ ?>