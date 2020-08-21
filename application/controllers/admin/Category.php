<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller
{ 
	function __construct(){

		parent ::__construct();
		auth_check(); // check login auth
        $this->rbac->check_module_access();
		$this->load->model('admin/category_model', 'category_model');
		$this->load->model('admin/custom_fields_model', 'custom_fields_model');
	}

	/*-----------------------------//
	//	CATEGORY			      //
	//---------------------------*/

	//-----------------------------------------------------
	public function index()
	{
		$data['title'] = 'Category List';

		$data['categories'] = $this->category_model->get_all_categories();

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/category/category-list', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------
	public function add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('category', 'Category', 'trim|is_unique[ci_categories.name]|required');

			$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[3]');

			if ($this->form_validation->run() == FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/category/add'),'refresh');

			}
			else{

				// LOGO PICTURE
				
				if(!empty($_FILES['picture']['name']))
				{
					$path = 'assets/category/';

					$result = $this->functions->file_insert($path, 'picture', 'image', '50000');

					if($result['status'] == 1){

						$picture = $path.$result['msg'];

					}
					else{

						$this->session->set_flashdata('errors', $result['msg']);

						redirect(base_url('admin/category/add'),'refresh');

					}
				}

				// 
				$slug = make_slug($this->input->post('category'));

				$data = array(
					'name' => ucfirst($this->input->post('category')),
					'slug' => $slug,
					'picture' => $picture,
					'description' => $this->input->post('description'),
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
					'show_on_home' => (empty($this->input->post('home_page'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->category_model->add_category($data);

				$this->session->set_flashdata('success','Categoría ha sido agregada exitosamente');

				redirect(base_url('admin/category'));
			}
		}
		else{
			$data['title'] = 'añadir categoría';

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/category/category_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function edit($id=0)
	{
		if($this->input->post()){

			$this->form_validation->set_rules('category', 'Category', 'trim|required');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/category/edit/'.$id),'refresh');
			}
			else
			{
				if(!empty($_FILES['picture']['name']))
				{
					$path = 'assets/category/';

					$result = $this->functions->file_insert($path, 'picture', 'image', '50000');

					if($result['status'] == 1){

						$this->functions->delete_file($this->input->post('old_picture'));

						$picture = $path.$result['msg'];

					}
					else{

						$this->session->set_flashdata('errors', $result['msg']);

						redirect(base_url('admin/category/edit/'.$id),'refresh');

					}
				}
				else
				{
					$picture = $this->input->post('old_picture');
				}

				$slug = make_slug($this->input->post('category'));

				$data = array(
					'name' => ucfirst($this->input->post('category')),
					'slug' => $slug,
					'picture' => $picture,
					'description' => $this->input->post('description'),
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
					'show_on_home' => (empty($this->input->post('home_page'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->category_model->edit_category($data, $id);

				$this->session->set_flashdata('success','Categoría ha sido actualizada exitosamente');

				redirect(base_url('admin/category'));

			}
		}
		else{

			$data['title'] = 'Actualizar categoría';

			$data['category'] = $this->category_model->get_category_by_id($id);

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/category/category_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function del($id = 0)
	{
		$row = $this->db->get_where('ci_categories', array('id' => $id))->row_array();

		$this->functions->delete_file($row['picture']);

		$this->db->delete('ci_categories', array('id' => $id));

		$this->session->set_flashdata('success', 'Categoría ha sido eliminada exitosamente!');

		redirect(base_url('admin/category'));
	}

	/*-----------------------------//
	//	SUBCATEGORY			      //
	//---------------------------*/

	//-----------------------------------------------------
	public function subcategories($category_id = 0)
	{
		$data['title'] = 'Lista de subcategorías';
		$data['subcategories'] = $this->category_model->get_all_subcategories($category_id);
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/subcategory/subcategory-list', $data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------
	public function add_subcategory()
	{
		if($this->input->post()){

			$this->form_validation->set_rules('subcategory', 'SubCategory', 'trim|is_unique[ci_subcategories.name]|required');

			$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[3]');

			$parent = $this->input->post('category');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/category/'.$parent.'/subcategories/add/'.$id),'refresh');
			}
			else{

				$slug = make_slug($this->input->post('subcategory'));

				$data = array(
					'name' => ucfirst($this->input->post('subcategory')),
					'slug' => $slug,
					'parent' => $parent,
					'description' => $this->input->post('description'),
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->category_model->add_subcategory($data);

				$this->session->set_flashdata('success','Subcategoría ha sido agregada exitosamente');

				redirect(base_url('admin/category/'.$parent.'/subcategories'));
			}
		}
		else{
			$data['title'] = 'Añadir subcategoría';
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/subcategory/subcategory_add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function edit_subcategory($id=0)
	{
		if($this->input->post()){

			$this->form_validation->set_rules('subcategory', 'SubCategory', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[3]');

			if ($this->form_validation->run() === FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/subcategory/edit/'.$id),'refresh');

			}
			else
			{
				$slug = make_slug($this->input->post('subcategory'));

				$parent = $this->input->post('category');

				$data = array(
					'name' => ucfirst($this->input->post('subcategory')),
					'slug' => $slug,
					'description' => $this->input->post('description'),
					'status' => (empty($this->input->post('active'))) ? 0 : 1,
				);

				$data = $this->security->xss_clean($data);

				$result = $this->category_model->edit_subcategory($data, $id);

				$this->session->set_flashdata('success','Subcategoría ha sido actualizada exitosamente');

				redirect(base_url('admin/category/'.$parent.'/subcategories'));

			}
		}
		else{
			$data['title'] = 'Actualizar categoría';
			$data['category'] = $this->category_model->get_subcategory_by_id($id);
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/subcategory/subcategory_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function del_subcategory($id = 0)
	{
		$this->db->delete('ci_subcategories', array('id' => $id));
		$this->session->set_flashdata('success', 'Subcategoría ha sido eliminada exitosamente!');
		redirect(base_url('admin/category'));
	}

	/*-----------------------------//
	//	ADD CUSTOM FIELDS         //
	//---------------------------*/

	public function custom_fields($category_id)
	{
		if($this->input->post('submit')){

			$this->form_validation->set_rules('category', 'Category', 'trim|required');

			$this->form_validation->set_rules('subcategory', 'subcategory', 'trim');

			$this->form_validation->set_rules('field', 'Custom Field', 'trim|required');

			if ($this->form_validation->run() == FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);

				redirect(base_url('admin/category/custom_fields/'.$category_id),'refresh');
			}
			else{

				$data = array(
					'category' => $this->input->post('category'),
					'subcategory' => (!empty($this->input->post('subcategory'))) ? $this->input->post('subcategory') : NULL,
					'field' => $this->input->post('field'),
				);

				$data = $this->security->xss_clean($data);

				$result = $this->custom_fields_model->add_field_to_category($data);

				$this->session->set_flashdata('success','Campo ha sido agregado exitosamente');

				redirect(base_url('admin/category/custom_fields/'.$category_id),'refresh');
			}
		}
		else{

			$data['title'] = 'Campos personalizados a categoría';
			$data['records'] = $this->category_model->get_category_custom_fields($category_id);
			// var_dump($data); exit();
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/category/custom_fields', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function custom_field_del($field_id,$category_id)
	{
		$this->db->delete('ci_fields_to_category', array('id' => $field_id));

		$this->session->set_flashdata('success', 'Campo ha sido eliminado exitosamente!');

		redirect(base_url('admin/category/custom_fields/'.$category_id));
	}

}
?>