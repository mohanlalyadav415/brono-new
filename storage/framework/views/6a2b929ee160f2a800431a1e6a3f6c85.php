<?php $__env->startSection('title'); ?> Supplier List <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mb-0">SUPPLIER LIST</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2">
                        <label for="status_check"><input type="checkbox" checked class="status_check" id="status_check" name="status"> Hide inactive</label>
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
                        href="<?php echo e(route('supplier.export')); ?>?status=1">
                        <i class="ri-export-fill"></i> Export</a>
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</button>
                    </div>
                </div> <br>  


                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>ID</th>                    
                            <th>RUT</th>                   
                            <th>Name</th>                   
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
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Supplier</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_id" class="control-label">Company</label>
                                                <select name="company_id" id="company_id" class="form-control form-select" required="">
                                                    <option value="">Company</option> 
                                                    <?php
                                                    foreach ($companyList as $key => $value) { ?>
                                                        <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <span style="color: red;" class="companyError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="organization_type_id" class="control-label">Organization Type</label>
                                                <select name="organization_type_id" id="organization_type_id" class="organization_type_id form-control form-select" required="">
                                                    <option value="">Organization Type</option> 
                                                    <?php
                                                    foreach ($organizationtype as $key => $value) { ?>
                                                        <option value="<?php echo $value->organization_type_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <span style="color: red;" class="organizationError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>      
                                                <span style="color: red;" class="nameError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="rut" class="control-label">RUT</label>
                                                <input type="text" class="form-control" id="rut" name="rut" placeholder="RUT" required>
                                                <span style="color: red;" class="rutError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="contacts_email" class="control-label">Contacts Email</label>
                                                <input type="text" class="form-control" id="contacts_email" name="contacts_email" placeholder="Example : a@gmail.com,b@gmail.com,c@gmail.com " required>
                                                <span style="color: red;" class="contactsemailError"> </span>      
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="contact_name" class="control-label">Contact Name</label>
                                                <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Contacts Name" required>  
                                                <span style="color: red;" class="contactnameError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="dte_type_id" class="control-label">DTE Type</label>
                                                <select name="dte_type_id" id="dte_type_id" class="dte_type_id form-control form-select" required="">
                                                    <option value="">DTE Type</option> 
                                                    <?php
                                                    foreach ($dtetype as $key => $value) { ?>
                                                        <option value="<?php echo $value->dte_type_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <span style="color: red;" class="dtetypeidError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="control-label">Status</label>
                                                <div class="form-switch form-switch-lg">
                                                    <input type="checkbox" class="form-check-input checkSta" id="customSwitchsizelg" name="status[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                <div class="modal-footer"> 
                                    <input type="hidden" name="supplier_id" id="supplier_id" />
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
            url:'<?php echo e(url("/")); ?>/supplierlist', 
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
        {data: 'supplier_id', name: 'supplier_id'},
        {data: 'rut', name: 'rut'},
        {data: 'name', name: 'name'}, 
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

        var url = '<?php echo url('/'); ?>/supplier-export?company_id=' + company_id + '&status=' + statusValue;
        console.log(url)
        $('.accountExportBtn').attr('href', url);
        table.draw();
    });



    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Supplier");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "<?php echo e(csrf_token()); ?>"});
        $.ajax({
            url:'<?php echo e(url("/")); ?>/supplierlist',
            method:"POST",
            data:formData,
            success:function(data){             
                $('#recordForm')[0].reset();
                $('#recordModal').modal('hide');                
                $('#save').attr('disabled', false);
                table.ajax.reload();
            },
            error: function (xhr) {
                $('.companyError').html('');
                $('.contactnameError').html('');
                $('.organizationError').html('');
                $('.nameError').html('');
                $('.rutError').html('');
                $('.contactsemailError').html('');
                $('.dtetypeidError').html('');
                $.each(xhr.responseJSON.errors, function(key,value) {
                    if(key=='company_id'){
                        $('.companyError').text(value);
                    }
                    if(key=='contact_name'){
                        $('.contactnameError').text(value);
                    }
                    if(key=='organization_type_id'){
                        $('.organizationError').text(value);
                    }
                    if(key=='name'){
                        $('.nameError').text(value);
                    }
                    if(key=='rut'){
                        $('.rutError').text(value);
                    }
                    if(key=='contacts_email'){
                        $('.contactsemailError').text(value);
                    }
                    if(key=='dte_type_id'){
                        $('.dtetypeidError').text(value);
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
            url:'<?php echo e(url("/")); ?>/supplierlist',
            method:"POST",
            data:{id:id, action:action,"_token": "<?php echo e(csrf_token()); ?>"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#supplier_id').val(data.supplier_id);
                $('#contact_name').val(data.contact_name);  
                $('#contacts_email').val(data.contacts_email);
                $('#dte_type_id').val(data.dte_type_id).change();
                $('#name').val(data.name);
                $('#organization_type_id').val(data.organization_type_id).change();
                $('#company_id').val(data.company_id).change();
                $('#rut').val(data.rut);
                $('.delete').attr('id',data.supplier_id);  

                $('.checkSta').val(data.status);    
                if(data.status==1){
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }

                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Supplier");
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
                url:'<?php echo e(url("/")); ?>/supplierlist',
                method:"POST",
                data:{id:id, action:action,"_token": "<?php echo e(csrf_token()); ?>"},
                success:function(data) {                    
                    table.ajax.reload();
                    $('#recordModal').modal('hide');
                }
            })
        }else{
            return false;
        }
    });  
</script> 
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/expenses/supplierlist.blade.php ENDPATH**/ ?>