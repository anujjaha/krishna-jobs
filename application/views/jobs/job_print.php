<style>
	td {
		font-size: 12px;
	}
</style>
<button onclick="print_job()" class="btn btn-success btn-flat">PRINT NOW</button>
<div id="jobPrint" style="height:8.3in; width:11in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<?php
		$compName = $jobInfo['company_name'] ? $jobInfo['company_name'] : $jobInfo['name'];
		$html = '<table align="center" width="90%" border="0" style="border:0px solid;font-size:9px;height:3in;">
		<td width="50%">
				<h5>Job Number: '. $jobInfo['job_id'] .'</h5>
			</td>
			<td>
				Date : 
				'. $jobInfo['created_at'] .'
			</td>
		</tr>
		<tr id="regular">
			<td width="50%">
				<h5>Party Name: '. $compName .'</h5>
			</td>
			<td>
				<h5>Mobile : '. $jobInfo['mobile'] .'</h5>
			</td>
		</tr>
		<tr>
		<td colspan="2">
			Address : ' . $jobInfo['address'] . '
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%" class="table">
				<tr>
					<td colspan="2" align="right">
						Job Name :
					</td>
					<td colspan="2">
					'. $jobInfo['job_name']. '
					</td>
				</tr>
				<tr>
					<th> Sr </th>
					<th> Category </th>
					<th> Details </th>
					<th> Qty </th>
					<th> Rate </th>
					<th> Sub Total </th>
				</tr>';
				
				for($i=1; $i<= count($jobDetails); $i++)
				{
					$j = $i - 1;
					
					$categoryValue = $detailsValue = $qtyValue = "";
					$rateValue = $subtotalValue = "";
					
					if(isset($jobDetails[$j]['category']) && !empty($jobDetails[$j]['category']))
					{
						$categoryValue 	= $jobDetails[$j]['category'];
						$detailsValue 	= $jobDetails[$j]['details'];
						$qtyValue 		= $jobDetails[$j]['qty'];
						$rateValue 		= $jobDetails[$j]['rate'];
						$subtotalValue 	= $jobDetails[$j]['sub_total'];
					}
				$html .= '<tr>
							<td> ' .$i. ' </td>
							<td> ' .$categoryValue . '</td>
							<td> '. $detailsValue . ' </td>
							<td> '. $qtyValue . ' </td>
							<td> '. $rateValue .' </td>
							<td> '. $subtotalValue.' </td>
						</tr>';
				} 
				$html .= '<tr>
							<td colspan="5" align="right">
								Sub Total :
							</td>
							<td>'. $jobInfo['job_total']. '
					</td>
				</tr>
				
				<tr>
					<td colspan="5" align="right">
						Advance :
					</td>
					<td>
						<strong> '. $jobInfo['job_advance']. ' </strong>
					</td>
				</tr>
				
				<tr>
					<td colspan="4">
						Payment Terms'. $jobInfo['job_payment_term']. '
					</td>
					<td align="right">
						Due :
					</td>
					<td>
						<strong>'. $jobInfo['job_due']. '</strong>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>';

		echo $html;
		echo $html;
		?>
	</div>

<script>

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
function print_job() {
	printDiv('jobPrint');
}
</script>