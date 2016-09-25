<?php

function getUserId()
{
	$ci = & get_instance();
	
	return $ci->ion_auth->user()->row()->id;
}
function get_users_groups() {
	$ci = & get_instance();
	$ci->db->select('*')
			->from('groups')
			->order_by('name');
	$query = $ci->db->get();
	return $query->result_array();
}

function pr($data, $status = true)
{
	if($status)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die;
	}
	
	echo "<pre>";
	print_r($data);
	echo "<pre>";
	
	return true;
}

function getPartiesDropdown()
{
	$ci = & get_instance();
	
	$ci->db->select('id,company_name,name')
		   ->from('customers')
		   ->order_by('company_name');
		   
	$query 	= $ci->db->get();
	
	$result = $query->result_array();
	
	$html 	= '<select name="customer_id" id="customer_id" class="form-control" onchange="getCustomerMobileNumber();">';
	$html  .= '<option value="0" selected>Select Customer</option>';
	foreach($result as $data)
	{
		$option = $data['company_name'] ? $data['company_name'] : $data['name'];
		
		$html .= '<option value="'.$data['id'].'"> '.$option.' </option>';
	}
	
	$html .= '</select>';
	
	return $html;
}

function addUserBalance($operation = 'add', $customerId = null, $balance = 0)
{
	if($customerId && $balance > 0)
	{
		$ci = & get_instance();
		$ci->db->select('balance')
				->from('customers')
				->where('id', $customerId);
		
		$query = $ci->db->get();
		
		if($operation == 'add')
		{
			$updateUserBalance 	= $query->row()->balance + $balance;
		}
		else
		{
			$updateUserBalance 	= $query->row()->balance - $balance;
		}
		
		$updateData 		= array('balance' => $updateUserBalance);
		
		$ci->db->where('id', $customerId);
		$ci->db->update('customers', $updateData);
		return true;
	}

	return true;
}


function getUserBalance($userId = null)
{
	if($userId)
	{
		$ci = & get_instance();
		$ci->db->select('balance')
					->from('customers')
					->where('id', $userId);
		$query = $ci->db->get();
		
		return $query->row()->balance;
	}
	
	return 0;
}

function getStockItemList($name = "title", $stockItem = null)
{
	$ci = & get_instance();
	$ci->db->select('*')
			   ->from('stock_manage')
			   ->order_by('id');

	$query = $ci->db->get();			 
	$result = $query->result_array();

	$html = "<select class='form-control' name='" . $name . "'>";
	foreach($result as $stock)
	{
		$selected = "";

		if(isset($stockItem) && $stockItem == $stock)
		{
			$selected = 'selected="selected"';
		}
		$html .= "<option ". $selected .">". $stock['title'] ."</option>";
	}

	$html .= "</select>";

	return $html;
}

function getJobStockItemList($name = "title", $stockItem = null)
{
	$ci = & get_instance();
	$ci->db->select('DISTINCT(title)')
			   ->from('stock_manage')
			   ->order_by('id');

	$query = $ci->db->get();			 
	$result = $query->result_array();

	$html = "<select class='form-control' name='" . $name . "' id='" . $name . "'>";
	foreach($result as $stock)
	{
		$selected = "";

		if(isset($stockItem) && $stockItem == $stock)
		{
			$selected = 'selected="selected"';
		}
		$html .= "<option ". $selected .">". $stock['title'] ."</option>";
	}

	$html .= "</select>";

	return $html;
}

function create_pdf($content=null,$size ='A5-L') {
	if($content) {
		$ci = & get_instance();

		$ci->load->library('Pdf');

		$mpdf = new mPDF('', $size,8,'',4,4,10,2,4,4);
		//$mpdf->SetHeader('CYBERA Print ART');
		$mpdf->defaultheaderfontsize=8;
		//$mpdf->SetFooter('{PAGENO}');
		$mpdf->WriteHTML($content);
		$mpdf->shrink_tables_to_fit=0;
		$mpdf->list_indent_first_level = 0;  
		$mpdf->keep_table_proportions = true;
		//$filename = "jobs/".rand(1111,9999)."_".rand(1111,9999)."_Job_Order.pdf";
		//$fname = "pdf_receipt/".rand(1111,9999)."_cybera.pdf";
		$fname = "pdf_receipt/krishna.pdf";
		$mpdf->Output($fname,'F');
		return base_url().$fname;
	}
}

function generate_pdf($html = null, $returnLink = true)
{

}

?>