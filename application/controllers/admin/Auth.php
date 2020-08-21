<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('admin/auth_model', 'auth_model');
	}

	//--------------------------------------------------------------
	public function index(){
		if($this->session->has_userdata('is_admin_login')){
			redirect('admin/dashboard');
		}
		else{
			redirect('admin/auth/login');
		}
	}

	//--------------------------------------------------------------
	public function login(){
		if($this->input->post('submit'))
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/auth/login'),'refresh');
			}
			else {
				$data = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password')
				);
				$result = $this->auth_model->login($data);
				if($result){
					if($result['is_verify'] == 0){
						$this->session->set_flashdata('error', 'Por favor verifica tu email!');
						redirect(base_url('admin/auth/login'));
						exit();
					}
					if($result['is_active'] == 0){
						$this->session->set_flashdata('error', 'La cuenta está deshabilitada por el administrador!');
						redirect(base_url('admin/auth/login'));
						exit();
					}
					if($result['is_admin'] == 1){
						$admin_data = array(
							'admin_id' => $result['admin_id'],
							'username' => $result['username'],
							'admin_role_id' => $result['admin_role_id'],
							'admin_role' => $result['admin_role_title'],
							'is_supper' => $result['is_supper'],
							'is_admin_login' => TRUE
						);
						$this->session->set_userdata($admin_data);
						$this->rbac->set_access_in_session(); // set access in session
						redirect(base_url('admin/dashboard'), 'refresh');
						}
					}
					else{
						$this->session->set_flashdata('errors', 'Usuario o contraseña invalido!');
						redirect(base_url('admin/auth/login'));
					}
			}
		}
		else
		{
			$data['title'] = 'Iniciar sesión';
			$data['navbar'] = false;
			$data['sidebar'] = false;
			$data['footer'] = false;

			$this->load->view('admin/includes/_header', $data);
			$this->load->view('admin/auth/login');
			$this->load->view('admin/includes/_footer', $data);
		}
	}	

	//-------------------------------------------------------------------------
	public function register(){

		if($this->input->post('submit')){

			// for google recaptcha
			if ($this->recaptcha_status == true) {
	            if (!$this->recaptcha_verify_request()) {
	                $this->session->set_flashdata('form_data', $this->input->post());
	                $this->session->set_flashdata('error', 'reCaptcha Error');
	                redirect(base_url('admin/auth/register'));
	                exit();
	            }
	        }
        
			$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|is_unique[ci_admin.username]|required');
			$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[ci_admin.email]|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('form_data', $this->input->post());
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/auth/register'),'refresh');
			}
			else{
				$data = array(
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'admin_role_id' => 2, // By default i putt role is 2 for registraiton
					'email' => $this->input->post('email'),
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'is_active' => 1,
					'is_verify' => 0,
					'token' => md5(rand(0,1000)),    
					'last_ip' => '',
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->auth_model->register($data);
				if($result){
					//sending welcome email to user
					$this->load->helper('email_helper');

					$name = $data['firstname'].' '.$data['lastname'];
					$email_verification_link = base_url('admin/auth/verify/').'/'.$data['token'];
					$body = $this->mailer->registration_email($name, $email_verification_link);
					$to = $data['email'];
					$subject = 'Activate your account';
					$message =  $body ;

					$email = send_email($to, $subject, $message, $file = '' , $cc = '');

					if($email){
						$this->session->set_flashdata('success', 'Se ha creado su cuenta, verifíquela haciendo clic en el enlace de activación que se envió a su correo electrónico.');	
						redirect(base_url('admin/auth/login'));
					}	
					else{
						echo 'Email Error';
					}
				}
			}
		}
		else{
			$data['title'] = 'Crear una cuenta';
			$data['navbar'] = false;
			$data['sidebar'] = false;
			$data['footer'] = false;

			$this->load->view('admin/includes/_header', $data);
			$this->load->view('admin/auth/register');
			$this->load->view('admin/includes/_footer', $data);
		}
	}

	//----------------------------------------------------------	
	public function verify(){

		$verification_id = $this->uri->segment(4);
		$result = $this->auth_model->email_verification($verification_id);
		if($result){
			$this->session->set_flashdata('success', 'Su correo electrónico ha sido verificado, ahora puede iniciar sesión.');
			redirect(base_url('admin/auth/login'));
		}
		else{
			$this->session->set_flashdata('success', 'La URL no es válida o ya ha activado su cuenta.');	
			redirect(base_url('admin/auth/login'));
		}	
	}

	//--------------------------------------------------		
	public function forgot_password(){

		if($this->input->post('submit')){
			//checking server side validation
			$this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/auth/forget_password'),'refresh');
			}

			$email = $this->input->post('email');
			$response = $this->auth_model->check_user_mail($email);

			if($response){

				$rand_no = rand(0,1000);
				$pwd_reset_code = md5($rand_no.$response['admin_id']);
				$this->auth_model->update_reset_code($pwd_reset_code, $response['admin_id']);
				
				// --- sending email
				$this->load->helper('email_helper');
				$name = $response['firstname'].' '.$response['lastname'];
				$email = $response['email'];
				$reset_link = base_url('admin/auth/reset_password/'.$pwd_reset_code);
				$body = $this->mailer->pwd_reset_email($name,$reset_link);
				$to = $email;
				$subject = 'Reset your password';
				$message =  $body ;
				$email = send_email($to, $subject, $message, $file = '' , $cc = '');

				if($email){
					$this->session->set_flashdata('success', 'Hemos enviado instrucciones para restablecer su contraseña a su correo electrónico');

					redirect(base_url('admin/auth/forgot_password'));
				}
				else{
					$this->session->set_flashdata('error', 'Hay un problema en tu correo electrónico');
					redirect(base_url('admin/auth/forgot_password'));
				}
			}
			else{
				$this->session->set_flashdata('error', 'El correo electrónico que proporcionó no es válido');
				redirect(base_url('admin/auth/forgot_password'));
			}
		}
		else{

			$data['title'] = 'Contraseña olvidada';
			$data['navbar'] = false;
			$data['sidebar'] = false;
			$data['footer'] = false;

			$this->load->view('admin/includes/_header', $data);
			$this->load->view('admin/auth/forget_password');
			$this->load->view('admin/includes/_footer', $data);
		}
	}

	//----------------------------------------------------------------		
	public function reset_password($id=0){

		// check the activation code in database
		if($this->input->post('submit')){
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);

				$this->session->set_flashdata('reset_code', $id);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}

			else{
				$new_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				$this->auth_model->reset_password($id, $new_password);
				$this->session->set_flashdata('success','La nueva contraseña se ha actualizado correctamente. Inicie sesión a continuación');
				redirect(base_url('admin/auth/login'));
			}
		}
		else{
			$result = $this->auth_model->check_password_reset_code($id);

			if($result){

				$data['title'] = 'Restablecer la contraseña';
				$data['reset_code'] = $id;
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;

				$this->load->view('admin/includes/_header', $data);
				$this->load->view('admin/auth/reset_password');
				$this->load->view('admin/includes/_footer', $data);

			}
			else{
				$this->session->set_flashdata('error','El código de restablecimiento de contraseña no es válido o ha caducado.');
				redirect(base_url('admin/auth/forgot_password'));
			}
		}
	}

	//-----------------------------------------------------------------------
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('admin/auth/login'), 'refresh');
	}

}  // end class

?>