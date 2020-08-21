<?php  defined('BASEPATH') OR exit('No direct script access allowed');



class Inbox_Model extends CI_Model{



	//----------------------------------------------------------------------

	// Get user messages list

	public function get_messages_list()

	{

		$this->db->select('

			ci_inbox.id,

			ci_inbox.sender,

			ci_inbox.receiver,

			ci_inbox.ad,

			ci_inbox.message,

			ci_inbox.receiver_view,

			ci_inbox.created_date,

			ci_ads.id as pid,

			ci_ads.title,

			ci_ads.slug,

			ci_ads.seller,

			ci_ads.category,

			ci_ads.subcategory,

		');

		$this->db->join('ci_ads','ci_ads.id = ci_inbox.ad');

		$this->db->having('sender',$this->session->user_id);

		$this->db->or_having('receiver',$this->session->user_id);

		$this->db->order_by('ci_inbox.id','desc');

		$this->db->group_by('ci_inbox.ad');

		return $this->db->get('ci_inbox')->result_array();

	}

	//----------------------------------------------------------------------

	// Get user messages list

	public function get_messages_by_ad($ad_id,$slug)

	{

		$this->db->select('

			ci_inbox.id,

			ci_inbox.sender,

			ci_inbox.receiver,

			ci_inbox.ad,

			ci_inbox.message,

			ci_inbox.created_date,

			ci_ads.id as pid,

			ci_ads.title,

			ci_ads.slug,

			ci_ads.category,

			ci_ads.subcategory,

		');

		$this->db->join('ci_ads','ci_ads.id = ci_inbox.ad');

		$this->db->having('sender',$this->session->user_id);

		$this->db->or_having('receiver',$this->session->user_id);

		$this->db->where('ci_inbox.ad',$ad_id);

		return $this->db->get('ci_inbox')->result_array();
		
	}



	//----------------------------------------------------------------------

	// 

	public function add_message($data)

	{

		$this->db->insert('ci_inbox',$data);

		return true;

	}



	public function get_ad_by_slug($slug)

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

		$this->db->where('ci_ads.slug',$slug);

		return $this->db->get('ci_ads')->row_array();

	}





}//end class

?>