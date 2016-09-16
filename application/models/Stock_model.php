<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Version: 2.5.2
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Last Change: 3.22.13
*
* Changelog:
* * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Stock_model extends CI_Model
{
	public $table 				= "stock_manage";
	public $tablePrimarykey 	= "id";
	
	public function getAllStock()
	{
		$this->db->select('*,SUM( stock ) AS stock')
			->from($this->table)
			->order_by($this->tablePrimarykey)
			->group_by('title');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function create($data = array(), $dateTime = true)
	{
		if($dateTime)
		{
			$data['created_at'] = date('Y-m-d H:i:s');
		}

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function reduceStock($title, $qty)
	{
		$this->db->select('*')
				->from($this->table)
				->where('title', $title)
				->order_by('id', 'DESC');

		$query = $this->db->get();

		if($query->row())
		{
			$updateStock = array(
				'stock' => $query->row()->stock - $qty
			);

			$this->db->where('id', $query->row()->id);
			$this->db->update($this->table, $updateStock);

			return true;
		}
	}

	public function addStock($title, $qty)
	{
		$this->db->select('*')
				->from($this->table)
				->where('title', $title)
				->order_by('id', 'DESC');

		$query = $this->db->get();

		if($query->row())
		{
			$updateStock = array(
				'stock' => $query->row()->stock + $qty
			);

			$this->db->where('id', $query->row()->id);
			$this->db->update($this->table, $updateStock);

			return true;
		}
	}
}
