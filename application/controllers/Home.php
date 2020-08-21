<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('common_model');
		$this->load->model('profile_model');
		$this->load->library('mailer'); // load custom mailer library
	}

	//-----------------------------------------------------------------------------
	// Index funciton will call bydefault
	public function index()
	{	
		
		$data['countries'] = $this->common_model->get_countries_list();

		if(isset($_COOKIE['country_user']) and $_COOKIE['country_user'] != '') {
			
			$all_ads = $this->home_model->get_all_ads();

			foreach ($all_ads as $all_ad) {

				$status_date  = "";
				$date_min_10d = date("d-m-Y H:i:00",strtotime($all_ad['expiry_date']."- 5 days")); 
				$date_min_10d_str = strtotime($date_min_10d);
				$date_current_str = strtotime(date("d-m-Y H:i:00",time()));
				$date_expiry_str  = strtotime($all_ad['expiry_date']);
				$expiration_date  = $all_ad['expiration_date_reminder'];

				if($date_current_str > $date_min_10d_str && $expiration_date == 0) { 

					$info_user = $this->profile_model->get_user_by_id($all_ad['seller']);
					$to = $info_user['email'];

					$mail_data = array(
						'content' => 'Su anuncio <b>'. $all_ad['title'] .'</b> está proximó ha expirar.<br><br>
						Presione clic en <u><b><a href="'.base_url('seller/ads/change_status/reactivate/'.$all_ad['id']).'">renovar anuncio</a></u></b> para activar su anuncio por más tiempo.<br>
						Presione clic en <u><b><a href="'.base_url('seller/ads/change_status/sold/'.$all_ad['id']).'">anuncio vendido</a></u></b> para marcar su anuncio como vendido.',
					);

					$template = $this->mailer->mail_template($to,'general-notification',$mail_data);
					$this->home_model->change_status_reminder_expiration($all_ad['id'], '1');
				}

				if($date_current_str > $date_expiry_str) { $this->delete_ads_expired($all_ad['id']); }
			}

			$data['testimonials'] = $this->home_model->get_testimonials();
			$data['packages'] = $this->common_model->get_packages();
			$data['ads'] = $this->home_model->get_current_ads(6,0);
			$data['featured'] = $this->home_model->get_featured_ads(10,0);
			$data['hot'] = $this->home_model->get_hot_ads(5,0);
			$data['categories'] =  $this->home_model->get_home_page_categories();
			
			$data['title'] = trans('home');
			$data['layout'] = 'themes/home';
			$this->load->view('themes/layout', $data);

		} else {

			$data['title']     = trans('home');
			$data['layout']    = 'themes/init_home';
			$this->load->view('themes/layout', $data);
		}
	}

	// --------------------------------------------------------------------------
	// Add Subscriber 
	public function add_subscriber()
	{
		if ($this->input->post())
		{
			$this->form_validation->set_rules('email','email','trim|required|valid_email');

			if ($this->form_validation->run() == FALSE) {

				$response =  array('status' => 'error', 'msg' => strip_tags(validation_errors()));

				echo json_encode($response);
			}
			else
			{
				$data = array(
					'email' => $this->input->post('email'),
					'created_at' => date('Y-m-d h:i:s')
				);

				$this->home_model->add_subscriber($data);

				$this->session->set_flashdata('success_subscriber','Su correo electrónico se agregó correctamente!');
				$response =  array('status' => 'success', 'msg' => 'Su correo electrónico se agregó correctamente!');

				echo json_encode($response);
			}
		}
	}

	//  Dynamic Pages
	public function page($slug = '')
	{
		$data['body'] = $this->home_model->get_page_by_slug($slug);

		$data['title'] = $data['body']['title'];
		$data['layout'] = 'themes/blank_page';
		$this->load->view('themes/layout', $data);
	}

	//-----------------------------------------------------------------------------
	// Services Page
	public function services()
	{
		$data['title'] = trans('services');
		$data['layout'] = 'themes/services';
		$this->load->view('themes/layout', $data);
	}

	//-----------------------------------------------------------------------------
	// Contact Us Functionality
	public function contact()
	{
		if ($this->input->post('submit'))
		{
			$this->form_validation->set_rules('username','first name','trim|required|min_length[3]');
			$this->form_validation->set_rules('email','email','trim|required|min_length[3]');
			$this->form_validation->set_rules('subject','last name','trim|required|min_length[3]');
			$this->form_validation->set_rules('message','message','trim|required|min_length[3]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);

				$this->session->set_flashdata('error_send', $data['errors']);

				redirect(base_url('contact'),'refresh');
			}
			else
			{
				$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					'created_date' => date('Y-m-d : h:m:s'),
					'updated_date' => date('Y-m-d : h:m:s')
				);

				$data = $this->security->xss_clean($data); // XSS Clean Data

				$result = $this->home_model->contact($data);

				if ($result) 
				{

					// email code
					$this->load->helper('email_helper');

					$to = $this->general_settings['admin_email'];
					$subject = 'Contact Us | '.$this->general_settings['application_name'];
					$message =  '<p>Username: '.$data['username'].'</p> 
					<p>Email: '.$data['email'].'</p>
					<p>Message: '.$data['message'].'</p>' ;

					sendEmail($to, $subject, $message, $file = '' , $cc = '');

					$this->session->set_flashdata('success','<p class="alert alert-success"><strong>¡Éxito!</strong> su mensaje ha sido enviado con éxito!</p>');
					redirect(base_url('contact'), 'refresh');
				}
				else
				{
					redirect(base_url('contact'), 'refresh');
				}
			}
		}
		else
		{
			$data['title'] = trans('contact');
			$data['layout'] = 'themes/contact_us';
			$this->load->view('themes/layout', $data);
		}
	}

	//set site language
	public function set_site_language($lang_id)
	{
		$this->session->set_userdata("site_lang", $lang_id);
		redirect(base_url());
	}

    // -------------------------------------------
	// Error 404
	public function error_404()
	{
		$data['title'] = trans('404_error');
		$data['layout'] = 'themes/404';
		$this->load->view('themes/layout', $data);
	}

	/***********************
	 CRON JOBS
	 ***********************/
	 public function auto_post_expire_cj()
	 {
	 	$this->load->model('admin/employer_model', 'employer_model');

	 	$pending_jobs = $this->db->get_where('ci_ads',array('is_status !' => 2))->result_array();

	 	foreach ($pending_jobs as $job) 
	 	{
	 		$created  = date('Y-m-d H:i',strtotime(' + 20 minutes',strtotime($job['created_date'])));
	 		$now = date('Y-m-d H:i');

	 		if ($now >= $created) 
	 		{
	 			$this->db->where('id',$job['id']);
	 			$this->db->update('ci_ads',array('is_status' => 2));

	 			$emp_info = $this->employer_model->get_employer_by_id($job['employer_id']);
	 			$email = $emp_info['email'];
	 			$data['link'] = base_url('employers/auth/login');
	 			$data['message'] = 'Congratulation! Your job has been approved.';
	 			$subject = 'AAKD - Job Approved Notification';

	 			$mail_html = $this->load->view('admin/mails/general_notification',$data,true);

	 			sendEmail($emp['email'],$subject,$mail_html);

	 		}
	 	}
	 }

	 	// Delete Ad
	 public function delete_ads_expired($id=0)
	 {
	 	$user_id = $this->session->userdata('user_id');

	 	$data = $this->db->get_where('ci_ads',array('id' => $id,'seller' => $user_id))->row_array();

	 	if(!empty($data['img_1']))
	 		unlink($data['img_1']);

	 	if(!empty($data['img_2']))
	 		unlink($data['img_2']);

	 	if(!empty($data['img_3']))
	 		unlink($data['img_3']);

	 	if(!empty($data['video_1']))
	 		unlink($data['video_1']);

	 	if(!empty($data['video_2']))
	 		unlink($data['video_2']);

	 	if(!empty($data['video_3']))
	 		unlink($data['video_3']);

	 	$this->db->where('id',$id);
	 	$this->db->delete('ci_ads');
	 }
}// endClass
