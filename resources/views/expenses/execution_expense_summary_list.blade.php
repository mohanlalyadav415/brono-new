@extends('layouts.master')
@section('title') Expenses List @endsection
@section('content')
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
				<div class="row"> 
					<div class="col-md-2">
						<select class="form-control form-select company_id_ajax company_id" name="company_id" required="">
							<option value="">Company</option>
							@if(isset($companyList))
							@foreach( $companyList as $value )
							<option value="{{ $value->company_id }}">{{ $value->name }}</option>
							@endforeach
							@endif
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
						<button id="filterBtn" class="btn btn-primary"><i class="ri-search-line"></i> View</button>
					</div>
					<div class="col-md-2">
						<button id="sendAllEmailBtn" class="btn btn-primary ri-send-plane-fill"> Send summary to</button>
					</div>

				</div><br><br><br><br> 


				<table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" id="recordListing">

					<thead>
						<tr> 
							<th>Expense execution resource id</th>
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
				$('.project_id').html(data.data); 
				$('.supplier_id').html(data.dataSupplier); 
			}
		});
	});

	$('#filterBtn').click(function() {
		var supplier_id = $('.supplier_id').val(); 
		if(supplier_id==""){
			alert('Please select supplier'); return false;
		}
		var company_id = $('.company_id').val(); 
		var fromDate = $('.fromDate').val(); 
		var toDate = $('.toDate').val(); 
		$.ajax({ 
			url:'{{url("/")}}/execution-expense-summary-list',
			type: 'POST',
			data:{supplier_id:supplier_id,company_id:company_id,fromDate:fromDate,toDate:toDate,"_token": "{{ csrf_token() }}"},
			success: function(data) {  
				$('#recordListing >tbody').html(data.data); 
			}
		});
		setTimeout(function () {
			var sum = 0;
			$('#recordListing tbody tr').each(function() {
				var value = parseInt($(this).find('td:nth-child(9)').text());
				if (!isNaN(value)) {
					sum += value;
				}
			});        
			$('#sumUnits').html('Total : '+sum+'.00');
		},1000)
		
	});


	$(document).ready(function(){ 
		$('#recordListing').on('click', '.removeRowBtn', function(){ 
			$(this).closest('tr').remove();
		});
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

 

$(document).ready(function(){
    $('#sendAllEmailBtn').on('click', function(){
        var allRowData = []; 
        var sum = 0; // Initialize sum variable
        $('#recordListing tbody tr').each(function() {
            var rowData = [];
            // Iterate through each cell of the row
            $(this).find('td').each(function(index) {
                var cellText = $(this).text();
                // Add cell data to rowData array
                rowData.push(cellText);
                // If it's the ninth column (index 8), add its value to the sum
                if (index === 8) {
                    var price = parseFloat(cellText); // Convert text to number
                    sum += isNaN(price) ? 0 : price; // Add to sum if it's a valid number
                }
            });
            allRowData.push(rowData); 
        }); 

        var supplier_id = $('.supplier_id').val(); 
		var company_id = $('.company_id').val(); 
		var fromDate = $('.fromDate').val(); 
		var toDate = $('.toDate').val(); 

        $.ajax({
            url: '/execution-expense-summary-list-send-mail',
            type: 'POST',
            data: { allRowData: allRowData,sum:sum,supplier_id:supplier_id,company_id:company_id,fromDate:fromDate,toDate:toDate,"_token": "{{ csrf_token() }}" }, 
            success: function(response) { 
            	if(response == 1){
            		window.location.reload();
            	}
                
            },
            error: function(xhr, status, error) { 
                console.error(error);
            }
        });
    });
});


 

</script> 
@endsection