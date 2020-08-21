<?php
class Setting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function update_general_setting($data){
		$this->db->where('id', 1);
		$this->db->update('ci_general_settings', $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_general_settings(){
		$this->db->where('id', 1);
        $query = $this->db->get('ci_general_settings');
        return $query->row_array();
	}
	
	// ---------------------------------------------------
	public function get_footer_settings()
	{
		return $this->db->get('ci_footer_settings')->result_array();
	}

	//----------------------------------------------------
	public function delete_footer_all_setting()
	{
		$this->db->where('id !=', NULL);
		$this->db->delete('ci_footer_settings');
		return true;
	}
	//-----------------------------------------------------
	public function update_footer_setting($data){
		$this->db->insert('ci_footer_settings',$data);
		return true;

	}

	/*----------------
		User Menu
	-----------------*/

	public function get_all_user_menu()
	{
		return $this->db->get_where('ci_menu',array('active' => 1))->result_array();
	}

	//-----------------------------------------------------
	public function add_menu($data){
		$this->db->insert('ci_menu', $data);
		return true;
	}

	//---------------------------------------------------
	// 
	public function edit_menu($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_menu', $data);
		return true;
	}

	//---------------------------------------------------
	// 
	public function get_menu_by_id($id){
		$this->db->where('id', $id);
		return $this->db->get('ci_menu')->row_array();
	}

	//---------------------------------------------------
	// 
	public function delete_menu($id){
		$this->db->where('id', $id);
		$this->db->delete('ci_menu');
		return true;
	}

	/*------------------------------
		Sub Menu  
	------------------------------*/

	//-----------------------------------------------------
	function add_sub_menu($data)
    {
		$this->db->insert('ci_sub_menu',$data);
		return $this->db->insert_id();
    } 

	//-----------------------------------------------------
	function get_sub_menu_by_id($id)
    {
		$this->db->from('ci_sub_menu');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row_array();
    } 	

	//-----------------------------------------------------
	function get_sub_menu_by_menu($id)
    {
		$this->db->select('*');
		$this->db->where('parent',$id);
		$this->db->order_by('sort_order','asc');
		$query = $this->db->get('ci_sub_menu');
		return $query->result_array();
    }

    //----------------------------------------------------
    function edit_sub_menu($data, $id)
    {
    	$this->db->where('id', $id);
		$this->db->update('ci_sub_menu', $data);
		return true;
    }

    //-----------------------------------------------------
	function delete_sub_menu($id)
	{		
		$this->db->where('id',$id);
		$this->db->delete('ci_sub_menu');
		return true;
	} 

	/*--------------------------
	   Email Template Settings
	--------------------------*/

	function get_email_templates()
	{
		return $this->db->get('ci_email_templates')->result_array();
	}

	function update_email_template($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('ci_email_templates', $data);
		return true;
	}

	function get_email_template_content_by_id($id)
	{
		return $this->db->get_where('ci_email_templates',array('id' => $id))->row_array();
	}

	function get_email_template_variables_by_id($id)
	{
		return $this->db->get_where('ci_email_template_variables',array('template_id' => $id))->result_array();
	}

	/*------------------------------
		Payment Settings
	------------------------------*/

	// ----------------------------------------------------
	// Get Stripe Setting
	public function get_stripe_settings()
	{
		$this->db->select('publishable_key,secrate_key,stripe_status');
		$this->db->where('id',1);
		return $this->db->get('ci_general_settings')->row_array();
	}


	// ----------------------------------------------------
	// Update Stripe Settings
	public function update_stripe_settings($data)
	{
		$this->db->where('id',1);
		$this->db->update('ci_general_settings',$data);
		return true;
	}
}
?>