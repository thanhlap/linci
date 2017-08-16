<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_log extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insert($data) {
		// Inserting into your table
		$this->db->insert('chat_log', $data);
		// Return the id of inserted row
		return $idOfInsertedData = $this->db->insert_id();
	}
	
	public function getLastMsgByUserID($source_user_id){
		$this->db->select("*");
		$this->db->where("source_user_id", $source_user_id);
		$this->db->order_by("id desc");
		$this->db->limit(1);
		$query=$this->db->get("chat_log");
		$result = $query->result_array();
		if ($result && (count($result) > 0))
			return $result[0];
		else
			return null;
	}
	
}