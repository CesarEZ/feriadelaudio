<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_Model extends CI_Model{

	//---------------------------------------------------
	// Count total jobs

	public function count_all_ads()
	{
		$filters = $_GET;

		if(isset($filters['category']) && !empty($filters['category']))
			$this->db->where('ci_ads.category',$filters['category']);

		if(isset($filters['subcategory']) && !empty($filters['subcategory']))
			$this->db->where('ci_ads.subcategory',$filters['subcategory']);

		if(isset($filters['price-min']) && !empty($filters['price-min']))
			$this->db->where('ci_ads.price >=',$filters['price-min']);

		if(isset($filters['price-max']) && !empty($filters['price-max']))
			$this->db->where('ci_ads.price <=',$filters['price-max']);

		if(isset($filters['country']))
			$this->db->where('ci_ads.country',$filters['country']);

		if(isset($filters['state']))
			$this->db->where('ci_ads.state',$filters['state']);

		if(isset($filters['city']))
			$this->db->where('ci_ads.city',$filters['city']);

		if(isset($filters['ad_type']))
			$this->db->where('ci_ads.is_featured',$filters['ad_type']);

		if(isset($filters['title']))
			$this->db->like('ci_ads.title',$filters['title']);

		if(isset($filters['q']))
		{
			$search_text = explode(' ', $filters['q']);
			$this->db->group_start();
			foreach($search_text as $search){
				$this->db->or_like('ci_ads.description', $search);
				$this->db->or_like('ci_ads.title', $search);
				$this->db->or_like('ci_ads.tags', $search);
			}
			$this->db->group_end();
		}

		unset($filters['ad_type']);
		unset($filters['category']);
		unset($filters['subcategory']);
		unset($filters['price-max']);
		unset($filters['price-min']);
		unset($filters['q']);
		unset($filters['country']);
		unset($filters['state']);
		unset($filters['city']);
		unset($filters['title']);

		foreach ($filters as $key => $value) {
			$key = explode('-', $key)[1];
			$this->db->where('ci_ad_detail.field_id',$key);
			$this->db->where('ci_ad_detail.field_value',$value);
		}

		$this->db->select('
			ci_ads.*,
			ci_ad_detail.ad_id,
			ci_ad_detail.field_id,
			ci_ad_detail.field_value,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_categories.slug as category_slug,
			
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_ad_detail','ci_ad_detail.ad_id = ci_ads.id','left');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('ci_ads.is_status', 1);

		$this->db->group_by('slug');

		return $this->db->count_all_results();
	}

	//---------------------------------------------------------------------------	

	// Get All Jobs

	public function get_all_ads($limit, $offset)
	{

		$country_user = $_COOKIE['country_user'];

		// search URI parameters

		$filters = $_GET;

		if(isset($filters['category']) && !empty($filters['category']))
			$this->db->where('ci_ads.category',$filters['category']);

		if(isset($filters['subcategory']) && !empty($filters['subcategory']))
			$this->db->where('ci_ads.subcategory',$filters['subcategory']);

		if(isset($filters['price-min']) && !empty($filters['price-min']))
			$this->db->where('ci_ads.price >=',$filters['price-min']);

		if(isset($filters['price-max']) && !empty($filters['price-max']))
			$this->db->where('ci_ads.price <=',$filters['price-max']);

		if(isset($filters['country'])){
			$this->db->where('ci_ads.country',$filters['country']);
		} else {
			$this->db->where('ci_ads.country',$country_user);
		}

		if(isset($filters['state']))
			$this->db->where('ci_ads.state',$filters['state']);

		if(isset($filters['city']))
			$this->db->where('ci_ads.city',$filters['city']);

		if(isset($filters['ad_type']))
			$this->db->where('ci_ads.is_featured',$filters['ad_type']);

		if(isset($filters['title']))
			$this->db->like('ci_ads.title',$filters['title']);

		if(isset($filters['q']))
		{
			$search_text = explode(' ', $filters['q']);
			$this->db->group_start();
			foreach($search_text as $search){
				$this->db->or_like('ci_ads.description', $search);
				$this->db->or_like('ci_ads.title', $search);
				$this->db->or_like('ci_ads.tags', $search);
			}
			$this->db->group_end();
		}

		unset($filters['ad_type']);
		unset($filters['category']);
		unset($filters['subcategory']);
		unset($filters['price-max']);
		unset($filters['price-min']);
		unset($filters['q']);
		unset($filters['country']);
		unset($filters['state']);
		unset($filters['city']);
		unset($filters['title']);

		foreach ($filters as $key => $value) {
			$key = explode('-', $key)[1];
			$this->db->where('ci_ad_detail.field_id',$key);
			$this->db->where('ci_ad_detail.field_value',$value);
		}

		$this->db->select('
			ci_ads.*,
			ci_ad_detail.ad_id,
			ci_ad_detail.field_id,
			ci_ad_detail.field_value,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_categories.slug as category_slug,
			
			');

		$this->db->from('ci_ads');

		$this->db->join('ci_ad_detail','ci_ad_detail.ad_id = ci_ads.id','left');

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory','left');

		$this->db->where('ci_ads.is_status', 1);

		$this->db->order_by('ci_ads.is_search','asc');

		$this->db->group_by('slug');

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result_array();

	}


	public function get_post_detail_by_slug($slug)
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
		$this->db->where('ci_ads.is_status',1);
		return $this->db->get('ci_ads')->row_array();
	}

	public function get_post_other_detail_by_slug($slug)
	{
		$this->db->select('
			ci_ads.id,
			ci_ads.slug,
			ci_ad_detail.ad_id,
			ci_ad_detail.field_id,
			ci_ad_detail.field_value,
			ci_fields.id as fid,
			ci_fields.name as fname,
			
			');
		$this->db->join('ci_ads','ci_ads.id = ci_ad_detail.ad_id','right');
		$this->db->join('ci_fields','ci_fields.id = ci_ad_detail.field_id');
		$this->db->where('ci_ads.slug',$slug);
		$this->db->where('ci_ads.is_status',1);
		return $this->db->get('ci_ad_detail')->result_array();
	}


	public function get_similar_ads_by_category_except_active($category,$active_post)
	{

		$country_user = $_COOKIE['country_user'];
		
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
		$this->db->where('ci_ads.id !=',$active_post);
		$this->db->where('ci_ads.category',$category);
		$this->db->where('ci_ads.is_status',1);
		$this->db->where('ci_ads.country', $country_user);
		$this->db->order_by('ci_ads.id','desc');
		$this->db->limit(5);
		return $this->db->get('ci_ads')->result_array();
	}

	//---------------------------------------------------

	// Count total users

	public function count_all_search_result($search=null)
	{
		$this->db->select('
			ci_ads.*,
			ci_categories.id as cat_id,
			ci_categories.name as category_name,
			ci_subcategories.id as subcat_id,
			ci_subcategories.name as subcategory_name,
			');


		// search URI parameters

		if($search){
			// search URI parameters
			unset($search['p']); //unset pagination parameter form search

			if(!empty($search['country']))
				$this->db->where('country', $search['country']);
			if(!empty($search['title'])){
				$search_text = explode('-', $search['title']);
				$this->db->group_start();
				foreach($search_text as $search){
					$this->db->or_like('title', $search);
					$this->db->or_like('tags', $search);
				}
				$this->db->group_end();
			}
			else
				$this->db->where($search);
		}

		$this->db->join('ci_categories','ci_categories.id = ci_ads.category');

		$this->db->join('ci_subcategories','ci_subcategories.id = ci_ads.subcategory');

		$this->db->order_by('created_date','desc');

		$this->db->where('is_status', 1);

		$this->db->group_by('title');

		$this->db->from('ci_ads');

		return $this->db->count_all_results();

	}

	//---------------------------------------------------------------------------	

	// Get Post detail by ID
	public function get_post_by_id($ad_id,$user_id)
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
		$this->db->where('ci_ads.is_status',1);
		$result = $this->db->get('ci_ads');
		if($result->num_rows() > 0)
			return $result->row_array();
		else
			return false;
	}

	//---------------------------------------------------------------------------	

	// Get User Detail by ID

	public function get_user_by_id($id)

	{

		$query = $this->db->get_where('ci_users', array('id' => $id));

		return $result = $query->row_array();

	}

	/*----------------------------------
		ACTIVE USER AD POST FUNCTIONS
		-----------------------------------*/

	// insert Post
		public function add_post($data)
		{
			$this->db->insert('ci_ads', $data);

			return $this->db->insert_id();
		}

	// Edit Post
		public function edit_post($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('ci_ads',$data);
			return true;
		}

	// Edit Post
		public function edit_post_details($data,$ad_id)
		{
			$this->db->where('ad_id',$ad_id);
			$this->db->update('ci_ad_detail',$data);
			return true;
		}

		public function delete_post_field_detail($ad_id)
		{
			$this->db->where('ad_id',$ad_id);
			$this->db->delete('ci_ad_detail');
			return true;
		}

	// insert Post Custom Fields
		public function add_post_field_detail($data)
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
		public function update_post_rating($data="", $place="")
		{

			if ($place=="products") {

				$table      = "ci_ad_rating";
				$profile_id = "ad_id";

			} else if ($place=="users") {

				$table      = "ci_users_rating";
				$profile_id = "profile_id";

			} else {

				$table      = "ci_ad_rating"; 
				$profile_id = "ad_id";

			}

			$this->db->select('*');

			$this->db->where($profile_id, $data[$profile_id]);

			$this->db->where("user_id",  $data['user_id']);

			$row = $this->db->get($table)->result_array();

			if(count($row) > 0)

			{

				$value = array('rating' => $data['rating'], 'comments' => $data['comments']);

				$this->db->where(array('user_id' => $data['user_id'], $profile_id => $data[$profile_id]));

				$this->db->update($table, $value);

			}

			else

			{

				$this->db->insert($table, $data);

			}

			return true;
		}

		public function get_all_rating_product($ad_id)
		{
			$this->db->select('ci_ad_rating.username, ci_ad_rating.rating, ci_ad_rating.comments, ci_ad_rating.updated_date as ad_date');
			$this->db->from('ci_ad_rating');
			$this->db->where('ad_id', $ad_id);
			$queryRating = $this->db->get();

			if ($queryRating->num_rows() > 0) {
				return $queryRating->result();
			} else {
				return false;
			}
		}

		public function get_all_rating_user($profile_id)
		{
			$this->db->select('ci_users_rating.username, ci_users_rating.rating, ci_users_rating.comments, ci_users_rating.updated_date as ad_date');
			$this->db->from('ci_users_rating');
			$this->db->where('profile_id', $profile_id);
			$queryRating = $this->db->get();

			if ($queryRating->num_rows() > 0) {
				return $queryRating->result();
			} else {
				return false;
			}
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


		public function get_category_by_id($id_category)
		{
			$this->db->where('id', $id_category);
			$queryCategory = $this->db->get('ci_categories');

			if ($queryCategory->num_rows() > 0) {
				return $queryCategory->result_array();
			} else {
				return false;
			}
		}

} // endClass



?>