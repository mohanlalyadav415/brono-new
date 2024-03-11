
<div style="margin: 80px;">
	<p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>
	<h4 style="text-align: center;">EXECUTION EXPENSE</h4>
	<p>id : <?php echo $expense->expense_id; ?></p>
	<p>Company : <?php echo $expense->company_name; ?></p>
	<p>Supplier : <?php echo $expense->supplier_name; ?></p>
	<p>Purchase order code : <?php echo $expense->purchase_order_code; ?></p>
	<p>Date : <?php echo $expense->date; ?></p>
	<p>DTE type : <?php echo $expense->dte_type; ?></p>
	<p>Payment status : <?php echo $expense->payment_status; ?></p>
	<table width="100%" class="table" id="recordListing">
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
			</tr>
			<thead>
			<tbody>
			<?php 
			if (isset($datalist) && !empty($datalist)) {
				foreach ($datalist as $key => $value) { 
					?>
					<tr>
						<td><?php echo $value->execution_resource_id; ?></td>
						<td><?php echo $value->project; ?></td>
						<td><?php echo $value->resource; ?></td>
						<td><?php echo $value->service; ?></td>
						<td><?php echo $value->date; ?></td>
						<td><?php echo $value->TIME; ?></td>
						<td><?php echo $value->qty; ?></td>
						<td><?php echo $value->cost_per_unit; ?></td>
						<td><?php echo $value->total; ?></td>
						<td><?php echo $value->expense_type_id.' - '.$value->expense_type; ?></td>
					</tr>
				<?php } 
			} ?> 
		</tbody>
	</table>
	<!-- <h5 id="sumUnits"></h5> -->
</div>

<!-- <script type="text/javascript">
	var sum = 0;
	$('#recordListing tbody tr').each(function() {
		var value = parseInt($(this).find('td:nth-child(9)').text());
		console.log(value)
		if (!isNaN(value)) {
			sum += value;
		}
	});        
	$('#sumUnits').html('Total : '+sum+'.00');
</script> -->
<?php 
//print_r($expense);
?>