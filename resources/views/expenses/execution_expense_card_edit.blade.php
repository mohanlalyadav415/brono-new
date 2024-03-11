@extends('layouts.master')
@section('title') Execution Expense Card Edit @endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">EXECUTION EXPENSE CARD EDIT</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="{{url('execution-expense-card-edit')}}/{{$executionExpenseList->expense_id}}" enctype="multipart/form-data" novalidate>
                        @csrf 
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
                            <label for="supplier_id" class="form-label">Supplier <span style="color: red">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control form-select" required="">
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
                            <label for="date" class="form-label">Date <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo $executionExpenseList->date; ?>" required=""> 
                            <span style="color: red;">@if($errors->has('date'))
                                {{ $errors->first('date')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="purchase_order_code" class="form-label">Purchase order code  <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="purchase_order_code" id="purchase_order_code" value="<?php echo $executionExpenseList->purchase_order_code; ?>" placeholder="Purchase order code " required=""> 
                            <span style="color: red;">@if($errors->has('purchase_order_code'))
                                {{ $errors->first('purchase_order_code')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="document" class="form-label">Document </label>
                            <input type="file" class="form-control" name="document" id="document" value="{{ old('document') }}">                          
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="source_id" class="form-label">Expense Source <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="source_id" name="source_id" required="">
                                <option value="">Expense Source</option>
                                @if(isset($expenseSourceList))
                                @foreach( $expenseSourceList as $value )
                                <option value="{{ $value->expense_source_id }}" {{($value->expense_source_id == $executionExpenseList->source_id ? "selected" : "")}}>{{ $value->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span style="color: red;">@if($errors->has('source_id'))
                                {{ $errors->first('source_id')}} 
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
                                <option value="{{ $value->dte_type_id }}" {{($value->dte_type_id == $executionExpenseList->dte_type_id ? "selected" : "")}}>{{ $value->dte_type_id.' '.$value->name }}</option>
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
                                <option value="{{ $value->payment_status_id }}" {{($value->payment_status_id == $executionExpenseList->payment_status_id ? "selected" : "")}}>{{ $value->name }}</option>
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

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-5">
                            <a href="javascript:window.history.back()" class="btn btn-danger" ><i class="ri-close-line"></i> Cancel</a>
                        </div>
                        <div class="col-md-3 position-relative">
                            <button class="btn btn-primary" type="submit"><i class="ri-save-line"></i> Save</button>
                        </div> 
                    </form>
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
    $('#company_id').val(<?php echo $executionExpenseList->company_id; ?>).change();
    $('.company_id_ajax').change(function() {
        var company_id = $(this).val(); 
        $.ajax({ 
            url:'{{url("/")}}/company-by-project',
            type: 'POST',
            data:{company_id:company_id,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#project_id').html(data.data); 
                $('#supplier_id').html(data.dataSupplier); 
            }
        });
    });

    <?php 
    if(isset($executionExpenseList->company_id) && !empty($executionExpenseList->company_id)){ ?>
        $.ajax({ 
            url:'{{url("/")}}/company-by-project',
            type: 'POST',
            data:{company_id:<?php echo $executionExpenseList->company_id; ?>,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#project_id').html(data.data); 
                $('#supplier_id').html(data.dataSupplier); 
            }
        });
        setTimeout(function () {
            $('#supplier_id').val(<?php echo $executionExpenseList->supplier_id; ?>).change();
            $('#project_id').val(<?php echo $executionExpenseList->project_id; ?>).change();
        },1000);



    <?php } ?>
    
    <?php 
    /*if(isset($executionExpenseList->amount) && !empty($executionExpenseList->amount)){ ?>
        var amount = $('#amount').val();
        var qty = $('#qty').val();
        var totalQty = amount*qty;
        $('.totalQty').html('<b style="position: relative;top: 30px;font-size: 20px;">Total : '+totalQty+'.00</b>');
    <?php }*/ ?>

    /*$('#amount, #qty').on('change click',function(){
        var amount = $('#amount').val();
        var qty = $('#qty').val();
        var totalQty = amount*qty;
        $('.totalQty').html('<b style="position: relative;top: 30px;font-size: 20px;">Total : '+totalQty+'.00</b>');
    })*/
    
</script>
@endsection


