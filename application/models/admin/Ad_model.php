<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_Model extends CI_Model{
	//---------------------------------------------------

	// Count total Ads

	public function count_all_ads()
	{
		$this->db->select('*');
		$this->db->from('ci_ads');
		$this->db->where('is_status', 1);
		return $this->db->count_all_results();

	}

	//---------------------------------------------------------------------------	
	// Get All Ads
	public function get_all_ads()
	{

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
		');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory');

		// 

		if($this->session->userdata('ad_search_category') != '')
			$this->db->where('ci_ads.category',$this->session->userdata('ad_search_category'));

		if($this->session->userdata('ad_search_subcategory') != '')
			$this->db->where('ci_ads.subcategory',$this->session->userdata('ad_search_subcategory'));

		if($this->session->userdata('ad_search_status') != '')
			$this->db->where('ci_ads.is_status',$this->session->userdata('ad_search_status'));

		if($this->session->userdata('ad_search_package') != '')
			$this->db->where('ci_ads.package',$this->session->userdata('ad_search_package'));

		if($this->session->userdata('ad_search_from') != '')
			$this->db->where('DATE(ci_ads.created_date) >=',date('Y-m-d',strtotime($this->session->userdata('ad_search_from'))));

		if($this->session->userdata('ad_search_to') != '')
			$this->db->where('DATE(ci_ads.created_date) <=',date('Y-m-d',strtotime($this->session->userdata('ad_search_to'))));

		$this->db->order_by('ci_ads.id','desc');

		$query = $this->db->get();

		return $query->result_array();
	}
	
	//---------------------------------------------------------------------------	
	// Get Ads by limit
	public function get_ads($limit)
	{

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
		');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory');

		// 

		if($this->session->userdata('ad_search_category') != '')
			$this->db->where('ci_ads.category',$this->session->userdata('ad_search_category'));

		if($this->session->userdata('ad_search_subcategory') != '')
			$this->db->where('ci_ads.subcategory',$this->session->userdata('ad_search_subcategory'));

		if($this->session->userdata('ad_search_status') != '')
			$this->db->where('ci_ads.is_status',$this->session->userdata('ad_search_status'));

		if($this->session->userdata('ad_search_package') != '')
			$this->db->where('ci_ads.package',$this->session->userdata('ad_search_package'));

		if($this->session->userdata('ad_search_from') != '')
			$this->db->where('DATE(ci_ads.created_date) >=',date('Y-m-d',strtotime($this->session->userdata('ad_search_from'))));

		if($this->session->userdata('ad_search_to') != '')
			$this->db->where('DATE(ci_ads.created_date) <=',date('Y-m-d',strtotime($this->session->userdata('ad_search_to'))));


		$this->db->order_by('ci_ads.id','desc');

		$this->db->group_by('slug');

		$this->db->limit($limit);

		$query = $this->db->get();

		return $query->result_array();
	}

	//---------------------------------------------------------------------------	
	// Get Single Ad by ID
	public function get_ad_by_id($id)
	{
		$this->db->select(
			'ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			ci_users.id as seller_id,
			ci_users.firstname,
			ci_users.lastname,
			ci_users.contact,
			ci_users.email,
			ci_users.created_date as since,
		');
		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');
		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');
		$this->db->join('ci_users','ci_users.id = ci_ads.seller');
		$this->db->where('ci_ads.id',$id);
		return $this->db->get('ci_ads')->row_array();
	}
	
	// update slug
	function update_ad_slug_by_id($slug,$ad_id)
	{
	    $this->db->where('id',$ad_id);
	    $this->db->update('ci_ads',array('slug' => $slug));
	    return true;
	}

	public function get_ad_other_detail_by_slug($slug)
	{
		$this->db->select('
			ci_ads.id,
			ci_ads.slug,
			ci_ad_detail.ad_id,
			ci_ad_detail.field_id,
			ci_ad_detail.field_value,
			ci_fields.id as fid,
			ci_fields.name as fname,
			ci_field_options.id as oid,
			ci_field_options.parent_field,
			ci_field_options.name as oname
		');
		$this->db->join('ci_ads','ci_ads.id = ci_ad_detail.ad_id','right');
		$this->db->join('ci_fields','ci_fields.id = ci_ad_detail.field_id');
		$this->db->join('ci_field_options','ci_field_options.id = ci_ad_detail.field_value','right');
		$this->db->where('ci_ads.slug',$slug);
		return $this->db->get('ci_ad_detail')->result_array();
	}
	
	//---------------------------------------------------------------------------	

	// Get User Detail by ID

	public function get_user_by_id($id)

	{

		$query = $this->db->get_where('ci_users', array('id' => $id));

		return $result = $query->row_array();

	}

	// Edit ad
	public function edit_ad($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('ci_ads',$data);
		return true;
	}

	// Edit ad
	public function edit_ad_details($data,$ad_id)
	{
		$this->db->where('ad_id',$ad_id);
		$this->db->update('ci_ad_detail',$data);
		return true;
	}

	public function delete_ad_field_detail($ad_id)
	{
		$this->db->where('ad_id',$ad_id);
		$this->db->delete('ci_ad_detail');
		return true;
	}

	// insert ad Custom Fields
	public function add_ad_field_detail($data)
	{
		$this->db->insert('ci_ad_detail', $data);

		return true;
	}


} // endClass



?>