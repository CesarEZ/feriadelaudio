<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
        $this->rbac->check_module_access();
		$this->load->model('admin/package_model', 'package_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	//-------------------------------------------------------
	public function index()
	{
		$data['packages'] = $this->package_model->get_all_packages();

		$data['title'] = 'Lista de paquetes';
        $this->load->view('admin/includes/_header');
        $this->load->view('admin/packages/package_list', $data);
        $this->load->view('admin/includes/_footer');
	}

	//-------------------------------------------------------
	public function add()
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('title', 'plan_title', 'trim|required');
			$this->form_validation->set_rules('price', 'price', 'trim|required');
			$this->form_validation->set_rules('no_of_days', 'no_of_days', 'trim|required');
			$this->form_validation->set_rules('no_of_posts', 'no_of_posts', 'trim|required');
			$this->form_validation->set_rules('detail', 'detail', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/packages/package_add';
				$this->load->view('admin/layout', $data);
			}
			else{

				$data = array(
					'title' => $this->input->post('title'),
					'price' => $this->input->post('price'),
					'detail' => $this->input->post('detail'),
					'no_of_days' => $this->input->post('no_of_days'),
					'no_of_posts' => $this->input->post('no_of_posts'),
					'created_date' => date('Y-m-d : h:m:s'),
					'updated_date' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->package_model->add_package($data);
				if($result){
					$this->session->set_flashdata('success', 'El paquete ha sido agregado exitosamente!');
					redirect(base_url('admin/packages'));
				}
			}
		}
		else{
			$data['title'] = 'Agregar paquetes';
 			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/packages/package_add', $data);
        	$this->load->view('admin/includes/_footer');
		}
		
	}

	//-------------------------------------------------------
	public function edit($id = 0)
	{
		if($this->input->post('submit')){
			$this->form_validation->set_rules('title', 'plan_title', 'trim|required');
			$this->form_validation->set_rules('no_of_days', 'no_of_days', 'trim|required');
			$this->form_validation->set_rules('no_of_posts', 'no_of_posts', 'trim|required');
			$this->form_validation->set_rules('status', 'status', 'trim|required');
			$this->form_validation->set_rules('price', 'price', 'trim|required');
			$this->form_validation->set_rules('detail', 'detail', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);

				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/packages/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'title' => $this->input->post('title'),
					'price' => $this->input->post('price'),
					'detail' => $this->input->post('detail'),
					'no_of_days' => $this->input->post('no_of_days'),
					'no_of_posts' => $this->input->post('no_of_posts'),
					'is_active' => $this->input->post('status'),
					'updated_date' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->package_model->update_package($id, $data);
				if($result){
					$this->session->set_flashdata('success', 'El paquete ha sido actualizado exitosamente!');
					redirect(base_url('admin/packages'));
				}
			}
		}
		else{
			$data['package'] = $this->package_model->get_package_by_id($id);
			$data['title'] = 'Editar paquete';
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/packages/package_edit', $data);
        	$this->load->view('admin/includes/_footer');
		}
	}

	//-------------------------------------------------------
	public function del($id = 0)
	{
		$this->db->delete('ci_packages', array('id' => $id));
		$this->session->set_flashdata('success', 'El paquete ha sido eliminado exitosamente!');
		redirect(base_url('admin/packages'));
	}

}


?>