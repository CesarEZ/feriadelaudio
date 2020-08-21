<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends MY_Controller
{
	function __construct()
	{
		parent ::__construct();
		auth_check(); // check login auth
        $this->rbac->check_module_access();
		$this->load->model('admin/testimonial_model', 'testimonial_model');
	}

	public function index()
	{
		$data['title'] = 'Lista de testimonios';

		$data['testimonials'] = $this->testimonial_model->get_all_testimonials();

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/testimonial/list',$data);
		$this->load->view('admin/includes/_footer');
	}

	//-----------------------------------------------------
	public function add()
	{
		if($this->input->post('submit'))
		{

			$this->form_validation->set_rules('testimonial', 'testimonial', 'trim|required');
			$this->form_validation->set_rules('testimonial_by', 'testimonial_by', 'trim|required');
			$this->form_validation->set_rules('about', 'Company and Designation', 'trim|required');

			if ($this->form_validation->run() === FALSE) {
				
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/testimonial/add'),'refresh');
			}

			$data = array(
				'testimonial' => $this->input->post('testimonial'),
				'testimonial_by' => ucfirst($this->input->post('testimonial_by')),
				'comp_and_desig' => ucfirst($this->input->post('about')),
				'is_default' => $this->input->post('default'),
				'status' => $this->input->post('status'),
			);

			// thumbnail picture
			if(!empty($_FILES['photo']['name']))
			{
				$path = "assets/testimonials/";
				$result = $this->functions->file_insert($path, 'photo','image', '1000000');
				if($result['status'] == 1){
					$data['photo'] = $path.$result['msg'];
				}
				else
				{
				    $this->session->set_flashdata('error', $result['msg']);
			        redirect(base_url('admin/testimonial/add'));
				}
			}

			$data = $this->security->xss_clean($data);
			$result = $this->testimonial_model->add_testimonial($data);
			$this->session->set_flashdata('success','El testimonio ha sido agregado exitosamente');
			redirect(base_url('admin/testimonial'));
		}
		else{
			$data['title'] = 'Añadir testimonio';
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/testimonial/add', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function edit($id=0)
	{

		if($this->input->post()){

			$this->form_validation->set_rules('testimonial', 'testimonial', 'trim|required');
			$this->form_validation->set_rules('testimonial_by', 'testimonial_by', 'trim|required');
			$this->form_validation->set_rules('about', 'Company and Designation', 'trim|required');

			if ($this->form_validation->run() === FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/testimonial/edit/'.$id),'refresh');				
			}

			$data = array(
				'testimonial' => $this->input->post('testimonial'),
				'testimonial_by' => ucfirst($this->input->post('testimonial_by')),
				'comp_and_desig' => ucfirst($this->input->post('about')),
				'is_default' => $this->input->post('default'),
				'status' => $this->input->post('status'),
			);

			// update pictures
			if(!empty($_FILES['photo']['name']))
			{
				unlink($this->input->post('old_photo'));
				
				$result = $this->functions->file_insert($path, 'photo','image', '1000000');
				if($result['status'] == 1){
					$data['photo'] = $path.$result['msg'];
				}
				else
				{
					$this->session->set_flashdata('error',$result['msg']);
					redirect(base_url('admin/testimonial/edit/'.$id));
				}
			}


			$data = $this->security->xss_clean($data);
			$result = $this->testimonial_model->edit_testimonial($data, $id);
			$this->session->set_flashdata('success','El testimonio ha sido actualizado exitosamente');
			redirect(base_url('admin/testimonial'));
		}
		else{

			$data['title'] = 'Actualizar testimonio';
			$data['testimonial'] = $this->testimonial_model->get_testimonial_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/testimonial/edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	//-----------------------------------------------------
	public function del($id = 0)
	{
		// unlink if there is photo
		$photo = $this->db->select('photo')->where('id',$id)->get('ci_testimonials')->row_array()['photo'];
		if($photo)
		unlink($photo);

		$this->db->delete('ci_testimonials', array('id' => $id));
		$this->session->set_flashdata('success', 'El testimonio ha sido eliminado exitosamente!');
		redirect(base_url('admin/testimonial'));
	}

}
?>