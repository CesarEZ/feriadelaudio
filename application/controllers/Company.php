<?php 

defined('BASEPATH') OR exit('No direct script access allowed');



class Category extends Main_Controller{



	public function __construct()

	{

		parent::__construct();

		$this->load->model('company_model');

		$this->load->model('common_model'); // load common model

	}



	//----------------------------------------------------------------------------------

	// All Categories

	public function index()

	{


		$data['title'] = 'Categories'; 

		$data['layout'] = 'themes/category/categories_page';

		$this->load->view('themes/layout', $data);

	}



	//----------------------------------------------------------------------------------

	// Company Detail

	public function detail($title)

	{

		$company_id = get_company_id($title);



		$data['company_info'] = $this->company_model->get_company_detail($company_id);

		// var_dump($data); exit();

		$data['jobs'] = $this->company_model->get_jobs_by_companies($company_id); // Get company jobs



		$data['title'] = 'Company Detail'; 

		$data['layout'] = 'themes/jobseeker/company/company_detail_page';

		$this->load->view('themes/layout', $data);

	}



}



?> 