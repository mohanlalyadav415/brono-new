
<?php $__env->startSection('title'); ?> Expenses List <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
	.dataTables_filter, .dataTables_info { display: none; }
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title text-center mb-0">EXPENSES LIST</h5>
			</div>
			<div class="card-body">
				<?php if(session('success_msg')): ?> 
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<b><?php echo e(session('success_msg')); ?>.</b> 
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php elseif(session('error_msg')): ?> 
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<b><?php echo e(session('error_msg')); ?>.</b> 
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php endif; ?>  

				<div class="row"> 
					<div class="col-md-2">
						<select class="form-control form-select company_id_ajax company_id" name="company_id" required="">
							<option value="">Company</option>
							<?php if(isset($companyList)): ?>
							<?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($value->company_id); ?>"><?php echo e($value->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="col-md-2">
						<select class="project_id form-control form-select">
							<option value="">Select Project</option> 
						</select>
					</div>
					<div class="col-md-2">
						<select class="supplier_id form-control form-select">
							<option value="">Select Supplier</option> 
						</select>
					</div>
					<div class="col-md-2">
						<input type="date" name="fromDate" class="fromDate form-control">
					</div>
					<div class="col-md-2">
						<input type="date" name="toDate" class="toDate form-control">
					</div>
					<div class="col-md-2">
						<button id="filterBtn" class="btn btn-primary"><i class="ri-filter-2-fill"></i> Filter</button>
					</div>
						 
				</div><br><br><br><br>

				<div class="row"> 
					<div class="col-md-5"></div>
					<div class="col-md-7">
						

						<a class="float-right btn btn-xs btn-primary float-right btn-flat"
						href="<?php echo e(route('normal.expense.card')); ?>"><i class="ri-add-box-line"></i> New normal expense</a>

						<a class="float-right btn btn-xs btn-primary float-right btn-flat"
						href="<?php echo e(route('execution.expenses.card')); ?>"><i class="ri-add-box-line"></i> New execution expense</a>

						<a class="float-right btn btn-xs btn-primary float-right btn-flat accountExportBtn"
						href="<?php echo e(route('export.execution.expenses')); ?>">
						<i class="ri-export-fill"></i> Export</a>

						<a class="float-right btn btn-xs btn-primary float-right btn-flat softland"
						href="<?php echo e(route('export.softland')); ?>">
						<i class="ri-export-fill"></i> Export Softland</a>
					</div>
				</div> <br>  


				<table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

					<thead>
						<tr> 
							<th>ID</th>                    
							<th>Project</th>                   
							<th>RUT Supplier</th>                   
							<th>Supplier</th>                   
							<th>Source</th>                   
							<th>Expense type</th>                   
							<th>Date</th>            
							<th>Amount</th>            
							<th>Qty</th>            
							<th>Total</th>            
							<th>DTE type</th>            
							<th>Payment status</th>
							<th>Send to supplier </th>
							<th>Action</th>              
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
				<!-- <h5 id="sumUnits" style="text-align: end;margin-right: 420px"></h5> -->
				<div class="row">
					<div class="col-md-7"></div>
					<div class="col-md-5">
						<h5 id="sumUnits"></h5>
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
			url:'<?php echo e(url("/")); ?>/expenseslist', 
			dataType:"json",
			type:"POST",
			data: function (d) {
				d.action = 'listRecords';
				d._token = '<?php echo e(csrf_token()); ?>';   
				d.company_id = $('.company_id').val();  
				d.project_id = $('.project_id').val();  
				d.supplier_id = $('.supplier_id').val();  
				d.fromDate = $('.fromDate').val();  
				d.toDate = $('.toDate').val();  
			}
		},
		columnDefs: [
		{"className": "dt-center", "targets": "_all"}
		],
		columns: [ 
		{data: 'expense_id', name: 'expense_id'},
		{data: 'project', name: 'project'},
		{data: 'rut', name: 'rut'},
		{data: 'supplier_name', name: 'supplier_name'},
		{data: 'source', name: 'source'},
		{data: 'expense_type', name: 'expense_type'}, 
		{data: 'date', name: 'date'}, 
		{data: 'amount', name: 'amount'}, 
		{ 
			"data": "qty", 
			"name": "qty",  
			"createdCell": function (td, cellData, rowData, row, col) { 
				if (cellData === null || cellData === "") {
					$(td).text(rowData.qtys);
				}
			}
		},
		{ 
			"data": "totalAmt", 
			"name": "totalAmt",  
			"createdCell": function (td, cellData, rowData, row, col) { 
				if (cellData === null || cellData === "") {
					$(td).text(rowData.total);
				}
			}
		}, 
		{data: 'dte_type', name: 'dte_type'}, 
		{data: 'payment_status', name: 'payment_status'}, 

		{ 
			"data": "sent_mail_check", 
			"name": "sent_mail_check",  
			"createdCell": function (td, cellData, rowData, row, col) { 
				if (cellData === 1) {
					$(td).html('<i class="ri-checkbox-fill" style="color: green;font-size: x-large;"></i>');
				}else{
					$(td).text('');
				}
			}
		},
 

		{data: 'action', name: 'action', orderable: false, searchable: false},
		] 
	});   

	$('.company_id_ajax').change(function() {
		var company_id = $(this).val(); 
		$.ajax({ 
			url:'<?php echo e(url("/")); ?>/company-by-project',
			type: 'POST',
			data:{company_id:company_id,"_token": "<?php echo e(csrf_token()); ?>"},
			success: function(data) {  
				$('.project_id').html(data.data); 
				$('.supplier_id').html(data.dataSupplier); 
			}
		});
	});

	setTimeout(function () {
		var sum = 0;
		$('#recordListing tbody tr').each(function() {
			var value = parseInt($(this).find('td:nth-child(10)').text());
			console.log(value)
			if (!isNaN(value)) {
				sum += value;
			}
		});        
		$('#sumUnits').html('Total : '+sum+'.00');
	},1000)

	$('#filterBtn').click(function() {
		setTimeout(function () {
        var sum = 0;
        $('#recordListing tbody tr').each(function() {
            var value = parseInt($(this).find('td:nth-child(10)').text());
            console.log(value)
            if (!isNaN(value)) {
                sum += value;
            }
        });        
        $('#sumUnits').html('Total : '+sum+'.00');
    },1000);
		var company_id = $('.company_id').val();
        var project_id = $('.project_id').val();
        var supplier_id = $('.supplier_id').val();
        var fromDate = $('.fromDate').val();
        var toDate = $('.toDate').val();

        

        var url = '<?php echo url('/'); ?>/export-execution-expenses?company_id=' + company_id + '&project_id=' + project_id +'&supplier_id=' + supplier_id +'&fromDate=' + fromDate +'&toDate=' + toDate;
        $('.accountExportBtn').attr('href', url);

        var urls = '<?php echo url('/'); ?>/export-softland?company_id=' + company_id + '&project_id=' + project_id +'&supplier_id=' + supplier_id +'&fromDate=' + fromDate +'&toDate=' + toDate;
        $('.softland').attr('href', urls);

		table.ajax.reload();
	});

$(document).ready(function() { 
    var today = new Date(); 
    var toDate = new Date(today);
    toDate.setDate(toDate.getDate() - 30); 
    var formattedToDate = toDate.toISOString().split('T')[0]; 
    var formattedFromDate = today.toISOString().split('T')[0]; 

    $('.fromDate').val(formattedToDate);
    $('.toDate').val(formattedFromDate);
});


</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/expenses/expenseslist.blade.php ENDPATH**/ ?>