<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_fields extends MY_Controller
{ 
	function __construct(){

		parent ::__construct();
		auth_check(); // check login auth
        $this->rbac->check_module_access();
		$this->load->model('admin/custom_fields_model', 'custom_fields_model');
	}

	/*-----------------------------//
	//	CUSTOM FIELDS    		  //
	//---------------------------*/

	//-----------------------------------------------------
	public function index()
	{
		$data['title'] = 'Campos Personalizados';

		$data['fields'] = $this->custom_fields_model->get_all_fields();

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/custom_fields/field-list', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------
	public function add()
	{
		if($this->input->post('submit')){

			$this->form_validation->set_rules('name', 'Fied Name', 'trim|is_unique[ci_fields.name]|required|alpha_numeric_spaces|min_length[3]');

			$this->form_validation->set_rules('type', 'Field Type', 'trim|required');

			$this->form_validation->set_rules('length', 'length', 'trim|required');

			$this->form_validation->set_rules('default', 'default', 'trim');

			if ($this->form_validation->run() == FALSE) {

				$data = array(
						'errors' => validation_errors()
					);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/custom_fields/add'),'refresh');
			}
			else{

				$slug = make_slug($this->input->post('name'));

				$data = array(
					'name' => ucwords($this->input->post('name')),
					'slug' => $slug,
					'type' => $this->input->post('type'),
					'length' => $this->input->post('length'),
					'default_value' => (empty($this->input->post('default'))) ? NULL : $this->input->post('default'),
					'required' => (empty($this->input->post('required'))) ? 0 : 1,
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->custom_fields_model->add_field($data);

				if(isset($_POST['options'])):

				for ($i = 0; $i < count($_POST['options']); $i++) { 

					$options = array(
						'name' => ucwords($this->input->post('options['.$i.']')),
						'parent_field' => $result,
					);

					$data = $this->security->xss_clean($options);

					$this->custom_fields_model->add_field_options($options);

				}
				endif;

				$this->session->set_flashdata('success','Campo personalizado ha sido agregado exitosamente');
				redirect(base_url('admin/custom_fields'),'refresh');
			}
		}
		else{

			$data['title'] = 'Agregar campos personalizados';
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/custom_fields/field_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function edit($id = 0)
	{
		if($this->input->post('submit')){

			$this->form_validation->set_rules('name', 'Fied Name', 'trim|required|alpha_numeric_spaces|min_length[3]');

			$this->form_validation->set_rules('type', 'Field Type', 'trim|required');

			$this->form_validation->set_rules('length', 'length', 'trim|required');

			$this->form_validation->set_rules('default', 'default', 'trim');

			if ($this->form_validation->run() === FALSE) {

				$data = array(
						'errors' => validation_errors()
					);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/custom_fields/edit/'.$id),'refresh');
			}
			else
			{
				$slug = make_slug($this->input->post('name'));

				$data = array(
					'name' => ucwords($this->input->post('name')),
					'slug' => $slug,
					'type' => $this->input->post('type'),
					'length' => $this->input->post('length'),
					'default_value' => (empty($this->input->post('default'))) ? NULL : $this->input->post('default'),
					'required' => (empty($this->input->post('required'))) ? 0 : 1,
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->custom_fields_model->edit_field($data, $id);


				// Update options
				$this->custom_fields_model->delete_field_options($id);

				if(isset($_POST['options'])):

				for ($i = 0; $i < count($_POST['options']); $i++) { 

					$options = array(
						'name' => ucwords($this->input->post('options['.$i.']')),
						'parent_field' => $id,
					);

					$data = $this->security->xss_clean($options);

					$this->custom_fields_model->add_field_options($options);

				}
				endif;

				$this->session->set_flashdata('success','Campo ha sido actualizado exitosamente');

				redirect(base_url('admin/custom_fields'),'refresh');
			}
		}
		else{

			$data['title'] = 'Actualizar campo personalizado';

			$data['field'] = $this->custom_fields_model->get_custom_field_by_id($id);

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/custom_fields/field_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function del($id = 0)
	{
		$this->db->delete('ci_fields', array('id' => $id));

		$this->session->set_flashdata('success', 'Campo ha sido eliminado exitosamente!');

		redirect(base_url('admin/custom_fields'));
	}

	//--------------------------------------
	// add to category

	public function add_to_category($field_id = 0)
	{
		if($this->input->post('submit')){

			$this->form_validation->set_rules('category', 'Category', 'trim|required');

			$this->form_validation->set_rules('subcategory', 'subcategory', 'trim');

			if ($this->form_validation->run() == FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/custom_fields/'),'refresh');
			}
			else{

				$data = array(
					'category' => $this->input->post('category'),
					'subcategory' => (!empty($this->input->post('subcategory'))) ? $this->input->post('subcategory') : NULL,
					'field' => $field_id,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->custom_fields_model->add_field_to_category($data);

				$this->session->set_flashdata('success','Campo ha sido agregado exitosamente');

				redirect(base_url('admin/custom_fields/'),'refresh');
			}
		}
		else{

			$data['field'] = $this->custom_fields_model->get_field_by_id($field_id);
			
			$data['title'] = 'Add '.$data['field']['name'].' campo a categoría';

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/custom_fields/add_to_category', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

}
?>