<?php
class Category_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*-----------------------------//
	//	CATEGORY			      //
	//---------------------------*/

	//-----------------------------------------------------
	public function get_all_categories(){
		$this->db->order_by('name');
		$query = $this->db->get('ci_categories');
		return $result = $query->result_array();
	}
	//-----------------------------------------------------
	public function add_category($data){
		$result = $this->db->insert('ci_categories', $data);
        return $this->db->insert_id();	
	}
	//-----------------------------------------------------
	public function edit_category($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_categories', $data);
		return true;

	}
	//-----------------------------------------------------
	public function get_category_by_id($id){
		$query = $this->db->get_where('ci_categories', array('id' => $id));
		return $result = $query->row_array();
	}


	/*-----------------------------//
	//	SUBCATEGORY			      //
	//---------------------------*/

	public function get_all_subcategories($id){
		$this->db->order_by('name');
		$query = $this->db->get_where('ci_subcategories',array('parent' => $id));
		return $result = $query->result_array();
	}
	//-----------------------------------------------------
	public function add_subcategory($data){
		$result = $this->db->insert('ci_subcategories', $data);
        return $this->db->insert_id();	
	}
	//-----------------------------------------------------
	public function edit_subcategory($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_subcategories', $data);
		return true;

	}
	//-----------------------------------------------------
	public function get_subcategory_by_id($id){
		$query = $this->db->get_where('ci_subcategories', array('id' => $id));
		return $result = $query->row_array();
	}

	/*-----------------------------//
	//	ADD CUSTOM FIELDS         //
	//---------------------------*/

	public function get_category_custom_fields($category_id)
	{
		$query = $this->db->get_where('ci_fields_to_category', array('category' => $category_id));
		return $result = $query->result_array();
	}
}
?>