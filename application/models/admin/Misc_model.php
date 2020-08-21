<?php
class Misc_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function get_all_countries(){
		$this->db->order_by('name');
		$query = $this->db->get('ci_countries');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function get_all_states(){
		$this->db->order_by('country_id');
		$query = $this->db->get('ci_states');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function get_all_cities(){
		$this->db->order_by('state_id');
		$query = $this->db->get('ci_cities');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function add_country($data){
		$result = $this->db->insert('ci_countries', $data);
        return $this->db->insert_id();	
	}

	//-----------------------------------------------------
	public function add_state($data){
		$result = $this->db->insert('ci_states', $data);
        return true;	
	}

	//-----------------------------------------------------
	public function add_city($data){
		$result = $this->db->insert('ci_cities', $data);
        return true;	
	}

	//-----------------------------------------------------
	public function edit_country($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_countries', $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_state($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_states', $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_city($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_cities', $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_country_by_id($id){
		$query = $this->db->get_where('ci_countries', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_state_by_id($id){
		$query = $this->db->get_where('ci_states', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_city_by_id($id){
		$query = $this->db->get_where('ci_cities', array('id' => $id));
		return $result = $query->row_array();
	}
	
	// ---------------------------------------------------
	//                     CURRENCY
	//-----------------------------------------------------

	public function get_all_currencies()
	{
		$this->db->order_by('id');
		$query = $this->db->get('ci_currency');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function add_currency($data){
		$result = $this->db->insert('ci_currency', $data);
        return $this->db->insert_id();	
	}

	//-----------------------------------------------------
	public function get_currency_by_id($id){
		$query = $this->db->get_where('ci_currency', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function edit_currency($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_currency', $data);
		return true;
	}

	// ---------------------------------------------------
	//                     LANGUAGE
	//-----------------------------------------------------

	public function get_all_languages()
	{
		$this->db->order_by('id');
		$query = $this->db->get('ci_language');
		return $result = $query->result_array();
	}

	//-----------------------------------------------------
	public function add_language($data){
		$result = $this->db->insert('ci_language', $data);
        return $this->db->insert_id();	
	}

	//-----------------------------------------------------
	public function get_language_by_id($id){
		$query = $this->db->get_where('ci_language', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function edit_language($data, $id){
		$this->db->where('id', $id);
		$this->db->update('ci_language', $data);
		return true;
	}
	
	//-------------------------------------------------
	public function get_contact_form_details()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		return $this->db->get('ci_contact_us')->result_array();
	}

}
?>