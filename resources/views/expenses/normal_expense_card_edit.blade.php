@extends('layouts.master')
@section('title') Normal Expense Card Edit @endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">NORMAL EXPENSE CARD EDIT</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="{{url('normal-expense-card-edit')}}/{{$normalExpenseList->expense_id}}" enctype="multipart/form-data" novalidate>
                        @csrf 
                        <input type="hidden" name="expense_normal_id" value="{{$normalExpenseList->expense_normal_id}}">
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
                            <label for="expense_type_id" class="form-label">Expense Type<span style="color: red">*</span></label>
                            <select name="expense_type_id" id="expense_type_id" class="form-control form-select" required="">
                                <option value="">Expense Type</option>
                            </select>

                            <span style="color: red;">@if($errors->has('expense_type_id'))
                                {{ $errors->first('expense_type_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="date" class="form-label">Date <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo $normalExpenseList->date; ?>" required=""> 
                            <span style="color: red;">@if($errors->has('date'))
                                {{ $errors->first('date')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="amount" class="form-label">Amount <span style="color: red">*</span></label>
                            <input type="number" class="form-control" name="amount" id="amount" value="<?php echo $normalExpenseList->amount; ?>" placeholder="Amount" min="1" required=""> 
                            <span style="color: red;">@if($errors->has('amount'))
                                {{ $errors->first('amount')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="qty" class="form-label">Qty <span style="color: red">*</span></label>
                            <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $normalExpenseList->qty; ?>" placeholder="Qty" min="1" required=""> 
                            <span style="color: red;">@if($errors->has('qty'))
                                {{ $errors->first('qty')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative totalQty"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="purchase_order_code" class="form-label">Purchase order <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="purchase_order_code" id="purchase_order_code" value="<?php echo $normalExpenseList->purchase_order_code; ?>" placeholder="Purchase order" required=""> 
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
                                <option value="{{ $value->expense_source_id }}" {{($value->expense_source_id == $normalExpenseList->source_id ? "selected" : "")}}>{{ $value->name }}</option>
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
                                <option value="{{ $value->dte_type_id }}" {{($value->dte_type_id == $normalExpenseList->dte_type_id ? "selected" : "")}}>{{ $value->dte_type_id.' '.$value->name }}</option>
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
                                <option value="{{ $value->payment_status_id }}" {{($value->payment_status_id == $normalExpenseList->payment_status_id ? "selected" : "")}}>{{ $value->name }}</option>
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
                            <label class="form-check-label" for="customSwitchsizelg">Status</label>
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

    <?php 
    if(isset($normalExpenseList->company_id) && !empty($normalExpenseList->company_id)){ ?>
        $.ajax({ 
            url:'{{url("/")}}/company-by-project',
            type: 'POST',
            data:{company_id:<?php echo $normalExpenseList->company_id; ?>,"_token": "{{ csrf_token() }}"},
            success: function(data) {  
                $('#project_id').html(data.data); 
                $('#supplier_id').html(data.dataSupplier); 
                $('#expense_type_id').html(data.dataExpenseType); 
            }
        });

        $('#company_id').val(<?php echo $normalExpenseList->company_id; ?>).change();
     setTimeout(function () {
        $('#project_id').val(<?php echo $normalExpenseList->project_id; ?>).change();
        $('#supplier_id').val(<?php echo $normalExpenseList->supplier_id; ?>).change();
        $('#expense_type_id').val(<?php echo $normalExpenseList->expense_type_id; ?>).change(); 
        },1000)

        

    <?php } ?>
    
    <?php 
    if(isset($normalExpenseList->amount) && !empty($normalExpenseList->amount)){ ?>
        var amount = $('#amount').val();
        var qty = $('#qty').val();
        var totalQty = amount*qty;
        $('.totalQty').html('<b style="position: relative;top: 30px;font-size: 20px;">Total : '+totalQty+'.00</b>');
    <?php } ?>

    $('#amount, #qty').on('change click',function(){
        var amount = $('#amount').val();
        var qty = $('#qty').val();
        var totalQty = amount*qty;
        $('.totalQty').html('<b style="position: relative;top: 30px;font-size: 20px;">Total : '+totalQty+'.00</b>');
    })
    
</script>
@endsection


