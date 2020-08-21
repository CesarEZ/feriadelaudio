<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model{

	//----------------------------------------------------

	// Get all Categories

	public function get_all_categories()
	{

		$this->db->select('name, description, slug, picture');

		$this->db->where('status',1);

		$this->db->from('ci_categories');

		$query = $this->db->get();

		return $query->result_array();

	}

	//----------------------------------------------------

	// Get all Subcategory by category

	public function get_subcatories_by_category($slug)
	{

		$parent = get_category_id($slug);

		$this->db->select('*');

		$this->db->where('status',1);

		$this->db->where('parent',$parent);

		$this->db->from('ci_subcategories');

		$query = $this->db->get();

		return $query->result_array();

	}


	//----------------------------------------------------

	// Get all ads by category

	public function get_all_ads_by_category($category,$subcategory)
	{

		$country_user = $_COOKIE['country_user'];

		// Set Where for FILTERS

		$filters = $_GET;
		
		if(isset($filters['price-min']) && !empty($filters['price-min']))
			$this->db->where('ci_ads.price >=',$filters['price-min']);
		if(isset($filters['price-max']) && !empty($filters['price-max']))
			$this->db->where('ci_ads.price <=',$filters['price-max']);
		if(isset($filters['state']))
			$this->db->where('ci_ads.state',$filters['state']);
		if(isset($filters['country']))
			$this->db->where('ci_ads.country',$filters['country']);

		if(isset($filters['q']))
		{
			$search_text = explode(' ', $filters['q']);
			$this->db->group_start();
			foreach($search_text as $search){
				$this->db->or_like('ci_ads.description', $search);
				$this->db->or_like('title', $search);
				$this->db->or_like('tags', $search);
			}
			$this->db->group_end();
		}
		
		unset($filters['price-max']);
		unset($filters['price-min']);
		unset($filters['q']);
		unset($filters['state']);
		unset($filters['country']);

		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_categories.slug as category_slug,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('is_status', 1);

		$this->db->where('ci_categories.slug', $category);

		$this->db->where('ci_ads.country', $country_user);

		if($subcategory)
			$this->db->where('ci_subcategories.slug', $subcategory);

		$this->db->order_by('created_date','desc');

		$this->db->group_by('title');

		// $this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();
	}

	//----------------------------------------------------

	// Get custom fields by category

	public function get_category_fields($category_id)
	{
		$this->db->select('
			ci_fields_to_category.id as cat_id,
			ci_fields_to_category.field,
			ci_fields.id,
			ci_fields.name,
			ci_fields.slug,
			ci_fields.type,
			ci_fields.length,
			ci_fields.default_value,
			ci_fields.required,
			ci_fields.status,
			');
		$this->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');
		$this->db->where('ci_fields_to_category.category',$category_id);
		$this->db->where('ci_fields.status',1);
		$this->db->group_by('ci_fields_to_category.field');
		return $this->db->get('ci_fields_to_category')->result_array();
	}



}



?>