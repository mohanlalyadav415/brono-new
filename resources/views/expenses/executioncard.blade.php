@extends('layouts.master')
@section('title') Execution List @endsection
@section('content')
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center mb-0">EXECUTION LIST</h5>
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
                        <!-- <a class="float-right btn btn-xs btn-primary float-right btn-flat accountExportBtn"
                        href="{{ route('execution.resource.export') }}?status=1">
                        <i class="ri-export-fill"></i> Export</a> -->
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</button>
                    </div>
                </div> <br>  


                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>ID</th>                    
                            <th>Project</th>                   
                            <th>Date</th>            
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
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Execution</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_id" class="control-label">Company</label>
                                                <select name="company_id" id="company_id" class="form-control form-select company_id_ajax" required="">
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
                                                <label for="project_id" class="control-label">Project</label>
                                                <select name="project_id" id="project_id" class="form-control form-select" required="">
                                                    <option value="">Project</option>
                                                </select>
                                                <span style="color: red;" class="projectError"> </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="date" class="control-label">Date</label>
                                                <input type="date" name="date" class="form-control" id="date" required="">
                                                <span style="color: red;" class="dateError"> </span>
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
                                        <table class="table table-bordered table-striped" id="sortable">
                                            <thead>
                                                <tr> 
                                                    <th>Resource</th> 
                                                    <th>Service</th> 
                                                    <th>Qty</th> 
                                                    <th>Time</th> 
                                                    <th>
                                                        <a href="javascript:;" class="btn btn-danger add-more" id=""><i class="ri-add-box-line"></i> New</a> 
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="after-add-more">

                                            </tbody> 
                                <!-- <tbody id="tb">

                                </tbody>  -->
                            </table> 
                        </div> 
                    </div>

                    <div class="modal-footer"> 
                        <input type="hidden" name="execution_id" id="execution_id" />
                        <input type="hidden" name="action" id="action" value="" /> 
                        <button type="submit" name="save" id="save" class="btn btn-primary"><i class="ri-save-line"></i> Save</button> 
                        <!-- <button type="button" name="delete" class="btn btn-danger btn-xs delete" ><i class="ri-delete-bin-line"></i> Delete</button> -->

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
            url:'{{url("/")}}/executioncard', 
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
        {data: 'execution_id', name: 'execution_id'},
        {data: 'project', name: 'project'}, 
        {data: 'date', name: 'date'}, 
        {data: 'totalAmt', name: 'totalAmt'}, 
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

        var url = '<?php echo url('/'); ?>/execution-resource-export?company_id=' + company_id + '&status=' + statusValue;
        console.log(url)
        $('.accountExportBtn').attr('href', url);
        table.draw();
    });



    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Execution");
        $('#action').val('addRecord');
        $('#save').val('Add');
        document.getElementById('date').valueAsDate = new Date();
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "{{ csrf_token() }}"});
        $.ajax({
            url:'{{url("/")}}/executioncard',
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
                $('.projectError').html('');
                $('.dateError').html('');
                $('.qtyError').html('');
                $.each(xhr.responseJSON.errors, function(key,value) {
                    if(key=='company_id'){
                        $('.companyError').text(value);
                    }
                    if(key=='project_id'){
                        $('.projectError').text(value);
                    }
                    if(key=='date'){
                        $('.dateError').text(value);
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
            url:'{{url("/")}}/executioncard',
            method:"POST",
            data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#execution_id').val(data.execution_id);
                $('#company_id').val(data.company_id).change(); 
                $('#resource_id').val(data.resource_id).change();
                $('#service_id').val(data.service_id).change(); 
                $('#qty').val(data.qty); 
                $('#date').val(data.date); 
                $('#time_id').val(data.time_id).change(); 
                $('.delete').attr('id',data.execution_id);  

                $('.checkSta').val(data.status);    
                if(data.status==1){
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }

                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Execution");
                $('#action').val('updateRecord');
                $('#save').val('Save');

                if(data.company_id !=""){
                    $.ajax({
                        url:'{{url("/")}}/company-by-project',
                        type: 'POST',
                        data:{company_id:data.company_id,"_token": "{{ csrf_token() }}"},
                        success: function(data) {  
                            $('#project_id').html(data.data); 
                        }
                    });
                }
                setTimeout(function(){$('#project_id').val(data.project_id).change(); },500);

            }
        })
    });

    $("body").on('click', '.delete', function(){
        var id = $(this).attr("id");        
        var action = "deleteRecord";
        if(confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                url:'{{url("/")}}/executioncard',
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

    $('.company_id_ajax').change(function() {
        var company_id = $(this).val(); 
        $.ajax({ 
            url:'{{url("/")}}/company-by-project',
            type: 'POST',
            data:{company_id:company_id,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#project_id').html(data.data); 
                $('.resource_id').html(data.ResourceList); 
                $('.service_id').html(data.ServiceList); 
            }
        });
    });


    var max_fields      = 10;
    var wrapper         = $(".after-add-more");
    var add_button      = $(".add-more"); 

    var x = 1;
    $(add_button).on("click",function(e){ 

        var company_id = $('#company_id').val(); 
        if(company_id!=""){
            $.ajax({ 
                url:'{{url("/")}}/company-by-project',
                type: 'POST',
                data:{company_id:company_id,"_token": "{{ csrf_token() }}"},
                success: function(data) {  
                    $('#project_id').html(data.data); 
                    $('.resource_id').html(data.ResourceList); 
                    $('.service_id').html(data.ServiceList); 
                }
            });
            e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper).append('<tr><td><select name="resource_id[]" id="resource_id" class="resource_id form-control form-select" data-live-search="true" required="required"><option value="">Select</option></select></td><td><select name="service_id[]" id="service_id" class="service_id form-control form-select" data-live-search="true" required="required"><option value="">Select</option></select></td><td><div class="form-group mb-3"> <input type="number" class="form-control" name="qty[]" id="qty" min="1" required="" value="1"><span style="color: red;" class="qtyError" > </span></div></td><td><select name="time_id[]" id="time_id" class="form-control form-select" data-live-search="true" required="required"><option value="">Select</option><?php 
                        foreach ($timeList as $key => $value) { ?>
                            <option value="<?php echo $value->time_id; ?>"><?php echo $value->name; ?></option><?php } ?>
                            </select></td> <td align="center" class="text-danger"><button type="button" data-toggle="tooltip" data-placement="right" title="Click To Remove" class="btn btn-danger remove_field">Delete</button></td></tr>');
        }
        }else{
            alert('Please select the company')
        }
        

        
    }); 

    $(wrapper).on("click",".remove_field", function(e){  
        e.preventDefault(); $(this).closest('tr').remove(); x--;
    })

</script> 
@endsection