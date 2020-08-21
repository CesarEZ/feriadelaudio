<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Main_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_model');
		$this->load->model('common_model'); // load common model
	}

	//----------------------------------------------------------------------------------
	// All Companies
	public function index()
	{
		$data['posts'] = $this->blog_model->get_all_posts();
		
		$data['title'] = 'Blog'; 
		$data['meta_description'] = 'tu meta descripción aquí';
		$data['keywords'] = 'metaetiquetas aquí';
		
		$data['layout'] = 'themes/blog/home';
		$this->load->view('themes/layout', $data);
	}

	//----------------------------------------------------------------------------------
	// Post Detail
	public function post($title = NULL)
	{
		$data['post'] = $this->blog_model->get_post_detail_by_title($title);

		$data['title'] = $data['post']["title"]; 
		$data['meta_description'] = 'tu meta descripción aquí';
		$data['keywords'] = $data['post']["keywords"];

		$data['layout'] = 'themes/blog/post_detail';
		$this->load->view('themes/layout', $data);
	}

	public function tag($tag_slug)
	{
		$data['posts'] = $this->blog_model->get_all_post_by_tag($tag_slug);

		$data['title'] = $data['posts'][0]['tag']; 
		$data['meta_description'] = 'tu meta descripción aquí';
		$data['keywords'] = 'metaetiquetas aquí';
		
		$data['layout'] = 'themes/blog/post_by_tag';
		$this->load->view('themes/layout', $data);
	}

	public function category($cat_slug)
	{
		$data['posts'] = $this->blog_model->get_all_post_by_category($cat_slug);
		$data['title'] = $data['posts'][0]['name']; 
		$data['meta_description'] = 'tu meta descripción aquí';
		$data['keywords'] = 'metaetiquetas aquí';
		
		$data['layout'] = 'themes/blog/post_by_tag';
		$this->load->view('themes/layout', $data);
	}

	public function search()
	{
		if($_GET['title'])
		{
			$title = make_slug($_GET['title']);

			$data['posts'] = $this->blog_model->get_all_post_like_title($title);

			$data['title'] = $_GET['title']; 
			$data['meta_description'] = 'tu meta descripción aquí';
			$data['keywords'] = 'metaetiquetas aquí';
			
			$data['layout'] = 'themes/blog/home';
			$this->load->view('themes/layout', $data);

		}
		else
		{
			redirect('blog');
		}
	}

}

?> 