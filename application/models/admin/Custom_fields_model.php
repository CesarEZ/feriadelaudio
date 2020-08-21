<?php
class Custom_fields_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*-----------------------------//
	//	CUSTOM FIELDS		      //
	//---------------------------*/

	//-----------------------------------------------------
	public function get_all_fields(){
		$this->db->order_by('name');
		$query = $this->db->get('ci_fields');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function add_field($data){
		$result = $this->db->insert('ci_fields', $data);
        return $this->db->insert_id();	
	}

	//-----------------------------------------------------
	public function edit_field($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_fields', $data);
		return true;
	}

	//-----------------------------------------------------
	public function delete_field_options($id = 0)
	{
		$this->db->delete('ci_field_options',array('parent_field' => $id));
		return true;
	}

	//-----------------------------------------------------
	public function get_field_by_id($id = 0)
	{
		$query = $this->db->get_where('ci_fields',array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_custom_field_by_id($id){
		$query = $this->db->get_where('ci_fields', array('id' => $id));
		return $result = $query->row_array();
	}


	/*-----------------------------//
	//	FIELD OPTIONS		      //
	//---------------------------*/

	public function add_field_options($data){
		$result = $this->db->insert('ci_field_options', $data);
        return $this->db->insert_id();
	}

	function add_field_to_category($data)
	{
		$result = $this->db->insert('ci_fields_to_category', $data);
        return $this->db->insert_id();
	}
	
}
?>