@extends('layouts.master')
@section('title') Business Line List @endsection
@section('content')
<?php $companyList = DB::table('tbl_companies')->get();?>
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">BUSINESS LINE LIST</h5>
            </div>
            <div class="card-body">   

                <div class="row">
                    <div class="col-md-3">
                        <select class="business_name form-control form-select">
                            <option value="">Business line</option> 
                            <?php 
                            foreach ($dataNameList as $key => $value) { ?>
                                <option value="<?php echo $value->name; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-3">
                        <select name="company_id" class="company_id form-control form-select">
                            <option value="">Company</option> 
                            <?php
                            foreach ($companyList as $key => $value) { ?>
                                <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div> -->
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New Business Line</button>
                    </div>
                </div>  
                <br>

                <table id="recordListing" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr> 
                            <th>Comapny</th>                    
                            <th>Business line Name</th>                   
                            <th style="width: 150px;">Status</th>
                            <th>Action</th>              
                        </tr>
                    </thead>
                </table> 

                <div class="modal" id="recordModal">
                    <div class="modal-dialog">
                        <form method="post" id="recordForm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Business Line</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="lastname" class="control-label">Company</label>                         
                                        <select name="company_id" id="company_id" class="form-control form-select">
                                            <?php
                                            foreach ($companyList as $key => $value) { ?>
                                                <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                                            <?php }
                                            ?>
                                        </select>       
                                    </div><br>
                                    <div class="form-group">
                                        <label for="name" class="control-label ">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>      
                                    </div><br>
                                    <div class="form-group">
                                        <label for="customSwitchsizelg" class="control-label">Status</label>
                                        <div class="form-switch form-switch-lg">
                                            <input type="checkbox" class="form-check-input checkSta" id="customSwitchsizelg" name="status[]" >
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <input type="hidden" name="business_line_id" id="business_line_id" />
                                    <input type="hidden" name="action" id="action" value="" />

                                    <button type="submit" name="save" id="save" class="btn btn-info"><i class="ri-save-line"></i> Save</button>
                                    <!-- <input type="submit" name="save" id="save" class="btn btn-info" value="Save" /> -->
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
        ordering: false,
        serverSide: true,
        responsive: true,
        pageLength: 25,
        ajax: {
            url:'{{url("/")}}/business-line-list', 
            dataType:"json",
            type:"POST",
            data: function (d) {
                d.action = 'listRecords';
                d._token = '{{ csrf_token() }}';
                d.name = $('.business_name').val(); 
                d.company_id = $('.company_id').val(); 
                d.status = $('.status').val(); 
                d.search = $('input[type="search"]').val();
            }
        },
        columnDefs: [
        {"className": "dt-center", "targets": "_all"}
        ],
        columns: [ 
        {data: 'company_name', name: 'company_name'},
        {data: 'name', name: 'name'},
        {
            data: 'status',
            name: 'status',
            render: function (data, type, row) {
                return data == 1 ? '<div class="col-md-6 position-relative form-check form-switch form-switch-lg" style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "") + '></div>' : '<div class="col-md-6 position-relative form-check form-switch form-switch-lg"style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" '+(data == 1 ? "checked" : "") + '></div>';
            }
        },
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        /*initComplete: function () {
            var selectArray = ['Company', 'Business Line', 'Status'];

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

    $(".business_name").on('change',function(){ 
        table.draw();
    });
    $(".company_id").on('change',function(){ 
        table.draw();
    });
    $(".status").on('change',function(){ 
        table.draw();
    });

    $('#addRecord').click(function(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Business Line");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled'); 

        var formData = $(this).serializeArray();
        formData.push({name: "_token", value: "{{ csrf_token() }}"});


        $.ajax({
            url:'{{url("/")}}/business-line-list',
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
            url:'{{url("/")}}/business-line-list',
            method:"POST",
            data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#business_line_id').val(data.business_line_id);
                $('#name').val(data.name); 
                $('#company_id').val(data.company_id).change();
                $('.delete').attr('id',data.business_line_id);  

                $('.checkSta').val(data.status);    
                if(data.status==1){
                    $('.checkSta').prop('checked',true);    
                }else{
                    $('.checkSta').prop('checked',false);    
                }
                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Business Line");
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
                url:'{{url("/")}}/business-line-list',
                method:"POST",
                data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
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
@endsection


