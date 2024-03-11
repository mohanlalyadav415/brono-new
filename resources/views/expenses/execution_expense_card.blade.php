@extends('layouts.master')
@section('title') Execution Expense Card @endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">EXECUTION EXPENSE CARD</h4> 
            </div>

            <div class="card-body">
                @if(session('success_msg')) 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>{{session('success_msg')}}.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(session('error_msg')) 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b>{{session('error_msg')}}.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif  
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="{{url('execution-expenses-card')}}" enctype="multipart/form-data" novalidate id="myForm">
                        @csrf
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative"></div>
                        <div class="col-md-3 position-relative"><button class="btn btn-primary" type="submit" id="submitBtn"><i class="ri-save-line"></i> Save</button></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="ID" class="form-label">ID</label>
                            <input type="text" class="form-control" id="ID" value="{{$newInsertID}}" required="" disabled=""> 
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="company_id" class="form-label">Company <span style="color: red">*</span></label>
                            <select class="form-control form-select company_id_ajax" id="company_id" name="company_id" required="">
                                <option value="">Company</option>
                                @if(isset($companyList))
                                @foreach( $companyList as $value )
                                <option value="{{ $value->company_id }}">{{ $value->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span style="color: red;">@if($errors->has('company_id'))
                                {{ $errors->first('company_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="project_id" class="form-label">Project <span style="color: red">*</span></label>
                            <select name="project_id" id="project_id" class="form-control form-select" required="">
                                <option value="">Project</option>
                            </select>

                            <span style="color: red;">@if($errors->has('project_id'))
                                {{ $errors->first('project_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="supplier_id" class="form-label">Supplier<span style="color: red">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control form-select supplier_id_ajax" required="">
                                <option value="">Supplier</option>
                            </select>

                            <span style="color: red;">@if($errors->has('supplier_id'))
                                {{ $errors->first('supplier_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="purchase_order_code" class="form-label">Purchase order code <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="purchase_order_code" id="purchase_order_code" value="{{ old('purchase_order_code') }}" placeholder="Purchase order code" required=""> 
                            <span style="color: red;">@if($errors->has('purchase_order_code'))
                                {{ $errors->first('purchase_order_code')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="document" class="form-label">Document <span style="color: red">*</span></label>
                            <input type="file" class="form-control" name="document" id="document" value="{{ old('document') }}" required=""> 
                            <span style="color: red;">@if($errors->has('document'))
                                {{ $errors->first('document')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="date" class="form-label">Date <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required=""> 
                            <span style="color: red;">@if($errors->has('date'))
                                {{ $errors->first('date')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="dte_type_id" class="form-label">DTE type <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="dte_type_id" name="dte_type_id" required="">
                                <option value="">DTE type</option>
                                @if(isset($dteTypeList))
                                @foreach( $dteTypeList as $value )
                                <option value="{{ $value->dte_type_id }}">{{ $value->dte_type_id.' '.$value->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span style="color: red;">@if($errors->has('dte_type_id'))
                                {{ $errors->first('dte_type_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="payment_status_id" class="form-label">Payment Status <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="payment_status_id" name="payment_status_id" required="">
                                <option value="">Payment Status</option>
                                @if(isset($paymentStatus))
                                @foreach( $paymentStatus as $value )
                                <option value="{{ $value->payment_status_id }}">{{ $value->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span style="color: red;">@if($errors->has('payment_status_id'))
                                {{ $errors->first('payment_status_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative form-check form-switch form-switch-lg">
                            <label class="form-check-label" for="customSwitchsizelg">Execution Expense Status</label>
                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" checked="">
                        </div> 
                        <div class="col-md-3 position-relative"></div>
                        <br>

                        <div class="col-md-12 position-relative">
                            <h4>SELECTED EXECUTION</h4>
                            <table id="firstTable" class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Resource</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Qty</th>
                                        <th>Value per unit</th>
                                        <th>Total</th>
                                        <th>Expense type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <h5 id="sumUnits" style="text-align: end;margin-right: 335px"></h5>

                            <h4>EXECUTION NOT SELECTED IN ANY EXPENSE</h4>
                            
                        </div> 
                        <br><br>
 
                    </form>
                    <table id="secondTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Resource</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Qty</th>
                                        <th>Value per unit</th>
                                        <th>Total</th>
                                        <th>Expense type</th>
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


@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script type="text/javascript">
    $('.company_id_ajax').change(function() {
        var company_id = $(this).val(); 
        $.ajax({ 
            url:'{{url("/")}}/company-by-project',
            type: 'POST',
            data:{company_id:company_id,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#project_id').html(data.data); 
                $('#supplier_id').html(data.dataSupplier); 
                $('#expense_type_id').html(data.dataExpenseType); 
            }
        });
    });

    $('#amount, #qty').on('change click',function(){
        var amount = $('#amount').val();
        var qty = $('#qty').val();
        var totalQty = amount*qty;
        $('.totalQty').html('<b style="position: relative;top: 30px;font-size: 20px;">Total : '+totalQty+'.00</b>');
    })
    
</script>
<script>

    $('#company_id,#project_id,#supplier_id').change(function() { 
        var company_id = $('#company_id').val(); 
        var project_id = $('#project_id').val(); 
        var supplier_id = $('#supplier_id').val(); 

        $.ajax({ 
            url:'{{url("/")}}/execution-resource-by-supplier',
            type: 'POST',
            data:{supplier_id:supplier_id,project_id:project_id,company_id:company_id,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#secondTable >tbody').html(data.data); 
            }
        });
    });

    $(document).ready(function() { 
        $('#secondTable').on('click', '.moveToFirst', function() {
            var $row = $(this).closest('tr');
            $('#firstTable tbody').append($row);
            $(this).text("X Remove").removeClass("moveToFirst").addClass("moveToSecond btn-danger");
            $row.find('input[name="first_table_movement[]"]').val('1');
            updateSum();
        });

        $('#firstTable').on('click', '.moveToSecond', function() {
            var $row = $(this).closest('tr');
            $('#secondTable tbody').append($row);
            $(this).text("+ Add").removeClass("moveToSecond").addClass("moveToFirst btn-success");
            $(this).text("+ Add").removeClass("btn-danger");
            updateSum();
        });
    }); 

    function updateSum() {
        var sum = 0;
        $('#firstTable tbody tr').each(function() {
            var value = parseInt($(this).find('td:nth-child(9)').text());
            if (!isNaN(value)) {
                sum += value;
            }
        });        
        $('#sumUnits').html('Total : '+sum+'.00');
    }

    $(document).ready(function(){
        $("form").submit(function(event){ 
            if ($("#firstTable tbody tr").length === 0) {
                alert("Please add at least one SELECTED EXECUTION to the table before submitting.");
                event.preventDefault();
            }
        });
    });
</script>
@endsection


