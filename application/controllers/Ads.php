<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->per_page_record = 10;
		$this->load->model('ad_model'); // load job model
		$this->load->model('profile_model');
		$this->load->model('common_model'); // for common funcitons
		$this->load->library('fields'); // for common funcitons
		$this->load->model('home_model');
	}

	//--------------------------------------------------------------
	// Main Index Function

	public function index($title = NULL)
	{	
		if(!$title || is_numeric($title))
		{

			$count = $this->ad_model->count_all_ads();
			$offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$url = base_url("ads/");

			$config = $this->functions->pagination_config($url,$count,$this->per_page_record);
			$config['uri_segment'] = 2;		
			$this->pagination->initialize($config);

			$data['ads'] = $this->ad_model->get_all_ads($this->per_page_record, $offset, null); // Get all posts
			$data['countries'] = $this->common_model->get_countries_list(); 
			$data['categories'] = $this->common_model->get_categories_list(); 

			$data['title'] = 'Listado';
			$data['layout'] = 'themes/ads/ad_list';

			$this->load->view('themes/layout', $data);
		}
		else
		{
			$data['ad'] = $this->ad_model->get_post_detail_by_slug($title);

			$data['others'] = $this->ad_model->get_post_other_detail_by_slug($title);

			$data['similar_ads'] = $this->ad_model->get_similar_ads_by_category_except_active($data['ad']['category'],$data['ad']['id']);

			$data['all_rating'] = $this->ad_model->get_all_rating_product($data['ad']['id']);

			$data['featured'] = $this->home_model->get_interest_ads(10,0);

			$data['title'] = $data['ad']['title'];

			$data['tags'] = 'Ad';

			$data['layout'] = 'themes/ads/ad_detail';

			$this->load->view('themes/layout', $data);
		}
	}
	
	//-------------------------------------------------------------------------------------------
	// Get sub category of category
	public function get_subcategory()
	{
		if($this->input->post('parent'))
		{
			$category = $_POST['parent'];

			$query = $this->db->get_where('ci_subcategories',array('parent' => $category));

			if($query->num_rows() > 0)
			{
				$rows = $query->result_array();
				$options = array('' => 'Seleccione una opción') + array_column($rows,'name','id');
				$html = form_dropdown('subcategory',$options,'','class="select2 form-control select-subcategory" required');
				$response =  array('status' => 'success', 'msg' =>  $html);
			}
			else
			{
				$html = $this->fields->category_fields($category);
				$response =  array('status' => 'fields', 'msg' =>  $html);
			}

			echo json_encode($response);
		}
	}

	//-------------------------------------------------------------------------------------------
	// Get custom fields of sub category
	public function get_subcategory_custom_fields()
	{
		if($this->input->post('parent'))
		{
			$html = $this->fields->subcategory_fields($_POST['parent']);

			$response =  array('status' => 'success', 'msg' =>  $html);

			echo json_encode($response);
		}
	}
	
	/* Filters */

	//-------------------------------------------------------------------------------------------
	// Get sub category of category
	public function get_subcategory_for_filter()
	{
		if($this->input->post('parent'))
		{
			$category = $_POST['parent'];

			$query = $this->db->get_where('ci_subcategories',array('parent' => $category));

			if($query->num_rows() > 0)
			{
				$rows = $query->result_array();
				$options = array('' => 'Seleccione una subcategoria') + array_column($rows,'name','id');
				$dropdown = form_dropdown('subcategory',$options,'','class="filter-subcategory form-control"');
				$html = '<div class="row"><div class="col-12 form-group">'.$dropdown.'</div></div>';
				$response =  array('status' => 'success', 'msg' =>  $html);
			}
			else
			{
				$html = $this->fields->filter_category_fields($category);
				$response =  array('status' => 'fields', 'msg' =>  $html);
			}

			echo json_encode($response);
		}
	}

	//-------------------------------------------------------------------------------------------
	// Get custom fields of sub category
	public function get_subcategory_custom_fields_for_filter()
	{
		if($this->input->post('parent'))
		{
			$html = $this->fields->filter_subcategory_fields($_POST['parent']);

			$response =  array('status' => 'success', 'msg' =>  $html);

			echo json_encode($response);
		}
	}

	//----------------------------------------
	public function get_country_states()
	{
		$states = $this->db->select('*')->where('country_id',$this->input->post('country'))->get('ci_states')->result_array();
		$options = array('' => 'Seleccione un estado') + array_column($states,'name','id');
		$html = form_dropdown('state',$options,'','class="filter-state form-control"');
		$error =  array('msg' => $html);
		echo json_encode($error);
	}

	//----------------------------------------
	public function get_state_cities()
	{
		$cities = $this->db->select('*')->where('state_id',$this->input->post('state'))->get('ci_cities')->result_array();
		$options = array('' => 'Seleccione una ciudad') + array_column($cities,'name','id');
		$html = form_dropdown('city',$options,'','class="filter-city form-control"');
		$error =  array('msg' => $html);
		echo json_encode($error);
	}

	public function save_rating($place)
	{
		$user_id         = $this->session->userdata('user_id');
		$ad_id           = htmlspecialchars(htmlentities($this->input->post("ad_id")));
		$ad_slug         = htmlspecialchars(htmlentities($this->input->post("ad_slug")));
		$name            = htmlspecialchars(htmlentities($this->input->post("name")));
		$rating_star     = htmlspecialchars(htmlentities($this->input->post("rating-star")));
		$rating_comments = htmlspecialchars(htmlentities($this->input->post("rating-comments")));

		if ($name=="") { $name_user = $this->profile_model->get_user_by_id($user_id); $name = $name_user['username']; }
		if ($user_id=="") { $user_id = time(); }
		if ($rating_star == 1) { $rating_star = 5; } else if ($rating_star == 2) { $rating_star = 4; } else if ($rating_star == 3) { $rating_star = 3; } else if ($rating_star == 4) { $rating_star = 2; } else if ($rating_star == 5) { $rating_star = 1; } 
		
		if ($place == "users") {

			$data = array(
				'profile_id' => $ad_id, 
				'user_id'    => $user_id,
				'username'   => $name,
				'rating'     => $rating_star,
				'comments'   => $rating_comments
			);

			$this->ad_model->update_post_rating($data, $place);
			redirect(base_url('ads/show_contact/'.$ad_slug), 'location');

		} else if ($place == "products") {

			$data = array(
				'ad_id'    => $ad_id, 
				'user_id'  => $user_id,
				'username' => $name,
				'rating'   => $rating_star,
				'comments' => $rating_comments
			);

			$this->ad_model->update_post_rating($data, $place);
			redirect(base_url('ad/'.$ad_slug), 'location');

		}
	}

	public function show_contact($user_id="")
	{
		if ($user_id=="") { redirect(base_url(), 'location'); }

		$data['countries'] = $this->common_model->get_countries_list(); 
		
		$data['user_info'] = $this->profile_model->get_user_by_id($user_id);

		$data['all_rating'] = $this->ad_model->get_all_rating_user($user_id);

		if (isset($data['user_info'])) {

			$data['layout'] = 'themes/ads/ad_user';

			$this->load->view('themes/layout', $data);

		} else { redirect(base_url(), 'location'); }
	}

}// endClass
