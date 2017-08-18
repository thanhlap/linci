<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_info extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insert($data) {
		// Inserting into your table
		$this->db->insert('order_info', $data);
		// Return the id of inserted row
		return $idOfInsertedData = $this->db->insert_id();
	}
	
	public function getLastOrderInfoByUserID($source_user_id){
		$this->db->select("*");
		$this->db->where("source_user_id", $source_user_id);
		$this->db->order_by("id desc");
		$this->db->limit(1);
		$query=$this->db->get("order_info");
		$result = $query->result_array();
		if ($result && (count($result) > 0))
			return $result[0];
			else
				return null;
	}

	public function update($data){
		$this->db->where("id", $data["id"]);
		$this->db->update("order_info", $data);
	}
	
}