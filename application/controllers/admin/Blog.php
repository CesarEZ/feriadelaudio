<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller 

{ 

	function __construct()

	{

		parent::__construct();

		auth_check(); // check login auth

        $this->rbac->check_module_access();

		$this->load->model('admin/blog_model', 'blog_model');

		$this->load->model('common_model'); 

		$this->load->helper('common_helper');

	}



	//------------------------------------------------

	public function index()

	{
		$this->session->unset_userdata('post_search_from');

		$this->session->unset_userdata('post_search_to');

		$this->session->unset_userdata('post_search_category');

		$data['categories'] = $this->common_model->get_blog_categories_list(); 

		$data['posts'] = $this->blog_model->get_all_posts();

		$data['title'] = 'Lista de publicaciones';

		$this->load->view('admin/includes/_header');

		$this->load->view('admin/blog/index',$data);

		$this->load->view('admin/includes/_footer');

	}



	public function post_list()

	{

		$data['posts'] = $this->blog_model->get_all_posts();

		$this->load->view('admin/blog/post_list',$data);

	}



	//--------------------------------------------------

	public function search()

	{

		$this->session->set_userdata('post_search_from',$this->input->post('post_search_from'));

		$this->session->set_userdata('post_search_to',$this->input->post('post_search_to'));

		$this->session->set_userdata('post_search_category',$this->input->post('post_search_category'));

	}



	//---------------------------------------------------------------------------

	// Add New Post  

	function post()

	{	

		$admin_id = $this->session->userdata('admin_id');

		

		$data['categories'] = $this->common_model->get_blog_categories_list(); 



		if ($this->input->post('blog_post')) {

			$this->form_validation->set_rules('title','title','trim|required|min_length[3]');

			$this->form_validation->set_rules('content','Content','trim|required|min_length[3]');

			$this->form_validation->set_rules('category','category','trim|required');

			$this->form_validation->set_rules('tags','tags','trim|required');

			$this->form_validation->set_rules('keywords','keywords','trim|required');



			if ($this->form_validation->run() == FALSE) {

				$data = array(

					'errors' => validation_errors(),

				);



				$this->session->set_flashdata('error',$data['errors']);

				redirect(base_url('admin/blog/post'),'refresh');



			}

			else

			{

				$data = array(

					'title' => ucfirst($this->input->post('title')),

					'slug' => make_slug($this->input->post('title')),

					'content' => $this->input->post('content'),

					'keywords' => $this->input->post('keywords'),

					'category_id' => $this->input->post('category'),

					'created_at' => date('Y-m-d : h:m:s'),

				);



				// post image





				$path="assets/blog/";



				// check all mendatory files

				if(empty($_FILES['post_media']['name']))

				{

					$this->session->set_flashdata('error', 'El campo Publicar medios es obligatorio');

					redirect(base_url('admin/blog/post'),'refresh');

				}



				// profile picture

				if(!empty($_FILES['post_media']['name']))

				{

					$result = $this->functions->file_insert($path, 'post_media', 'image', '1000000');

					if($result['status'] == 1){

						$data['image_default'] = $path.$result['msg'];

					}

					else

					{

						$this->session->set_flashdata('error', $result['msg']);

						redirect(base_url('admin/blog/post'),'refresh');

					}

				}



				$data = $this->security->xss_clean($data);



				$post_id = $this->blog_model->add_post($data);



				$tags = explode(',', $this->input->post('tags'));



				for ($i = 0; $i < count($tags); $i++) 

				{ 

					$tags_data = array(

						'post_id' => $post_id,

						'tag' => $tags[$i],

						'tag_slug' => make_slug($tags[$i]),

					);

					$tags_data = $this->security->xss_clean($tags_data);

					$this->blog_model->add_tags($tags_data);

				}



				if ($post_id){

					$this->session->set_flashdata('success','Enhorabuena! La publicación se ha enumerado correctamente');

					redirect(base_url('admin/blog/'));

				}

				else{

					echo "ha fallado";

				}

			}

		}

		else{



			$data['title'] = 'Blog Post';

			$this->load->view('admin/includes/_header');

			$this->load->view('admin/blog/post_add',$data);

			$this->load->view('admin/includes/_footer');

		}

	}

	

	//--------------------------------------------------------	

	// Edit Job

	public function edit($post_id=0)

	{		

		$data['categories'] = $this->common_model->get_blog_categories_list(); 



		if ($this->input->post('edit_post')) {

			$this->form_validation->set_rules('title','title','trim|required|min_length[3]');

			$this->form_validation->set_rules('content','Content','trim|required|min_length[3]');

			$this->form_validation->set_rules('category','category','trim|required');

			$this->form_validation->set_rules('tags','tags','trim|required');

			$this->form_validation->set_rules('keywords','keywords','trim|required');



			if ($this->form_validation->run() == FALSE) {

				$data = array(

					'errors' => validation_errors(),

				);



				$this->session->set_flashdata('error',$data['errors']);

				redirect(base_url('employers/blog/edit/'.$post_id),'refresh');



			}

			else{



				$data = array(

					'title' => ucfirst($this->input->post('title')),

					'slug' => make_slug($this->input->post('title')),

					'content' => $this->input->post('content'),

					'keywords' => $this->input->post('keywords'),

					'category_id' => $this->input->post('category'),

				);



				$path="assets/blog/";



				// check all mendatory files

				if(empty($_FILES['post_media']['name']))

				{

					$data['image_default'] = $this->input->post('old_media');

				}



				// profile picture

				if(!empty($_FILES['post_media']['name']))

				{

					unlink($this->input->post('old_media'));

					

					$result = $this->functions->file_insert($path, 'post_media', 'image', '1000000');

					if($result['status'] == 1){

						$data['image_default'] = $path.$result['msg'];

					}

					else

					{

						$this->session->set_flashdata('error', $result['msg']);

						redirect(base_url('admin/blog/post'),'refresh');

					}

				}



				$data = $this->security->xss_clean($data);

				$this->blog_model->edit_post($data,$post_id);



				$tags = explode(',', $this->input->post('tags'));



				$this->blog_model->delete_post_tags($post_id);

				

				for ($i = 0; $i < count($tags); $i++) 

				{ 

					$tags_data = array(

						'post_id' => $post_id,

						'tag' => $tags[$i],

						'tag_slug' => make_slug($tags[$i]),

					);



					$tags_data = $this->security->xss_clean($tags_data);

					$this->blog_model->add_tags($tags_data);

				}



				$this->session->set_flashdata('success','La publicación se actualizó correctamente');

				redirect(base_url('admin/blog/'));

				

			}

		}

		else{

			$data['post_detail'] = $this->blog_model->get_post_by_id($post_id);



			$data['title'] = 'Editar post';

			$this->load->view('admin/includes/_header');

			$this->load->view('admin/blog/post_edit', $data);

			$this->load->view('admin/includes/_footer');

		}  

	}



	//---------------------------------------------------------------------------------------

	// Delete the job

	public function del($id=0)

	{

		$this->db->where('id',$id);

		$this->db->delete('ci_blog_posts');



		$this->db->where('post_id',$id);

		$this->db->delete('ci_blog_tags');



		$this->session->set_flashdata('success','Enhorabuena! La publicación se ha eliminado correctamente');

		redirect(base_url('admin/blog'),'refresh');



	}





	/*------------------

	BLOG CATEGORY

	-------------------*/



	public function category()

	{

		$data['title'] = 'Lista de categoría';

		$data['categories'] = $this->blog_model->get_all_categories();

		$this->load->view('admin/includes/_header');

		$this->load->view('admin/blog/category-list',$data);

		$this->load->view('admin/includes/_footer');

	}



	//-----------------------------------------------------

	public function category_add()

	{

		if($this->input->post()){

			$this->form_validation->set_rules('category', 'Category', 'trim|is_unique[ci_blog_categories.name]|required');

			if ($this->form_validation->run() === FALSE) {



				$data = array(

					'errors' => validation_errors(),

				);



				$this->session->set_flashdata('error',$data['errors']);



			}



			$slug = make_slug($this->input->post('category'));

			$data = array(

				'name' => ucfirst($this->input->post('category')),

				'slug' => $slug

			);

			$data = $this->security->xss_clean($data);

			$result = $this->blog_model->add_category($data);

			$this->session->set_flashdata('success','Categoría ha sido agregada exitosamente');

			redirect(base_url('admin/blog/category'));

		}

		else{

			$data['title'] = 'Añadir categoría';

			$this->load->view('admin/includes/_header');

			$this->load->view('admin/blog/category_add');

			$this->load->view('admin/includes/_footer');

		}

	}



	//-----------------------------------------------------

	public function category_edit($id=0)

	{

		if($this->input->post()){

			$this->form_validation->set_rules('category', 'Category', 'trim|required');

			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

			if ($this->form_validation->run() === FALSE) {

				$data = array(

					'errors' => validation_errors(),

				);



				$this->session->set_flashdata('error',$data['errors']);

				redirect(base_url('admin/blog/category/edit/'.$id),'refresh');

			}

			else

			{

				$slug = make_slug($this->input->post('category'));

				$data = array(

					'name' => ucfirst($this->input->post('category')),

					'slug' => $slug

				);

				$data = $this->security->xss_clean($data);

				$result = $this->blog_model->edit_category($data, $id);

				$this->session->set_flashdata('success','Categoría ha sido actualizada exitosamente');

				redirect(base_url('admin/blog/category'));

			}

		}

		else{

			$data['title'] = 'Actualizar categoría';

			$data['category'] = $this->blog_model->get_category_by_id($id);

			$this->load->view('admin/includes/_header');

			$this->load->view('admin/blog/category_edit',$data);

			$this->load->view('admin/includes/_footer');

		}

	}



	//-----------------------------------------------------

	public function category_del($id = 0)

	{

		$this->db->delete('ci_blog_categories', array('id' => $id));

		$this->session->set_flashdata('success', 'Categoría ha sido eliminada exitosamente!');

		redirect(base_url('admin/blog/category'));

	}



}	



?>