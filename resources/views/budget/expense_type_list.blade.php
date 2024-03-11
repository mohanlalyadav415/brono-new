@extends('layouts.master')
@section('title') Expense Type List @endsection
@section('content')
<style type="text/css">
    .dataTables_filter, .dataTables_info { display: none; }
</style>
<style type="text/css"> 
    #loader-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    #loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    #loader img {
        width: 50px;
        height: 50px;
    }

    #loader p {
        margin-top: 10px;
        font-weight: bold;
    }

</style>
<div id="loader-overlay">
    <div id="loader">
        <img src="{{url('/')}}/images/spinner.gif" alt="Loading...">
        <p>Loading...</p>
    </div>
</div> 
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">EXPENSE TYPE</h5>
            </div>
            <div class="card-body">  
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
                        <select class="expense_type_id form-control form-select">
                            <option value="">Expense Type</option> 
                            <?php 
                            foreach ($expensetypeList as $key => $value) { ?>
                                <option value="<?php echo $value->expense_type_id; ?>"><?php echo $value->name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat expenseTypeExportBtn"
                        href="{{ route('expense.type.export') }}">
                        <i class="ri-export-fill"></i> Export</a>
                        <button type="button" name="add" id="addRecord" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</button>
                    </div>
                </div> <br>  

                <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

                    <thead>
                        <tr> 
                            <th>ID</th>                    
                            <th>Name</th>                   
                            <th>Account Debit</th>                   
                            <th>Account Credit</th>              
                            <th>Cost Center</th>              
                            <th>Project</th>                   
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
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Expense Type</h4>
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
                                                <label for="name" class="control-label">Expense Type Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Expense Type Name" required="">  
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="account_debit" class="control-label">Account Debit</label>
                                                <select name="account_debit" id="account_debit" class="account_debit form-control form-select" required="">
                                                    <option value="">Account Debit</option> 
                                                    <?php
                                                    foreach ($accountList as $key => $value) { ?>
                                                        <option value="<?php echo $value->account_id; ?>"><?php echo $value->account_external_id.'  '.$value->account_name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="account_credit" class="control-label">Account Credit</label>
                                                <select name="account_credit" id="account_credit" class="account_credit form-control form-select" required="">
                                                    <option value="">Account Credit</option> 
                                                    <?php
                                                    foreach ($accountList as $key => $value) { ?>
                                                        <option value="<?php echo $value->account_id; ?>"><?php echo $value->account_external_id.'  '.$value->account_name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="cost_centre_id" class="control-label">Cost Center</label>
                                                <select name="cost_centre_id"  id="cost_centre_id" class="cost_centre_id form-control form-select" required="">
                                                    <option value="">Budget Type</option> 
                                                    <?php
                                                    foreach ($costcentreList as $key => $value) { ?>
                                                        <option value="<?php echo $value->cost_centre_id; ?>"><?php echo $value->cost_center_external_id.'  '.$value->name ?></option>
                                                    <?php }
                                                    ?>
                                                </select> 
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
                                    <input type="hidden" name="expense_type_id" id="expense_type_id" />
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

<div class="modal" id="projectAssignModal">
    <div class="modal-dialog modal-lg">
        <form method="post" id="projectForm" class="row g-3 needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Project of the Expense Type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3" style="text-align: center;">
                                <p id="company_name"></p>
                                <p id="expense_name"></p>
                                <div class="setProjectList"></div> 
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="modal-footer"> 
                    <input type="hidden" name="expense_project_type_id" class="expense_project_type_id" />
                    <input type="hidden" name="action" id="actionProject" value="" /> 
                    <button type="submit" name="saveProject" id="saveProject" class="btn btn-primary"><i class="ri-save-line"></i> Save</button> 
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div> 


@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script> 
<!-- Include Select2 plugin -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>  -->
    <script type="text/javascript">
        function showLoader() {
            $('#loader-overlay').show();
        }

        function hideLoader() {
            $('#loader-overlay').hide();
        }

        var table = $('#recordListing').DataTable({
            processing: true,
            serverSide: true, 
            "ordering": false,
            pageLength: 25,
            ajax: {
                url:'{{url("/")}}/expense-type-list', 
                dataType:"json",
                type:"POST",
                data: function (d) {
                    d.action = 'listRecords';
                    d._token = '{{ csrf_token() }}'; 
                    d.company_id = $('.company_id').val();   
                    d.expense_type_id = $('.expense_type_id').val();  
                }
            },
            columnDefs: [
            {"className": "dt-center", "targets": "_all"}
            ],
            columns: [ 
            {data: 'expense_type_id', name: 'expense_type_id'},
            {data: 'name', name: 'name'}, 
            {data: 'debit_account_name', name: 'debit_account_name'}, 
            {data: 'credit_account_name', name: 'credit_account_name'}, 
            {data: 'cost_center_name', name: 'cost_center_name'}, 

            {
                data: 'all_projects',
                name: 'all_projects',
                render: function (data, type, row) {  
                    var isChecked = row.all_projects==1 ? 'checked' : '';
                    if (data == 1) { 
                        setTimeout(function(){
                            $('#access_button_data_' + row.expense_type_id).hide();
                        },500)
                    }

                    return '<input type="hidden" name="expense_project_type_SET" class="expense_project_type_SET" value="'+row.expense_type_id+'"><label><input type="checkbox" data-id="'+row.company_id+'" class="allBtnHideShow" '+isChecked+'><b>All</b><label>&nbsp;&nbsp;<button class="access-button btn btn-info" id="access_button_data_'+row.expense_type_id+'" data-id="'+row.company_id+'" value="'+row.name+'" >Projects</button>';

                }
            },
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

       /* $(".company_id, .expense_type_id").on('change',function(){ 
            table.draw();
        });*/




        $(document).on('change', '.expense_type_id, .company_id', function () {
            var company_id = $('.company_id').val();
            var expense_type_id = $('.expense_type_id').val();
            
            var url = '<?php echo url('/'); ?>/expense-type-export?company_id=' + company_id + '&expense_type_id=' + expense_type_id;
            console.log(url)
            $('.expenseTypeExportBtn').attr('href', url);
            table.draw();
        });


        $("table").on("change", ".allBtnHideShow", function() {

            var statusValue = $(this).is(':checked') ? 1 : 0;
            var company_id = $(this).attr("data-id"); 
            var expense_type_id = $('input[type=hidden]', $(this).closest("td")).val();

            if (statusValue == 1) { 
                $(this).closest('tr').find('.access-button').hide();
            } else {
                $(this).closest('tr').find('.access-button').show();
            }

            if(confirm("Are you sure you want to check all ?")) {
                showLoader();
                $.ajax({
                    url:'{{url("/")}}/expense-type-list',
                    method:"POST", 
                    data:{company_id:company_id,expense_type_id:expense_type_id,checkboxVal : statusValue,action:'actionAllProject',"_token": "{{ csrf_token() }}"},
                    dataType:"json",
                    success:function(data){ 
                        hideLoader();
                    }
                });

            }else {
                return false;
            } 
        });

        $("table").on("click", ".access-button", function() {

            var company_id = $(this).attr("data-id"); 
            var expense_name = $(this).val();
        //var allBtnHideShow = $('.allBtnHideShow', $(this).closest("td")).val();
            //alert(allBtnHideShow)
            var associateID = $('input[type=hidden]', $(this).closest("td")).val();
            $('.expense_project_type_id').val(associateID); 
            $.ajax({
                url:'{{url("/")}}/get-project-list-by-company',
                method:"POST",
                data:{company_id:company_id,expense_type_id:associateID,"_token": "{{ csrf_token() }}"},
                dataType:"json",
                success:function(data){
                    //setProjectList 
                    $('#projectAssignModal').modal('show'); 
                    $('#expense_name').text("Expense Type : " +expense_name);
                    $('#company_name').text("Company Name : " +data.company_name[0]);
                    $('#actionProject').val('addExpenseProject');
                    $('.setProjectList').html(data.data); 
                }
            })

        });


        $("#projectAssignModal").on('submit','#projectForm', function(event){
            event.preventDefault();
            //$('#save').attr('disabled','disabled'); 
            var formData = $(this).serializeArray();
            formData.push({name: "_token", value: "{{ csrf_token() }}"});
            showLoader();
            $.ajax({
                url:'{{url("/")}}/expense-type-list',
                method:"POST",
                data:formData,
                success:function(data){             
                    if(data){
                        $('#projectForm')[0].reset();
                        $('#projectAssignModal').modal('hide');                
                        //$('#save').attr('disabled', false); 
                        hideLoader();
                    }
                }, 
            })
        });  

        $('#addRecord').click(function(){
            $('#recordModal').modal('show');
        /*$('#recordModal').on('show', function () {
            $(".select_2").select2();
        });*/
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Expense Type");
        $('#action').val('addRecord');
        $('#save').val('Add');
    }); 

        $("#recordModal").on('submit','#recordForm', function(event){
            event.preventDefault();
            $('#save').attr('disabled','disabled'); 

            var formData = $(this).serializeArray();
            formData.push({name: "_token", value: "{{ csrf_token() }}"});
            $.ajax({
                url:'{{url("/")}}/expense-type-list',
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

            })
        });     

        $("#recordListing").on('click', '.update', function(){
            var id = $(this).attr("id");
            var action = 'getRecord';
            $.ajax({
                url:'{{url("/")}}/expense-type-list',
                method:"POST",
                data:{id:id, action:action,"_token": "{{ csrf_token() }}"},
                dataType:"json",
                success:function(data){
                    $('#recordModal').modal('show');
                    $('#expense_type_id').val(data.expense_type_id);
                    $('#name').val(data.name);
                    $('#company_id').val(data.company_id).change();
                    $('#account_debit').val(data.account_debit_id).change();
                    $('#account_credit').val(data.account_credit_id).change();
                    $('#cost_centre_id').val(data.cost_centre_id).change(); 
                    $('#all_projects').val(data.all_projects);  
                    $('#qty').val(data.qty);  
                    $('.delete').attr('id',data.expense_type_id);

                    $('.checkSta').val(data.status);    
                    if(data.status==1){ 
                        $('.checkSta').prop('checked',true);    
                    }else{
                        $('.checkSta').prop('checked',false);    
                    }
                    $('.modal-title').html("<i class='fa fa-plus'></i> Edit Expense Type");
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
                    url:'{{url("/")}}/expense-type-list',
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


