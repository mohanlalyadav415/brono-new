
<?php $__env->startSection('title'); ?> Normal Expense Card Edit <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">NORMAL EXPENSE CARD EDIT</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="<?php echo e(url('normal-expense-card-edit')); ?>/<?php echo e($normalExpenseList->expense_id); ?>" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?> 
                        <input type="hidden" name="expense_normal_id" value="<?php echo e($normalExpenseList->expense_normal_id); ?>">
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="company_id" class="form-label">Company <span style="color: red">*</span></label>
                            <select class="form-control form-select company_id_ajax" id="company_id" name="company_id" required="">
                                <option value="">Company</option>
                                <?php if(isset($companyList)): ?>
                                <?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->company_id); ?>"><?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('company_id')): ?>
                                <?php echo e($errors->first('company_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="project_id" class="form-label">Project <span style="color: red">*</span></label>
                            <select name="project_id" id="project_id" class="form-control form-select" required="">
                                <option value="">Project</option>
                            </select>

                            <span style="color: red;"><?php if($errors->has('project_id')): ?>
                                <?php echo e($errors->first('project_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="supplier_id" class="form-label">Supplier<span style="color: red">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control form-select" required="">
                                <option value="">Supplier</option>
                            </select>

                            <span style="color: red;"><?php if($errors->has('supplier_id')): ?>
                                <?php echo e($errors->first('supplier_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>
                        
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="expense_type_id" class="form-label">Expense Type<span style="color: red">*</span></label>
                            <select name="expense_type_id" id="expense_type_id" class="form-control form-select" required="">
                                <option value="">Expense Type</option>
                            </select>

                            <span style="color: red;"><?php if($errors->has('expense_type_id')): ?>
                                <?php echo e($errors->first('expense_type_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="date" class="form-label">Date <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="date" id="date" value="<?php echo $normalExpenseList->date; ?>" required=""> 
                            <span style="color: red;"><?php if($errors->has('date')): ?>
                                <?php echo e($errors->first('date')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="amount" class="form-label">Amount <span style="color: red">*</span></label>
                            <input type="number" class="form-control" name="amount" id="amount" value="<?php echo $normalExpenseList->amount; ?>" placeholder="Amount" min="1" required=""> 
                            <span style="color: red;"><?php if($errors->has('amount')): ?>
                                <?php echo e($errors->first('amount')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="qty" class="form-label">Qty <span style="color: red">*</span></label>
                            <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $normalExpenseList->qty; ?>" placeholder="Qty" min="1" required=""> 
                            <span style="color: red;"><?php if($errors->has('qty')): ?>
                                <?php echo e($errors->first('qty')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative totalQty"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="purchase_order_code" class="form-label">Purchase order <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="purchase_order_code" id="purchase_order_code" value="<?php echo $normalExpenseList->purchase_order_code; ?>" placeholder="Purchase order" required=""> 
                            <span style="color: red;"><?php if($errors->has('purchase_order_code')): ?>
                                <?php echo e($errors->first('purchase_order_code')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="document" class="form-label">Document </label>
                            <input type="file" class="form-control" name="document" id="document" value="<?php echo e(old('document')); ?>">                          
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="source_id" class="form-label">Expense Source <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="source_id" name="source_id" required="">
                                <option value="">Expense Source</option>
                                <?php if(isset($expenseSourceList)): ?>
                                <?php $__currentLoopData = $expenseSourceList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->expense_source_id); ?>" <?php echo e(($value->expense_source_id == $normalExpenseList->source_id ? "selected" : "")); ?>><?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('source_id')): ?>
                                <?php echo e($errors->first('source_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="dte_type_id" class="form-label">DTE type <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="dte_type_id" name="dte_type_id" required="">
                                <option value="">DTE type</option>
                                <?php if(isset($dteTypeList)): ?>
                                <?php $__currentLoopData = $dteTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->dte_type_id); ?>" <?php echo e(($value->dte_type_id == $normalExpenseList->dte_type_id ? "selected" : "")); ?>><?php echo e($value->dte_type_id.' '.$value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('dte_type_id')): ?>
                                <?php echo e($errors->first('dte_type_id')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="payment_status_id" class="form-label">Payment Status <span style="color: red">*</span></label>
                            <select class="form-control form-select" id="payment_status_id" name="payment_status_id" required="">
                                <option value="">Payment Status</option>
                                <?php if(isset($paymentStatus)): ?>
                                <?php $__currentLoopData = $paymentStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->payment_status_id); ?>" <?php echo e(($value->payment_status_id == $normalExpenseList->payment_status_id ? "selected" : "")); ?>><?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span style="color: red;"><?php if($errors->has('payment_status_id')): ?>
                                <?php echo e($errors->first('payment_status_id')); ?> 
                                <?php endif; ?>
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


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script type="text/javascript">
    $('.company_id_ajax').change(function() {
        var company_id = $(this).val(); 
        $.ajax({ 
            url:'<?php echo e(url("/")); ?>/company-by-project',
            type: 'POST',
            data:{company_id:company_id,"_token": "<?php echo e(csrf_token()); ?>"},
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
            url:'<?php echo e(url("/")); ?>/company-by-project',
            type: 'POST',
            data:{company_id:<?php echo $normalExpenseList->company_id; ?>,"_token": "<?php echo e(csrf_token()); ?>"},
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/expenses/normal_expense_card_edit.blade.php ENDPATH**/ ?>