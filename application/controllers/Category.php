<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Main_Controller{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('Category_model','Category_m');

		$this->load->model('common_model'); // load common model

	}

	//----------------------------------------------------------------------------------

	// All Categories

	public function index($category = '',$subcategory = '')
	{

		if($category == '')
		{
			$data['title'] = 'Categories'; 

			$data['categories'] = $this->Category_m->get_all_categories();
			
			$data['layout'] = 'themes/user/categories/categories_page';

			$this->load->view('themes/layout', $data);

		}
		else
		{

			$category_id = get_category_id($category);

			$data['fields'] = $this->Category_m->get_category_fields($category_id);

			$data['ads'] = $this->Category_m->get_all_ads_by_category($category,$subcategory);

			$data['subcategories'] = $this->Category_m->get_subcatories_by_category($category);

			$data['title'] = get_category_by_slug($category); 
	
			$data['layout'] = 'themes/ads/ad_list';

			$this->load->view('themes/layout', $data);

		}
	}
}
?> 