<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends MY_Controller
{
	function __construct()
	{
		parent ::__construct();
		auth_check(); // check login auth
        $this->rbac->check_module_access();
		$this->load->model('admin/misc_model', 'misc_model');
	}

	public function index()
	{
		redirect('admin/misc/country');
	}

	// ---------------------------------------------------
	//                     COUNTRY
	//-----------------------------------------------------
	public function country()
	{
		$data['title'] = 'Country List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/country_list');
		$this->load->view('admin/includes/_footer');
	}

	public function country_datatable_json(){				   					   
		$records['data'] = $this->misc_model->get_all_countries();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['status']) ? 'Active' : 'Inactive';
			$data[]= array(
				++$i,
				$row['name'],
				'<button type="button" class="btn btn-success">'.$status.'</button>',		
				'<a title="Delete" class="btn-delete btn btn-danger pull-right " href="'.base_url('admin/misc/country/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a>
	            <a title="Edit" class="update btn btn-warning pull-right" href="'.base_url('admin/misc/country/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function country_add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('country', 'country', 'trim|is_unique[ci_countries.name]|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/country/add'),'refresh');
			}

			$slug = make_slug($this->input->post('country'));
			$data = array(
				'name' => ucfirst($this->input->post('country')),
				'slug' => $slug
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->add_country($data);
			$this->session->set_flashdata('success','El país ha sido agregado exitosamente');
			redirect(base_url('admin/misc/country'));
		}
		else{
			$data['title'] = 'Agregar país';
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/country_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function country_edit($id=0)
	{

		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			if ($this->form_validation->run() === FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/country/edit/'.$id),'refresh');				
			}

			$slug = make_slug($this->input->post('country'));
			$data = array(
				'name' => ucfirst($this->input->post('country')),
				'status' => $this->input->post('status'),
				'slug' => $slug
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->edit_country($data, $id);
			$this->session->set_flashdata('success','El país ha sido actualizado exitosamente');
			redirect(base_url('admin/misc/country'));
		}
		else{
			$data['title'] = 'Actualizar país';
			$data['country'] = $this->misc_model->get_country_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/country_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function country_del($id = 0)
	{
		$this->db->delete('ci_countries', array('id' => $id));
		$this->session->set_flashdata('success', 'El país ha sido eliminado exitosamente!');
		redirect(base_url('admin/misc/country'));
	}

	// ---------------------------------------------------
	//                     STATE
	//-----------------------------------------------------

	function state()
	{
		$data['title'] = 'State List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/state_list', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function state_datatable_json(){				   					   
		$records['data'] = $this->misc_model->get_all_states();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				++$i,
				get_country_name($row['country_id']),
				$row['name'],
				'<a title="Delete" class="btn-delete btn btn-danger pull-right" href="'.base_url('admin/misc/state/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a>
            	<a title="Edit" class="update btn btn-warning pull-right" href="'.base_url('admin/misc/state/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data'] = $data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function state_add()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|is_unique[ci_states.name]|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/state/add'),'refresh');	
			}

			$slug = make_slug($this->input->post('state'));
			$data = array(
				'name' => ucfirst($this->input->post('state')),
				'slug' => $slug,
				'country_id' => $this->input->post('country'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->add_state($data);
			$this->session->set_flashdata('success','El estado ha sido agregado exitosamente');
			redirect(base_url('admin/misc/state'));
		}
		else{
			$data['countries'] = $this->misc_model->get_all_countries(); 
			$data['title'] = 'Agregar estado';
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/state_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function state_edit($id=0)
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/state/edit/'.$id),'refresh');	
			}

			$slug = make_slug($this->input->post('state'));
			$data = array(
				'name' => ucfirst($this->input->post('state')),
				'slug' => $slug,
				'country_id' => $this->input->post('country'),
			);
			
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->edit_state($data, $id);
			$this->session->set_flashdata('success','El estado ha sido actualizado exitosamente');
			redirect(base_url('admin/misc/state'));
		}
		else{
			$data['title'] = 'Actualizar estado';
			$data['countries'] = $this->misc_model->get_all_countries(); 
			$data['state'] = $this->misc_model->get_state_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/state_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function state_del($id = 0)
	{
		$this->db->delete('ci_states', array('id' => $id));
		$this->session->set_flashdata('success', 'El estado ha sido eliminado exitosamente!');
		redirect(base_url('admin/misc/state'));
	}

	// ---------------------------------------------------
	//                     CITY
	//-----------------------------------------------------

	function city()
	{
		$data['title'] = 'Lista de ciudades';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/city_list');
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------
	public function city_datatable_json(){

		$records['data'] = $this->misc_model->get_all_cities();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				++$i,
				get_state_name($row['state_id']),
				$row['name'],
				'<a title="Delete" class="btn-delete btn btn-danger pull-right" href="'.base_url('admin/misc/city/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a>
            	<a title="Edit" class="update btn btn-warning pull-right" href="'.base_url('admin/misc/city/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data'] = $data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function city_add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('city', 'city', 'trim|is_unique[ci_cities.name]|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/city/add'),'refresh');	
			}

			$slug = make_slug($this->input->post('city'));
			$data = array(
				'name' => ucfirst($this->input->post('city')),
				'slug' => $slug,
				'state_id' => $this->input->post('state'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->add_city($data);
			$this->session->set_flashdata('success','La ciudad ha sido agregada exitosamente');
			redirect(base_url('admin/misc/city'));
		}
		else{
			$data['title'] = 'Añadir ciudad';
			$data['states'] = $this->misc_model->get_all_states();
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/city_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function city_edit($id=0)
	{
		if($this->input->post()){
			$this->form_validation->set_rules('city', 'city', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/city/edit/'.$id),'refresh');	
			}

			$slug = make_slug($this->input->post('city'));
			$data = array(
				'name' => ucfirst($this->input->post('city')),
				'slug' => $slug,
				'state_id' => $this->input->post('state'),
			);
			
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->edit_city($data, $id);
			$this->session->set_flashdata('success','La ciudad ha sido actualizada exitosamente');
			redirect(base_url('admin/misc/city'));
		}
		else{
			$data['title'] = 'Actualizar ciudad';
			$data['states'] = $this->misc_model->get_all_states();
			$data['city'] = $this->misc_model->get_city_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/city_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function city_del($id = 0)
	{
		$this->db->delete('ci_cities', array('id' => $id));
		$this->session->set_flashdata('success', 'La ciudad ha sido eliminada exitosamente!');
		redirect(base_url('admin/misc/city'));
	}

	// ---------------------------------------------------
	//                     CURRENCY
	//-----------------------------------------------------
	public function currency()
	{
		$data['title'] = 'Lista de divisas';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/currency_list');
		$this->load->view('admin/includes/_footer');
	}

	public function currency_datatable_json(){				   					   
		$records['data'] = $this->misc_model->get_all_currencies();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				++$i,
				$row['name'],
				$row['code'],
				$row['symbol'],
				'<a title="Delete" class="btn-delete btn btn-danger pull-right " href="'.base_url('admin/misc/currency/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a> &nbsp;
	            <a title="Edit" class="update btn btn-warning pull-right" href="'.base_url('admin/misc/currency/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function currency_add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('currency', 'currency name', 'trim|is_unique[ci_currency.name]|required');
			$this->form_validation->set_rules('code', 'Code', 'trim|is_unique[ci_currency.code]|required');
			$this->form_validation->set_rules('symbol', 'Symbol', 'trim|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/currency/add'),'refresh');
			}

			$data = array(
				'name' => ucfirst($this->input->post('currency')),
				'code' => $this->input->post('code'),
				'symbol' => $this->input->post('symbol'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->add_currency($data);
			$this->session->set_flashdata('success','La moneda se ha agregado con éxito');
			redirect(base_url('admin/misc/currency'));
		}
		else{
			$data['title'] = 'Agregar moneda';
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/currency_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function currency_edit($id=0)
	{

		if($this->input->post()){
			$this->form_validation->set_rules('currency', 'currency name', 'trim|required');
			$this->form_validation->set_rules('code', 'Code', 'trim|required');
			$this->form_validation->set_rules('symbol', 'Symbol', 'trim|required');			
			if ($this->form_validation->run() === FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/currency/edit/'.$id),'refresh');				
			}

			$data = array(
				'name' => ucfirst($this->input->post('currency')),
				'code' => $this->input->post('code'),
				'symbol' => $this->input->post('symbol'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->edit_currency($data, $id);
			$this->session->set_flashdata('success','La moneda se ha actualizada con éxito');
			redirect(base_url('admin/misc/currency'));
		}
		else{
			$data['title'] = 'Actualizar moneda';
			$data['currency'] = $this->misc_model->get_currency_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/currency_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function currency_del($id = 0)
	{
		$this->db->delete('ci_currency', array('id' => $id));
		$this->session->set_flashdata('success', 'La moneda se ha eliminada con éxito!');
		redirect(base_url('admin/misc/currency'));
	}

	// ---------------------------------------------------
	//                     LANGUAGE
	//-----------------------------------------------------
	public function language()
	{
		$data['title'] = 'Lista de idiomas';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/language_list');
		$this->load->view('admin/includes/_footer');
	}

	public function language_datatable_json(){				   					   
		$records['data'] = $this->misc_model->get_all_languages();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{ 
			$status = ($row['status']) ? 'Active' : 'Inactive';

			$data[] = array(
				++$i,
				$row['name'],
				$row['short_form'],
				$row['code'],
				'<button type="button" class="btn btn-success">'.$status.'</button>',
				'<a title="Delete" class="btn-delete btn btn-danger pull-right " href="'.base_url('admin/misc/language/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a> &nbsp;
	            <a title="Edit" class="update btn btn-warning pull-right" href="'.base_url('admin/misc/language/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function language_add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('language', 'language name', 'trim|is_unique[ci_language.name]|required');
			$this->form_validation->set_rules('short_form', 'Short Form', 'trim|is_unique[ci_language.short_form]|required');
			$this->form_validation->set_rules('code', 'Code', 'trim|is_unique[ci_language.code]|required');
			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/language/add'),'refresh');
			}

			$data = array(
				'name' => ucfirst($this->input->post('language')),
				'code' => $this->input->post('code'),
				'short_form' => $this->input->post('short_form'),
				'status' => $this->input->post('status'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->add_language($data);
			$this->session->set_flashdata('success','El idioma ha sido agregado exitosamente');
			redirect(base_url('admin/misc/language'));
		}
		else{
			$data['title'] = 'Agregar idioma';
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/language_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function language_edit($id=0)
	{

		if($this->input->post()){
			$this->form_validation->set_rules('language', 'language name', 'trim|required');
			$this->form_validation->set_rules('short_form', 'Short Form', 'trim|required');
			$this->form_validation->set_rules('code', 'Code', 'trim|required');		
			if ($this->form_validation->run() === FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/misc/language/edit/'.$id),'refresh');				
			}

			$data = array(
				'name' => ucfirst($this->input->post('language')),
				'code' => $this->input->post('code'),
				'short_form' => $this->input->post('short_form'),
				'status' => $this->input->post('status'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->misc_model->edit_language($data, $id);
			$this->session->set_flashdata('success','El idioma ha sido actualizado exitosamente');
			redirect(base_url('admin/misc/language'));
		}
		else{
			$data['title'] = 'Actualizar idioma';
			$data['language'] = $this->misc_model->get_language_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/misc/language_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function language_del($id = 0)
	{
		$this->db->delete('ci_language', array('id' => $id));
		$this->session->set_flashdata('success', 'El idioma ha sido eliminado exitosamente!');
		redirect(base_url('admin/misc/language'));
	}
	
		// Contact Form
	public function contact()
	{
		$data['title'] = 'Contacto';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/misc/contact_list', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function contact_datatable_json()
	{
		$records['data'] = $this->misc_model->get_contact_form_details();
		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{ 
		    update_admin_view_status('ci_contact_us',$row['id']);
			$data[] = array(
				++$i,
				$row['username'],
				$row['email'],
				$row['subject'],
				$row['message'],
				'<a title="Delete" class="btn-delete btn btn-danger pull-right " href="'.base_url('admin/contact/del/'.$row['id']).'" > <i class="fa fa-remove"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	function contact_del($id = 0)
	{
		$this->db->delete('ci_contact_us', array('id' => $id));
		$this->session->set_flashdata('success', 'El detalle de contacto se ha eliminado con éxito!');
		redirect(base_url('admin/contact'));
	}

}
?>