<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_Model extends CI_Model{

	// Get Ad detail by ID
	public function get_ad_by_id($ad_id,$user_id)
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
		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory');
		$this->db->join('ci_users','ci_users.id = ci_ads.seller');
		$this->db->where('ci_ads.id',$ad_id);
		$this->db->where('ci_ads.seller',$user_id);
		$result = $this->db->get('ci_ads');
		if($result->num_rows() > 0)
			return $result->row_array();
		else
			return false;
	}
	
	// update slug
	
	function update_ad_slug_by_id($slug,$ad_id)
	{
		$this->db->where('id',$ad_id);
		$this->db->update('ci_ads',array('slug' => $slug));
		return true;
	}

	// Get Post other detail by ID
	public function get_ad_other_detail_by_id($ad_id)
	{
		$this->db->select(
			'ci_ad_detail.*,
			ci_fields.id as fid,
			ci_fields.name as fname,
			ci_fields.slug as fslug,
			ci_fields.type as ftype,
			ci_fields.length as flength,
			ci_fields.default_value as fdefault_value,
			ci_fields.required as frequired,
			ci_field_options.id as oid,
			ci_field_options.name as oname,
			ci_field_options.parent_field as oparent_field,
			');
		$this->db->join('ci_fields','ci_fields.id = ci_ad_detail.field_id');
		$this->db->join('ci_field_options','ci_field_options.parent_field = ci_fields.id');
		$this->db->where('ci_ad_detail.ad_id',$ad_id);
		$result = $this->db->get('ci_ad_detail');
		if($result->num_rows() > 0)
			return $result->row_array();
		else
			return false;
	}

	public function ad_update_data($ad_update_data, $ad_id)	{

		$this->db->set($ad_update_data);
		$this->db->where('id', $ad_id);
		$this->db->update('ci_ads');
	}

	// insert Ad
	public function add_ad($data)
	{
		$this->db->insert('ci_ads', $data);

		return $this->db->insert_id();
	}

	// Edit Ad
	public function edit_ad($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('ci_ads',$data);
		return true;
	}

	// Edit Ad
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

	// insert Ad Custom Fields
	public function add_ad_field_detail($data)
	{
		$this->db->insert('ci_ad_detail', $data);

		return true;
	}

	// insert payment
	public function add_payment($data)
	{
		$this->db->insert('ci_payments', $data);

		return true;
	}

	// Get Package Detail
	public function get_package_detail_by_id($id)
	{

		$this->db->select('*');

		$this->db->from('ci_packages');

		$this->db->where('is_active', 1);

		$this->db->group_by('title');

		$query = $this->db->get();

		return $query->row_array();
	}

	// update rating
	public function update_ad_rating($data)
	{

		$this->db->select('*');

		$this->db->where("ad_id", $data['ad_id']);

		$this->db->where("user_id",  $data['user_id']);

		$row = $this->db->get('ci_ad_rating')->result_array();

		if(count($row) > 0)

		{

			$value = array('rating' => $data['rating']);

			$this->db->where(array('user_id' => $data['user_id'], 'ad_id' => $data['ad_id']));

			$this->db->update('ci_ad_rating',$value);

		}

		else

		{

			$this->db->insert('ci_ad_rating', $data);

		}

		return true;
	}

	//save_favorite
	public function save_favorite($data)
	{
		$check = $this->db->get_where('ci_ad_favorite',$data);

		if($check->num_rows() > 0)
		{
			$this->db->where($data)->delete('ci_ad_favorite');
			return false;
		}
		else
		{
			$this->db->insert('ci_ad_favorite',$data);
			return true;
		}

	}


} // endClass
?>