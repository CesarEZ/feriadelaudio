<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Home_Model extends CI_Model{



	//-------------------------------------------------------------------

    // contant us 

	public function contact($data)
	{

		$this->db->insert('ci_contact_us',$data);

		return true;

	}

	// -----------------------------------------------------------
	// dynamic pages

	public function get_page_by_slug($slug)
	{
		return $this->db->get_where('ci_pages',array('slug' => $slug, 'is_active' => 1))->row_array();
	}

	// -----------------------------------------------------------
	// dynamic pages

	public function get_all_ads()
	{
		$country_user = $_COOKIE['country_user'];

		$this->db->where('ci_ads.country', $country_user);
		$query = $this->db->get('ci_ads');
		
		return $query->result_array();
	}

	//-------------------------------------------------------------------

	// Get Current ads for home page

	public function get_current_ads($limit, $offset)
	{

		$country_user = $_COOKIE['country_user'];

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('is_status', 1);

		$this->db->where('ci_ads.country', $country_user);

		$this->db->order_by('ci_ads.id','desc');

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();
	}

	// Get Featured ads for home page

	public function get_featured_ads($limit, $offset, $country="")
	{

		$country_user = $_COOKIE['country_user'];

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('is_status', 1);

		$this->db->where('is_featured', 1);
		
		$this->db->where('ci_ads.country', $country_user);

		$this->db->order_by('ci_ads.id','desc');

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();
	}

	// Get Hot ads for home page

	public function get_hot_ads($limit, $offset, $country="")
	{

		$country_user = $_COOKIE['country_user'];		

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('is_status', 1);

		$this->db->where('is_featured', 2);

		$this->db->where('ci_ads.country', $country_user);

		$this->db->order_by('created_date','desc');

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();
	}

	// Get Hot ads for home page

	public function get_interest_ads($limit, $offset)
	{

		$country_user = $_COOKIE['country_user'];	

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('is_status', 1);

		$this->db->where('is_interest', 1);

		$this->db->where('ci_ads.country', $country_user);

		$this->db->order_by('created_date','desc');

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();
	}


	//-------------------------------------------------------------------

	// Get testimonials

	public function get_testimonials()
	{

		$this->db->select('*');

		$this->db->from('ci_testimonials');

		$this->db->order_by('is_default');
		
		$this->db->where('status',1);

		$query = $this->db->get();

		return $query->result_array();

	}


	//----------------------------------------------------

	// Get companies logos for home page

	public function get_home_page_categories()

	{

		$this->db->select('*');

		$this->db->where('show_on_home',1);
		
		$this->db->from('ci_categories');

		$query = $this->db->get();

		return $query->result_array();

	}

	public function add_subscriber($data)
	{
		$this->db->where('email',$data['email']);
		$query = $this->db->get('ci_subscribers');

		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			$this->db->insert('ci_subscribers',$data);
			return true;
		}
	}

	public function change_status_reminder_expiration($id_ads, $status_ads)
	{
		$this->db->set('expiration_date_reminder', $status_ads);
		$this->db->where('id', $id_ads);
		$this->db->update('ci_ads');
	}
}
?>