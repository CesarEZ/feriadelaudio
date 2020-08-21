<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox_Model extends CI_Model{

	//----------------------------------------------------------------------
	// Post new Job
	public function get_all_messages()
	{
		$this->db->select('*');
		$this->db->where('sender',$this->session->employer_id);
		$this->db->or_where('receiver',$this->session->employer_id);
		return $this->db->get('xx_employer_chat')->result_array();
	}

	//----------------------------------------------------------------------
	// 
	public function add_message($data)
	{
		$this->db->insert('xx_employer_chat',$data);
		return true;
	}


}//end class

?>