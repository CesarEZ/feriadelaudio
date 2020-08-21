<?php

class Blog_Model extends CI_Model

{

	public function __construct()

	{

		parent::__construct();

	}



	//-----------------------------------------------------

	public function get_all_posts(){



		if($this->session->userdata('post_search_category')!='')

			$this->db->where('ci_blog_posts.category_id',$this->session->userdata('post_search_category'));



		if($this->session->userdata('post_search_from')!='')

			$this->db->where('DATE(ci_blog_posts.created_at) >=',date('Y-m-d',strtotime($this->session->userdata('post_search_from'))));



		if($this->session->userdata('post_search_to')!='')

			$this->db->where('DATE(ci_blog_posts.created_at) <=',date('Y-m-d',strtotime($this->session->userdata('post_search_to'))));


		$this->db->order_by('ci_blog_posts.created_at','desc');

		$query = $this->db->get('ci_blog_posts');

		// var_dump($this->db->last_query()); exit();

		return $result = $query->result_array();

	}



	//-----------------------------------------------------

	public function add_post($data){

		$result = $this->db->insert('ci_blog_posts', $data);

        return $this->db->insert_id();	

	}



	// ---------------------------------------------------

	public function add_tags($data)

	{

		$this->db->insert('ci_blog_tags', $data);

		return true;

	}



	public function delete_post_tags($post_id)

	{

		$this->db->where('post_id', $post_id);

		$this->db->delete('ci_blog_tags');

		return true;

	}



	//-----------------------------------------------------

	public function edit_post($data, $id){

		$this->db->where('id', $id);

		$this->db->update('ci_blog_posts', $data);

		return true;



	}

	//-----------------------------------------------------

	public function get_post_by_id($id){

		$query = $this->db->get_where('ci_blog_posts', array('id' => $id));

		return $result = $query->row_array();

	}



	public function get_all_categories()

	{

		return $this->db->get('ci_blog_categories')->result_array();

	}



	//-----------------------------------------------------

	public function add_category($data){

		$result = $this->db->insert('ci_blog_categories', $data);

        return $this->db->insert_id();	

	}



	//-----------------------------------------------------

	public function edit_category($data, $id){

		$this->db->where('id', $id);

		$this->db->update('ci_blog_categories', $data);

		return true;



	}



	//-----------------------------------------------------

	public function get_category_by_id($id){

		$query = $this->db->get_where('ci_blog_categories', array('id' => $id));

		return $result = $query->row_array();

	}

}

?>