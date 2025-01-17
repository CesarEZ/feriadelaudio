<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myposts extends Main_Controller {

	public function __construct()
	{
		parent::__construct();	
		$this->load->model('myjob_model');
		$this->load->model('common_model');
	}

	//-------------------------------------------------------------------------------
	// Applied Jobs
	public function index()
	{
		$this->rbac->check_user_authentication();

		$data['jobs'] = $this->myjob_model->get_applied_jobs(); // Fetching Applied jobs

		$data['user_sidebar'] = 'themes/jobseeker/user_sidebar'; // load sidebar for user
		$data['title'] = 'Applied Jobs';
		$data['layout'] = 'themes/jobseeker/my_jobs/applied_job_page';
		$this->load->view('themes/layout', $data);
	}

	//-------------------------------------------------------------------------------
	// Matching Jobs
	public function matching()
	{
		$this->rbac->check_user_authentication();

		$user_id = $this->session->userdata('user_id');
		$skills = get_user_skills($user_id); // helper function

		$data['jobs'] = $this->myjob_model->get_matching_jobs($skills);

		$data['user_sidebar'] = 'themes/jobseeker/user_sidebar'; // load sidebar for user
		$data['title'] = 'Matching Jobs';
		$data['layout'] = 'themes/jobseeker/my_jobs/matching_jobs_page';
		$this->load->view('themes/layout', $data);
	}

	//---------------------------------------------------------------------
	// get saved Jobs
	public function saved()
	{
		$this->rbac->check_user_authentication();

		$user_id = $this->session->userdata('user_id');

		$data['jobs'] = $this->myjob_model->get_saved_jobs($user_id);

		$data['user_sidebar'] = 'themes/jobseeker/user_sidebar'; // load sidebar for user
		$data['title'] = 'Saved Jobs';
		$data['layout'] = 'themes/jobseeker/my_jobs/saved_job_page';
		$this->load->view('themes/layout', $data);
	}

	//---------------------------------------------------------------------
	// Save Jobs
	public function save_job()
	{
		if(!$this->session->userdata('is_user_login')){
			echo 'not_login';
			exit();
		}
			
		$data = array(
			'job_id' => $this->input->post('job_id'),
			'seeker_id' => $this->session->userdata('user_id'),
		);

		// if job is aleady saved
		$result = $this->myjob_model->is_already_saved($data);
		if($result) {
			echo 'already_saved';
			exit();
		}

		// save the job
		$result = $this->myjob_model->save_job($data);
		if($result){
			echo 'saved';
			exit();
		}
	}

	//-----------------------------------------------------------------
	// Delete Job
	public function delete($job_id)
	{
		$user_id = $this->session->userdata('user_id');

		$this->db->where('job_id',$job_id);
		$this->db->where('seeker_id',$user_id);
		$this->db->delete('xx_saved_jobs');

		echo $this->db->last_query();

		$this->session->set_flashdata('success','Congratulation! Job has been Deleted successfully');
		redirect(base_url('myjobs/saved'));
	}


}// endClass
