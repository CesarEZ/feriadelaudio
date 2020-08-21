<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model{

	//-------------------------------------------------------
	// Get User detail
	public function get_user_by_id($id)
	{
		$query = $this->db->get_where('ci_users', array('id' => $id));
		return $result = $query->row_array();
	}

	// --------------------------------------------------------
	//Get user ads

	public function get_user_ads_by_id($id)
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
		$this->db->where('ci_ads.seller',$id);
		return $this->db->get('ci_ads')->result_array();
	}

	public function get_user_favourites()
	{
		$this->db->select(
			'ci_ad_favorite.*,
			ci_ads.id as pid,
			ci_ads.title,
			ci_ads.slug,
			ci_ads.img_1,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
		');
		$this->db->join('ci_ads','ci_ads.id = ci_ad_favorite.ad_id');
		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');
		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory');
		return $this->db->get('ci_ad_favorite')->result_array();
	}

	//-------------------------------------------------------
	// Update user
	public function update_user($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('ci_users',$data);
		return true;
	}

	//-------------------------------------------------------
	// Update New password
	public function update_password($data,$user_id)
	{
		$query = $this->db->get_where('ci_users' , array('id' => $user_id));
		$result = $query->row_array();
		if (password_verify($data['current_password'], $result['password'])) {

			$this->db->where('id',$user_id);

			$this->db->update('ci_users',array('password' => $data['password']));

			return true;
			
		}else{
			return false;
		}
	}

	// Get user Notifications
	public function get_user_notifications($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->order_by('id','desc');
		return $this->db->get('ci_notifications')->result_array();
	}
	
	// Get user invoices
	public function get_user_invoices($user_id)
	{
		$this->db->select(
			'ci_ads.id as pid,
			ci_ads.title,
			ci_payments.*,
		');
		$this->db->join('ci_ads','ci_ads.id = ci_payments.ad_id');
		$this->db->where('ci_payments.user_id',$user_id);
		$this->db->order_by('ci_payments.id','desc');
		return $this->db->get('ci_payments')->result_array();
	}


}// endClass
?>