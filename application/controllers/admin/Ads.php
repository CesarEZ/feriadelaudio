<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends Main_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->per_page_record = 14;
		$this->load->model('admin/ad_model','ad_model'); // load job model
		$this->load->model('common_model'); // for common funcitons
		$this->load->library('mailer'); // load custom mailer library
		$this->load->model('admin/setting_model', 'setting_model');
	}

	/* All Ads */

	//------------------------------------------------
	public function index()
	{
		$this->session->unset_userdata('ad_search_category');
		$this->session->unset_userdata('ad_search_subcategory');
		$this->session->unset_userdata('ad_search_package');
		$this->session->unset_userdata('ad_search_status');
		$this->session->unset_userdata('ad_search_from');
		$this->session->unset_userdata('ad_search_to');

		$data['categories'] = $this->common_model->get_categories_list(); 
		$data['packages'] = $this->common_model->get_packages(); 
		$data['ads'] = $this->ad_model->get_all_ads();

		$data['title'] = 'Ads List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/ads/index',$data);
		$this->load->view('admin/includes/_footer');
	}

	public function ad_list()
	{
		$data['ads'] = $this->ad_model->get_all_ads();
		$this->load->view('admin/ads/ad_list',$data);
	}

	//--------------------------------------------------
	public function search()
	{
		$this->session->set_userdata('ad_search_category',$this->input->post('ad_search_category'));
		$this->session->set_userdata('ad_search_subcategory',$this->input->post('subcategory'));
		$this->session->set_userdata('ad_search_package',$this->input->post('ad_search_package'));
		$this->session->set_userdata('ad_search_status',$this->input->post('ad_search_status'));
		$this->session->set_userdata('ad_search_from',$this->input->post('ad_search_from'));
		$this->session->set_userdata('ad_search_to',$this->input->post('ad_search_to'));
	}
	
	//--------------------------------------------------------	
	// Edit Ad
	public function edit($ad_id=0)
	{		
		$data['categories'] = $this->common_model->get_categories_list(); 

		if ($this->input->post('edit_ad')) {
			$this->form_validation->set_rules('category', 'Category', 'trim|required');

			$this->form_validation->set_rules('subcategory', 'Sub Category', 'trim');

			$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]');

			$this->form_validation->set_rules('price', 'price', 'trim|required|numeric');

			$this->form_validation->set_rules('tags', 'tags', 'trim|min_length[3]');

			$this->form_validation->set_rules('description', 'description', 'trim|min_length[20]');

			$this->form_validation->set_rules('country', 'Country', 'trim|required');

			$this->form_validation->set_rules('state', 'State', 'trim|required');

			$this->form_validation->set_rules('city', 'City', 'trim|required');

			$this->form_validation->set_rules('address', 'Street Address', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors(),
				);

				$this->session->set_flashdata('error',$data['errors']);
				redirect(base_url('admin/ads/edit/'.$ad_id),'refresh');

			}
			else{

				$slug = make_slug($this->input->post('title')).'-'.$ad_id;

				$title = ucwords($this->input->post('title')); 

				$status = $this->input->post('is_status');

				$old_status = $this->input->post('old_status');

				$package = $this->input->post('package');

				$data = array(
					'category' => $this->input->post('category'),
					'subcategory' => $this->input->post('subcategory'),
					'title' => $title,
					'slug' => $slug,
					'price' => $this->input->post('price'),
					'tags' => (!empty($this->input->post('tags'))) ? $this->input->post('tags') : NULL,
					'description' => $this->input->post('description'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'location' => $this->input->post('address'),
					'is_status' => $status,
					'expiration_date_reminder' => '0',
					'expiry_date' => create_package_expiry_date($package)
				);

				
				// Images

				$path = "assets/ads/";

				// check all mendatory files
				if(empty($_POST['old_img_1']))
				{
					$this->session->set_flashdata('error','La imagen en miniatura es obligatoria');
					redirect(base_url('admin/ads/edit/'.$ad_id));
				}

				// update pictures
				if(!empty($_FILES['img_1']['name']))
				{
					unlink($this->input->post('old_img_1'));
					
					$result = $this->functions->post_file_insert($path, 'img_1', '1000000');
					if($result['status'] == 1){
						$data['img_1'] = $path.$result['msg'];
					}
					else
					{
						$this->session->set_flashdata('error',$result['msg']);
						redirect(base_url('admin/ads/edit/'.$id));
					}
				}

				if(!empty($_FILES['img_2']['name']))
				{
					if(!empty($_POST['old_img_2']))
						unlink($this->input->post('old_img_2'));
					
					$result = $this->functions->post_file_insert($path, 'img_2', '1000000');
					if($result['status'] == 1){
						$data['img_2'] = $path.$result['msg'];
					}
					else
					{
						$this->session->set_flashdata('error',$result['msg']);
						redirect(base_url('admin/ads/edit/'.$id));
					}
				}

				if(!empty($_FILES['img_3']['name']))
				{
					if(!empty($_POST['old_img_3']))
						unlink($this->input->post('old_img_3'));
					
					$result = $this->functions->post_file_insert($path, 'img_3', '1000000');
					if($result['status'] == 1){
						$data['img_3'] = $path.$result['msg'];
					}
					else
					{
						$this->session->set_flashdata('error',$result['msg']);
						redirect(base_url('admin/ads/edit/'.$id));
					}
				}

				$data['video_1'] = htmlspecialchars(htmlentities($this->input->post('video_1')));
				$data['video_2'] = htmlspecialchars(htmlentities($this->input->post('video_2')));
				$data['video_3'] = htmlspecialchars(htmlentities($this->input->post('video_3')));
				
				$data = $this->security->xss_clean($data);

				$this->ad_model->edit_ad($data,$ad_id);

				// CUSTOM FIELDS
				
				if(isset($_POST['field']) && count($_POST['field']) > 0)
				{

					$this->ad_model->delete_ad_field_detail($ad_id);

					foreach ($_POST['field'] as $index) {

						$field_name = 'fd-'.$index;

						$field_data = array(
							'field_id' => $index,
							'field_value' => (is_array($_POST[$field_name])) ? implode(',', $_POST[$field_name]) : $_POST[$field_name]
						);

						$field_data['ad_id'] = $ad_id;

						$field_data = $this->security->xss_clean($field_data);

						$this->ad_model->add_ad_field_detail($field_data);

					}
				}

				// Email to Seller
				$seller = $this->input->post('seller');
				$user =  get_user($seller);
				$to = $user['email'];

				if($status == 0 && $old_status != 0)
				{
					$mail_data = array(
						'content' => 'Su anuncio <b>'. $title .'</b> ha sido inactivado por el administrador.',
					);
					$template = $this->mailer->mail_template($to,'general-notification',$mail_data);

					// User Notification
					$notification = array(
						'user_id' => $seller,
						'content' => 'Su anuncio <b>'.$data['title'].'</b> ha sido inactivado.'
					);
					$this->common_model->add_notification($notification);
				}

				if($status == 1 && $old_status != 1)
				{
					$mail_data = array(
						'firstname' => $user['firstname'],
						'lastname' => $user['lastname'],
						'post_link' => base_url('ad/'.$slug),
						'post_title' => $title,
					);
					$template = $this->mailer->mail_template($to,'ad-post',$mail_data);

					// User Notification
					$notification = array(
						'user_id' => $seller,
						'content' => 'Su anuncio <b>'.$data['title'].'</b> ha sido aprobado con exito.'
					);
					$this->common_model->add_notification($notification);
				}

				if($status == 2 && $old_status != 2)
				{
					$mail_data = array(
						'content' => 'Su anuncio <b>'. $title .'</b> ha expirado.',
					);
					$template = $this->mailer->mail_template($to,'general-notification',$mail_data);

					// User Notification
					$notification = array(
						'user_id' => $seller,
						'content' => 'Su anuncio <b>'.$data['title'].'</b> ha expirado.'
					);
					$this->common_model->add_notification($notification);
				}

				if($status == 3 && $old_status != 3)
				{
					$mail_data = array(
						'content' => 'Su anuncio <b>'. $title .'</b> cambió de estado ha vendido por el administrador.'
					);
					$template = $this->mailer->mail_template($to,'general-notification',$mail_data);

					// User Notification
					$notification = array(
						'user_id' => $seller,
						'content' => '¡Felicidades! su anuncio <b>'.$data['title'].'</b> cambió de estado ha vendido.'
					);
					$this->common_model->add_notification($notification);
				}

				if($status == 4 && $old_status != 4)
				{
					$option_no_approved = $this->input->post("text_no_approved");
					$mail_data = array(
						'content' => 'Su anuncio <b>'. $title .'</b> no ha podido ser aprobado.<br><br><b>Motivo:</b><br>'.$option_no_approved.'<br><br>Corrige tu anuncio  e intenta nuevamente.'
					);
					$template = $this->mailer->mail_template($to,'general-notification',$mail_data);

					// User Notification
					$notification = array(
						'user_id' => $seller,
						'content' => 'Su anuncio <b>'.$data['title'].'</b> no ha podido ser aprobado.'
					);
					$this->common_model->add_notification($notification);
				}
				// Email

				$this->session->set_flashdata('success','El anuncio se actualizó correctamente');
				redirect(base_url('admin/ads'));
				
			}
		}
		else{

			$data['ad_detail'] = $this->ad_model->get_ad_by_id($ad_id);
			$data['countries'] = $this->common_model->get_countries_list(); 

			$data['title'] = 'Editar anuncio';
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/ads/ad_edit', $data);
			$this->load->view('admin/includes/_footer');
		}  
	}

	public function del($id = '')
	{
		$data = $this->db->get_where('ci_ads',array('id' => $id))->row_array();

		if(!empty($data['img_1']))
			unlink($data['img_1']);

		if(!empty($data['img_2']))
			unlink($data['img_2']);

		if(!empty($data['img_3']))
			unlink($data['img_3']);


		$this->db->where('id',$id);
		$this->db->delete('ci_ads');

		$this->session->set_flashdata('success','El anuncio ha sido eliminado exitosamente');
		redirect(base_url('admin/ads'),'refresh');
	}

	//-------------------------------------------------------------------------------------------
	// Get sub category of category
	public function get_subcategory()
	{
		if($this->input->post('parent'))
		{
			$category = $_POST['parent'];

			$query = $this->db->get_where('ci_subcategories',array('parent' => $category));

			if($query->num_rows() > 0)
			{
				$rows = $query->result_array();
				$options = array('' => 'Seleccione una opción') + array_column($rows,'name','id');
				$html = form_dropdown('subcategory',$options,'','class="select2 form-control select-subcategory" required onchange="filter_data()"');
				$response =  array('status' => 'success', 'msg' =>  $html);
			}
			else
			{
				$html = $this->fields->category_fields($category);
				$response =  array('status' => 'fields', 'msg' =>  $html);
			}

			echo json_encode($response);
		}
	}

	//-------------------------------------------------------------------------------------------
	// Get custom fields of sub category
	public function get_subcategory_custom_fields()
	{
		if($this->input->post('parent'))
		{
			$html = $this->fields->subcategory_fields($_POST['parent'],'admin');

			$response =  array('status' => 'success', 'msg' =>  $html);

			echo json_encode($response);
		}
	}


	public function get_subcategory_ajax()
	{
		$id = $this->input->post("id");
		$querySubcategory = $this->common_model->get_subcategory_name($id);
		if ($querySubcategory) {
			for ($i=0; $i < count($querySubcategory); $i++) { 
				
				echo '<option value="'.$querySubcategory[$i]['id'].'">'.$querySubcategory[$i]['name'].'</option>';
			}
		} else {
			echo "no_data";
		}
	}

}// endClass
