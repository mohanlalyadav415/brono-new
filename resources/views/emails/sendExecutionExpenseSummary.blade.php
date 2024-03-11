
<div style="margin: 80px;">
	<h4 style="text-align: center;">EXECUTION EXPENSE SUMMARY</h4>
 <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>

	<p>Company : <?php echo $company; ?></p>
	<p>Supplier : <?php echo $supplier; ?></p>
	<p>Period : <?php echo $fromDate.' to '.$toDate; ?></p>
	
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
						<td><?php echo $value[0]; ?></td>
						<td><?php echo $value[1]; ?></td>
						<td><?php echo $value[2]; ?></td>
						<td><?php echo $value[3]; ?></td>
						<td><?php echo $value[4]; ?></td>
						<td><?php echo $value[5]; ?></td>
						<td><?php echo $value[6]; ?></td>
						<td><?php echo $value[7]; ?></td>
						<td><?php echo $value[8]; ?></td>
						<td><?php echo $value[9]; ?></td>
					</tr>
				<?php  } 
			} ?> 
		</tbody>
	</table>
	<h5 style="text-align: right;margin-right: 200px;">Total : <?php echo $total;?>.00</h5><br><br>
	 <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.</p>
</div>
<?php 
//print_r($datalist); die;
?>
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
