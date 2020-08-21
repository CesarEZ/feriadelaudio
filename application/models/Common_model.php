<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model 

{

    //-------------------------------------------------------------------

	// Get Ad Packages

	public function get_packages()
	{

		$this->db->select('*');

		$this->db->from('ci_packages');

		$this->db->order_by('id', 'Asc');

		$query = $this->db->get();

		return $query->result_array();

	}

	//-----------------------------------------------

	// Get Categories

	function get_categories_list()

	{

		$this->db->from('ci_categories');

		$this->db->order_by('name');

		$query = $this->db->get();

		return $query->result_array();

	}	

    //-----------------------------------------------

	// Get Categories

	function get_blog_categories_list()

	{

		$this->db->from('ci_blog_categories');

		$this->db->order_by('name');

		$query = $this->db->get();

		return $query->result_array();

	}	

	//------------------------------------------------

	// Get Countries

	function get_countries_list($id=0)

	{

		if($id==0)

		{

			return  $this->db->get('ci_countries')->result_array();	

		}

		else

		{

			return  $this->db->select('id,country')->from('ci_countries')->where('id',$id)->get()->row_array();	

		}

	}	

	//------------------------------------------------
	// Get states
	
	function get_states_list($id=0)
	{
		if($id==0)
		{
			return  $this->db->get('ci_states')->result_array();	
		}
		else
		{
			return  $this->db->select('id,name')->from('ci_states')->where('id',$id)->get()->row_array();	
		}
	}	

	//------------------------------------------------

	// Get Cities

	function get_cities_list($id=0)

	{

		if($id==0){

			return  $this->db->get('ci_cities')->result_array();	

		}

		else{

			return  $this->db->select('id,city')->from('ci_cities')->where('id',$id)->get()->row_array();	

		}

	}

	// Get ad by ID

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

			// Get Ad detail by ID
	public function get_ad_by_product_code($cookie_code)
	{
		$this->db->select(
			'ci_ads.*,
			ci_users.id as id_user,  
			ci_users.username as username_ad,
			ci_users.email as email_ad,
			ci_users.contact as contact_ad,
			ci_packages.id as id_package,
			ci_packages.title as title_package, 
			ci_packages.price as price_package, 
			ci_packages.detail as detail_package'
		);
		$this->db->join('ci_users','ci_users.id = ci_ads.seller');
		$this->db->join('ci_packages','ci_packages.id = ci_ads.Package');
		$this->db->where('product_code', $cookie_code);
		$query_ad_prod_code = $this->db->get('ci_ads');

		if ($query_ad_prod_code->num_rows() > 0) {
			return $query_ad_prod_code->result_array();
		} else {
			return false;
		}
	}

	// Get Payment detail
	public function get_payment_by_id($id_invoice)
	{
		$this->db->where('package_id', $id_invoice);

		$query = $this->db->get_where('ci_payments');
		
		if ($query->num_rows() > 0) { return $query->result(); } else { return false; }
	}

	// Get User detail
	public function get_user_by_id($id)
	{
		$query = $this->db->get_where('ci_users', array('id' => $id));
		return $result = $query->row_array();
	}

	public function data_ci_facebook($id) {
		
		$this->db->where("facebook_account_id", $id);
		$queryFacebook = $this->db->get('ci_users_facebook');

		if ($queryFacebook->num_rows() > 0) {
			return $queryFacebook->result_array();
		} else {
			return false;
		}
	}

	function get_subcategory_name($id)
	{
		$ci = & get_instance();
		$querySubcategory = $ci->db->get_where('ci_subcategories', array('parent' => $id));
		if ($querySubcategory->num_rows() > 0) {
			return $querySubcategory->result_array();
		} else {
			return false;
		}
	}

	//-----------------------------------------------

	// Add Notification

	function add_notification($data)
	{

		$this->db->insert('ci_notifications',$data);

		return true;

	}	

} // endClass

?>