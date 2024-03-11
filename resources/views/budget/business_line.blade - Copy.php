@extends('layouts.master')
@section('title') Business Line List @endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">BUSINESS LINE LIST</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview"> 
                    <div class="container">
                        <div id="msg"></div>
                        <!-- <form id="form" method="post" onSubmit="return false;">
                            <input type="hidden" name="action" value="saveAddMore">
                            <table class="table table-bordered table-striped" id="buttons-datatables">
                                <thead>
                                    <tr>
                                        <th width="20">Sr#</th>
                                        <th width="120" class="text-center">Company</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tb">
                                    <?php
                                    //if (isset($listBusiness) && !empty($listBusiness)) {
                                        //foreach ($listBusiness as $key => $value) { ?>
                                            <tr>
                                                <td><?php //echo $value->business_line_id; ?></td>
                                                <td><?php //echo $value->company_name; ?></td>
                                                <td><?php //echo $value->name; ?></td>
                                                <td><?php //echo ($value->status==1 ? "Active" : "Inactive"); ?></td> 
                                                <td>
                                                    <a href="{{url('/').'/delete_business_card/'}}{{$value->business_line_id}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?')"><i class="ri-delete-bin-line"></i> Delete</a>
                                                </td> 
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <a href="javascript:;" class="btn btn-danger" id="addmore"><i class="ri-add-box-line"></i> Add More</a>
                                            <button type="submit" name="save" id="save" value="save" class="btn btn-primary" hidden><i class="ri-save-line"></i> Save</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>  -->
                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">        
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3 class="panel-title"></h3>
                                    </div>
                                    <div class="col-md-2" align="right">
                                        <button type="button" name="add" id="addRecord" class="btn btn-success">Add New</button>
                                    </div>
                                </div>
                            </div>
                            <table id="recordListing" class="table table-bordered table-striped">
                                <thead>
                                    <tr> 
                                        <th>Business line</th>                   
                                        <th>Comapny</th>                    
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>                   
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="recordModal" class="modal fade">
                            <div class="modal-dialog">
                                <form method="post" id="recordForm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Business Line</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="lastname" class="control-label">Company</label>                         
                                                <select name="company_id" id="company_id" class="form-control">
                                                    <?php
                                                    $companyList = DB::table('tbl_companies')->get();
                                                    foreach ($companyList as $key => $value) { ?>
                                                        <option value="<?php echo $value->company_id; ?>"><?php echo $value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select>       
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>      
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="control-label">Status</label>
                                                <div class="form-switch form-switch-lg">
                                                    <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="business_line_id" id="business_line_id" />
                                            <input type="hidden" name="action" id="action" value="" />
                                            <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> <!--/.container-->
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
    $(document).ready(function(e) { 

        var dataRecords = $('#recordListing').DataTable({
            "lengthChange": false,
            "processing":true,
            "serverSide":true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',     
            "order":[],
            "ajax":{
                url:'{{url("/")}}/business-line-list',
                type:"POST",
                data:{action:'listRecords',"_token": "{{ csrf_token() }}"},
                dataType:"json"
            },
            "columnDefs":[
            {
                "targets":[0, 3, 4],
                "orderable":false,
            },
            ],
            "pageLength": 10
        }); 


        $('#addRecord').click(function(){
            $('#recordModal').modal('show');
            $('#recordForm')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus'></i> Add Record");
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
                    dataRecords.ajax.reload();
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

                    $('#customSwitchsizelg').val(data.status);    
                    $('.modal-title').html("<i class='fa fa-plus'></i> Edit Business Line");
                    $('#action').val('updateRecord');
                    $('#save').val('Save');
                }
            })
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
                    dataRecords.ajax.reload();
                }
            })
        });     


        $("#recordListing").on('click', '.delete', function(){
            var id = $(this).attr("id");        
            var action = "deleteRecord";
            if(confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    url:'{{url("/")}}/business-line-list',
                    method:"POST",
                    data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
                    success:function(data) {                    
                        dataRecords.ajax.reload();
                    }
                })
            } else {
                return false;
            }
        }); 


        /*$("#addmore").on("click",function(){
            $.ajax({
                type:'POST',
                url:'{{url("/")}}/get-business-line',
                data:{'action':'addDataRow',"_token": "{{ csrf_token() }}",},
                success: function(data){
                    $('#tb').append(data); 
                    $('#save').removeAttr('hidden',true);
                }
            });
        });

        $("#form").on("submit",function(){
            $.ajax({
                type:'POST',
                url:'{{url("/")}}/get-business-line',
                data:$(this).serialize(),
                success: function(data){
                    var a   =   data.split('|***|');
                    if(a[1]=="add"){
                        $('#mag').html(a[0]);
                        setTimeout(function(){location.reload();},500);
                    }
                }
            });
        });


        $("#form").on("submit", function (e) {
            e.preventDefault(); 

            var formData = $(this).serializeArray();
            formData.push({name: "_token", value: "{{ csrf_token() }}"});

            $.ajax({
                type: 'POST',
                url: '{{ url("/") }}/get-business-line',
                data: formData,
                success: function (data) { 
                    setTimeout(function () { location.reload(); }, 500);
                }
            });
        }); */
    }); 
</script> 
@endsection


