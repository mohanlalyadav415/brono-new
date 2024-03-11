@extends('layouts.master')
@section('title') Service Type List @endsection
@section('content')
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mb-0">SERVICE TYPE LIST</h5>
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
                        href="{{ route('service.export') }}?status=1">
                        <i class="ri-export-fill"></i> Export</a>
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</button>
                    </div>
                </div> <br>  


                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>ID</th>                    
                            <th>Name</th>                   
                            <th>Expense Type</th>                   
                            <th>Cost per unit</th>                   
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
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Service</h4>
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
                                                <label for="name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>      
                                                <span style="color: red;" class="nameError"> </span>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="expense_type_id" class="control-label">Expense Type</label>
                                                <select name="expense_type_id" id="expense_type_id" class="form-control form-select" required="">
                                                    <option value="">Expense Type</option> 
                                                    <?php
                                                    foreach ($expensetypeList as $key => $value) { ?>
                                                        <option value="<?php echo $value->expense_type_id; ?>"><?php echo $value->expense_type_id.' '.$value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <span style="color: red;" class="expensetypeError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="contacts_email" class="control-label">Cost Per Unit</label>
                                                <input type="number" class="form-control" id="cost_per_unit" name="cost_per_unit" placeholder="Cost Per Unit" min="1"  required>
                                                <span style="color: red;" class="costperunitError"> </span>      
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
                                    <input type="hidden" name="service_id" id="service_id" />
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

@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script> 

<script type="text/javascript">   
    var table = $('#recordListing').DataTable({
        processing: true,
        serverSide: true, 
        pageLength: 25,
        "ordering": false,
        ajax: {
            url:'{{url("/")}}/servicelist', 
            dataType:"json",
            type:"POST",
            data: function (d) {
                d.action = 'listRecords';
                d._token = '{{ csrf_token() }}'; 
                d.status = $('.status_check').is(':checked') ? 1 : 0;  
                d.company_id = $('.company_id').val();  
            }
        },
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
        columns: [ 
        {data: 'service_id', name: 'service_id'},
        {data: 'name', name: 'name'}, 
        {data: 'expense_type', name: 'expense_type'},
        {data: 'cost_per_unit', name: 'cost_per_unit'},
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

        var url = '<?php echo url('/'); ?>/service-export?company_id=' + company_id + '&status=' + statusValue;
        console.log(url)
        $('.accountExportBtn').attr('href', url);
        table.draw();
    });



    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Service");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "{{ csrf_token() }}"});
        $.ajax({
            url:'{{url("/")}}/servicelist',
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
                $('.nameError').html('');
                $('.expensetypeError').html('');
                $('.costperunitError').html(''); 
                $.each(xhr.responseJSON.errors, function(key,value) {
                    if(key=='company_id'){
                        $('.companyError').text(value);
                    }
                    if(key=='name'){
                        $('.nameError').text(value);
                    }
                    if(key=='expense_type_id'){
                        $('.expensetypeError').text(value);
                    }
                    if(key=='cost_per_unit'){
                        $('.costperunitError').text(value);
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
            url:'{{url("/")}}/servicelist',
            method:"POST",
            data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#service_id').val(data.service_id);
                $('#company_id').val(data.company_id).change();
                $('#expense_type_id').val(data.expense_type_id).change();
                $('#name').val(data.name);
                $('#cost_per_unit').val(data.cost_per_unit);
                $('.delete').attr('id',data.service_id);  

                $('.checkSta').val(data.status);    
                if(data.status==1){
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }

                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Service");
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
                url:'{{url("/")}}/servicelist',
                method:"POST",
                data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
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
@endsection


