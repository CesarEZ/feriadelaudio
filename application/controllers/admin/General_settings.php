<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		$this->load->model('admin/setting_model', 'setting_model');
	}

	/*----------------------
		General Settings
	-----------------------*/

	//-------------------------------------------------------------------------
	// General Setting View
	public function index()
	{
		
		$data['general_settings'] = $this->setting_model->get_general_settings();

		$data['footer_settings'] = $this->setting_model->get_footer_settings();

		$data['title'] = 'General Setting';

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/setting', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-------------------------------------------------------------------------
	// Add General Setting
	public function add()
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		$data = array(
			'application_name' => $this->input->post('application_name'),
			'description' => $this->input->post('description'),
			'timezone' => $this->input->post('timezone'),
			'currency' => $this->input->post('currency'),
			'language' => $this->input->post('language'),
			'copyright' => $this->input->post('copyright'),
			'admin_email' => $this->input->post('admin_email'),
			'email_from' => $this->input->post('email_from'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			'facebook_link' => $this->input->post('facebook_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'google_link' => $this->input->post('google_link'),
			'youtube_link' => $this->input->post('youtube_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key'),
			'recaptcha_site_key' => $this->input->post('recaptcha_site_key'),
			'map_api_key' => $this->input->post('map_api_key'),
			'terms_and_conditions' => $this->input->post('terms_and_conditions'),
			'recaptcha_lang' => $this->input->post('recaptcha_lang'),
			'created_date' => date('Y-m-d : h:m:s'),
			'updated_date' => date('Y-m-d : h:m:s'),
		);

		$old_logo = $this->input->post('old_logo');
		$old_favicon = $this->input->post('old_favicon');

		$path="assets/img/";

		if(!empty($_FILES['logo']['name']))
		{
			$this->functions->delete_file($old_logo);

			$result = $this->functions->file_insert($path, 'logo', 'image', '9097152');
			if($result['status'] == 1){
				$data['logo'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		// favicon
		if(!empty($_FILES['favicon']['name']))
		{
			$this->functions->delete_file($old_favicon);

			$result = $this->functions->file_insert($path, 'favicon', 'image', '197152');
			if($result['status'] == 1){
				$data['favicon'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		$data = $this->security->xss_clean($data);
		$result = $this->setting_model->update_general_setting($data);

		if($result){
			// Footer Settings
			$footer_result = $this->add_footer_widget();
		}

		if($footer_result){
			$this->session->set_flashdata('success', 'La configuración se ha cambiado correctamente!');
			redirect(base_url('admin/general_settings'), 'refresh');
		}
	}

	//-------------------------------------------------------------------------
	// Add footer widget
	public function add_footer_widget()
	{
		$this->form_validation->set_rules('widget_field_title[]', 'Título del widget de pie de página', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('widget_field_content[]', 'Contenido del widget de pie de página', 'trim|required|min_length[3]');
		
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'errors' => validation_errors()
			);
			$this->session->set_flashdata('error', $data['errors']);
			redirect(base_url('admin/general_settings'),'refresh');
		}
		else
		{
			$total_widgets = count($this->input->post('widget_field_title[]'));

			$this->setting_model->delete_footer_all_setting();

			for ($i=0; $i < $total_widgets; $i++) { 
				$data = array(
					'title' => $this->input->post('widget_field_title['.$i.']'),
					'grid_column' => $this->input->post('widget_field_column['.$i.']'),
					'content' => $this->input->post('widget_field_content['.$i.']'),
				);
				$data = $this->security->xss_clean($data);
				$this->setting_model->update_footer_setting($data);
			}
			return true;
		}
	}

	
	/*----------------------
		User Menu Settings
	-----------------------*/

	//-----------------------------------------------------------
	public function user_menu()
	{
		$data['records'] = $this->setting_model->get_all_user_menu();
		$data['title'] = 'User Menu Setting';

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/user_menu/menu_list', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------------
	public function menu_add(){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
			$this->form_validation->set_rules('operation', 'Link', 'trim');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/general_settings/menu_add'),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('menu_name'),
					'link' => $this->input->post('operation'),
					'sort_order' => $this->input->post('sort_order'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->add_menu($data);
				if($result){
					$this->session->set_flashdata('success', 'El menú ha sido agregado exitosamente!');
					redirect(base_url('admin/general_settings/user_menu'));
				}
			}
		}
		else{

			$data['title'] = '';

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/user_menu/menu_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function menu_edit($id=0){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
			$this->form_validation->set_rules('operation', 'Link', 'trim');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/general_settings/menu_edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'name' => $this->input->post('menu_name'),
					'link' => $this->input->post('operation'),
					'active' => $this->input->post('status'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->edit_menu($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'El menú ha sido actualizado exitosamente!');
					redirect(base_url('admin/general_settings/user_menu'));
				}
			}
		}
		else{
			$data['title'] = '';
			$data['module'] = $this->setting_model->get_menu_by_id($id);

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/user_menu/menu_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//------------------------------------------------------------
	public function menu_delete($id=''){

		$this->rbac->check_operation_access(); // check opration permission

		$this->setting_model->delete_menu($id);

		$this->session->set_flashdata('success','El menú ha sido eliminado exitosamente.');	
		redirect('admin/general_settings/user_menu');
	}

	/*---------------------------
		User Sub Menu Settings
	---------------------------*/

	//-----------------------------------------------------------
	public function sub_menu($menu_id = NULL){

		$data['title'] = '';
		$data['records'] = $this->setting_model->get_sub_menu_by_menu($menu_id);

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/user_menu/sub_menu_list', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------------
	public function sub_menu_add(){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('module_name', 'Sub Menu Name', 'trim|required');
			$this->form_validation->set_rules('operation', 'Link', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim');
			$this->form_validation->set_rules('parent_menu', 'Parent menu', 'trim|required');
			// Parent Module
			$parent = $this->input->post('parent_menu');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/general_settings/sub_menu_add/'.$parent),'refresh');
			}
			else{
				$data = array(
					'parent' => $parent,
					'name' => $this->input->post('module_name'),
					'link' => $this->input->post('operation'),
					'sort_order' => $this->input->post('sort_order'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->add_sub_menu($data);
				if($result){
					$this->session->set_flashdata('success', 'El submenú ha sido agregado exitosamente!');
					redirect(base_url('admin/general_settings/sub_menu/'.$parent));
				}
			}
		}
		else{
			$data['title'] = '';

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/user_menu/sub_menu_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	// -----------------------------------------------------------
	public function sub_menu_edit($id = 0){

		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('module_name', 'module Name', 'trim|required');
			$this->form_validation->set_rules('sub_menu_name', 'sub_menu Name', 'trim|required');
			$this->form_validation->set_rules('operation', 'Operation', 'trim');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/general_settings/sub_menu_edit/'.$id),'refresh');
			}
			else{
				$parent = $this->input->post('module_name');

				$data = array(
					'parent' => $parent,
					'name' => $this->input->post('sub_menu_name'),
					'link' => $this->input->post('operation'),
					'sort_order' => $this->input->post('sort_order'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->edit_sub_menu($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'El submenú ha sido actualizado exitosamente!');
					redirect(base_url('admin/general_settings/sub_menu/'.$parent));
				}
			}
		}
		else{
			$data['title'] = '';
			$data['module'] = $this->setting_model->get_sub_menu_by_id($id);
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/user_menu/sub_menu_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	// ------------------------------------------------------------
	public function sub_menu_delete($id = 0,$parent = 0){

		$this->rbac->check_operation_access(); // check opration permission

		$this->setting_model->delete_sub_menu($id);

		$this->session->set_flashdata('msg','El submenú ha sido eliminado exitosamente.');	
		redirect('admin/general_settings/sub_menu/'.$parent);
	}

	/*--------------------------
	   Email Template Settings
	--------------------------*/

	// ------------------------------------------------------------
	public function email_templates()
	{
		$this->rbac->check_operation_access(); // check opration permission
		if($this->input->post()){
			$this->form_validation->set_rules('subject', 'Email Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Email Body', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{

				$id = $this->input->post('id');
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('content'),
					'last_update' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->setting_model->update_email_template($data, $id);
				if($result){
					echo "true";
				}
			}
		}
		else
		{
			$data['title'] = '';
			$data['templates'] = $this->setting_model->get_email_templates();

			$this->load->view('admin/includes/_header');
			$this->parser->parse('admin/general_settings/email_templates/templates_list', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	// ------------------------------------------------------------
	// Get Email Template & Related variables via Ajax by ID
	public function get_email_template_content_by_id()
	{
		$id = $this->input->post('template_id');

		$data['template'] = $this->setting_model->get_email_template_content_by_id($id);
		
		$variables = $this->setting_model->get_email_template_variables_by_id($id);

		$data['variables'] = implode(',',array_column($variables, 'variable_name'));

		echo json_encode($data);
	}

	//---------------------------------------------------------------
    //
    public function email_preview()
    {
        if($this->input->post('content'))
        {
            $data['content'] = $this->input->post('content');
            $data['head'] = $this->input->post('head');
            $data['title'] = 'Send Email to Subscribers';
            echo $this->load->view('admin/general_settings/email_templates/email_preview', $data,true);
        }
    }

	/*----------------------
		Payment Settings
	-----------------------*/

	// ------------------------------------------------------------
	public function payments()
	{
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('publishable_key', 'Publishable Key', 'trim');
			$this->form_validation->set_rules('secret_key', 'Secret Key', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/general_settings/payments/'),'refresh');
			}
			else{

				// STRIPE PAYMENT
				$stripe_data = array(
					'publishable_key' => $this->input->post('publishable_key'),
					'secrate_key' => $this->input->post('secret_key'),
					'stripe_status' => $this->input->post('stripe_status'),
					'updated_date' => date('Y-m-d H:i:s'),
				);
				$stripe_data = $this->security->xss_clean($stripe_data);
				$this->setting_model->update_stripe_settings($stripe_data);

				$this->session->set_flashdata('success', 'Configuración de pago actualizada correctamente');
				redirect(base_url('admin/general_settings/payments/'),'refresh');
			}
		}
		else
		{
			$data['stripe'] = $this->setting_model->get_stripe_settings();

			$data['title'] = 'Configuración de pago';

			$this->load->view('admin/includes/_header', $data);
			$this->load->view('admin/general_settings/payments/setting', $data);
			$this->load->view('admin/includes/_footer');
		}
	}
}

?>	