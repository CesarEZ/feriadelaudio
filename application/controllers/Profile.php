<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->model('common_model');
		
		if(!$this->session->userdata('user_id'))
		{
		    redirect(base_url());
		}
	}

	//-----------------------------------------------------------------------------------
	// Update User Profile 
	public function index()
	{		
		$user_id = $this->session->userdata('user_id');

		if ($this->input->post())
		{
			//validate inputs
			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[3]');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[3]');
			$this->form_validation->set_rules('email','email','trim|required|min_length[5]|valid_email');
			$this->form_validation->set_rules('contact','Contact Number','trim|required|min_length[7]');
			$this->form_validation->set_rules('country','Country','trim|required');
			$this->form_validation->set_rules('state','State','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('address','Address','trim|required|min_length[3]');
			
			if ($this->form_validation->run() == FALSE) 
			{

				$response =  array('status' => 'error', 'msg' => strip_tags(validation_errors()));

				echo json_encode($response);

				exit();

			}
			else
			{

				// agreement
				if(!empty($_FILES['profile_picture']['name']))
				{
					$path = 'assets/uploads/';
					$this->functions->delete_file($this->input->post('old_profile_picture'));
					$result = $this->functions->file_insert($path, 'profile_picture', 'image', '90000');

					if($result['status'] == 1)
					{

						$data['profile_picture'] = $path.$result['msg'];
					}
					else
					{

						$response =  array('status' => 'error', 'msg' => $result['msg']);

						echo json_encode($response);

						exit();
					}
				}

				$data = array(
					'firstname' => $this->input->post('firstname'), 
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'contact' => $this->input->post('contact'), 
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'address' => $this->input->post('address'),
					'profile_picture' => (isset($data['profile_picture'])) ? $data['profile_picture'] : NULL,
					'updated_date' => date('Y-m-d : h:m:s')
				);


				$data = $this->security->xss_clean($data); // XSS Clean

				$this->profile_model->update_user($data,$user_id);

				$response =  array('status' => 'success', 'msg' => "El perfil ha sido actualizado exitosamente");

				echo json_encode($response);

				exit();

			}
		}
		else
		{
			$data['countries'] = $this->common_model->get_countries_list(); 
			$data['user_info'] = $this->profile_model->get_user_by_id($user_id);
			$data['title'] = 'Perfil';
			$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
			$data['layout'] = 'themes/user/profile/user_profile_page';
			$this->load->view('themes/layout', $data);

		}
	}

	//-------------------------------------------------------------------------------
	public function change_password()
	{	
		if ($this->input->post()) {

			$user_id = $this->session->userdata('user_id');

			$this->form_validation->set_rules('current_password','current password','trim|required|min_length[3]');
			$this->form_validation->set_rules('new_password','new password','trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password','Confirmar contraseña','trim|required|min_length[5]|matches[new_password]');

			if ($this->form_validation->run() == FALSE) {
				
				$response =  array('status' => 'error', 'msg' => strip_tags(validation_errors()));

				echo json_encode($response);

				exit();

			}else{
				
				$data = array(
					'id' => $user_id,
					'current_password' => $this->input->post('current_password'),
					'password' => password_hash($this->input->post('new_password'), PASSWORD_BCRYPT),
				);

				$result = $this->profile_model->update_password($data,$user_id);
				
				if($result) {
					
					$response =  array('status' => 'success', 'msg' => 'La contraseña ha sido actualizada exitosamente');

					
				}else{

					$response =  array('status' => 'error', 'msg' => 'La contraseña actual es incorrecta');

				}

				echo json_encode($response);

				exit();
			}
		}
		else{
			
			$data['title'] = 'Cambia la contraseña';
			$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
			$data['layout'] = 'themes/user/profile/change_password';
			$this->load->view('themes/layout', $data);
		}
	}

	//-----------------------------------------------------------------------------------
	public function favourite()
	{
		$user_id = $this->session->user_id;

		$data['user_info'] = $this->profile_model->get_user_by_id($user_id);
		$data['favourites'] = $this->profile_model->get_user_favourites($user_id);

		$data['title'] = 'Publicaciones favoritas';
		$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
		$data['layout'] = 'themes/user/favourite/list';
		$this->load->view('themes/layout', $data);
	}

	//-----------------------------------------------------------------------------------
	public function ads()
	{
		$user_id = $this->session->user_id;

		$data['user_info'] = $this->profile_model->get_user_by_id($user_id);
		$data['ads'] = $this->profile_model->get_user_ads_by_id($user_id);

		$data['title'] = 'Administrar anuncios';
		$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
		$data['layout'] = 'themes/user/my_ads/ads_list_page';
		$this->load->view('themes/layout', $data);
	}

	// --------------------------------------
	public function notifications()
	{
		$user_id = $this->session->user_id;
		$data['notifications'] = $this->profile_model->get_user_notifications($user_id);
		$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
		$data['title'] = 'Notifications';
		$data['layout'] = 'themes/user/notifications/notifications-list';
		$this->load->view('themes/layout', $data);
	}
	
	// --------------------------------------
	public function invoices()
	{
		$user_id = $this->session->user_id;
		$data['invoices'] = $this->profile_model->get_user_invoices($user_id);
		$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user
		$data['title'] = 'Facturas';
		$data['layout'] = 'themes/user/invoices/invoices-list';
		$this->load->view('themes/layout', $data);
	}

	public function mark_viewed_notification()
	{
		if($this->input->post())
		{
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'id' => $this->input->post('notification_id')
			);

			$this->db->where($data);
			$this->db->update('ci_notifications',array('user_view' => 1));
			echo "true";

		}
	}

}