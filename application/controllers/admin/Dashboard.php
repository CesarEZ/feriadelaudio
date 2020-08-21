<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {

	public function __construct(){
		parent::__construct();
		auth_check(); // check login auth
		$this->load->model('admin/dashboard_model', 'dashboard_model');
		$this->load->model('admin/ad_model', 'ad_model');
		$this->load->model('admin/user_model', 'user_model');
	}

	//--------------------------------------------------------------------------
	public function index(){

		$data['active_users'] = $this->dashboard_model->get_active_users();
		$data['deactive_users'] = $this->dashboard_model->get_deactive_users();
		$data['active_ads'] = $this->dashboard_model->get_active_ads();
		$data['pending_ads'] = $this->dashboard_model->get_pending_ads();

		$data['ads'] = $this->ad_model->get_ads(10);
		$data['users'] = $this->user_model->get_users(10);

		$data['title'] = 'Dashboard';

		$this->load->view('admin/includes/_header');
    	$this->load->view('admin/dashboard/index', $data);
    	$this->load->view('admin/includes/_footer');
	}
	
}

?>	