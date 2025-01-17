<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Blog_Model extends CI_Model{



	//----------------------------------------------------

	// Get all companies

	public function get_all_posts()

	{

		$this->db->select('ci_blog_posts.*');

		$this->db->group_by('ci_blog_posts.id');

		$this->db->order_by('ci_blog_posts.id','desc');

		$query = $this->db->get('ci_blog_posts');

		return $query->result_array();

	}



	//---------------------------------------------------

	// Count total user for pagination

	public function count_all_posts(){

		return $this->db->count_all('ci_blog_posts');

	}



	//---------------------------------------------------

	// Get all post for pagination

	public function get_all_posts_for_pagination($limit, $offset){

		$wh =array();	

		$this->db->order_by('created_at','desc');

		$this->db->limit($limit, $offset);



		if(count($wh)>0){

			$WHERE = implode(' and ',$wh);

			$query = $this->db->get_where('ci_blog_posts', $WHERE);

		}

		else{

			$query = $this->db->get('ci_blog_posts');

		}

		return $query->result_array();

	}



	//----------------------------------------------------

	// Get all

	public function get_post_detail_by_title($title)

	{

		$query = $this->db->get_where('ci_blog_posts', array('slug' => $title));

		return $query->row_array();

	}



	public function get_all_post_like_title($title)

	{

		$this->db->select('*');

		$this->db->where('slug',$title);

		$this->db->or_like('slug',$title);

		return $this->db->get('ci_blog_posts')->result_array();

	}



	public function get_all_post_by_tag($slug)

	{

		$this->db->select('ci_blog_posts.id as post,title,slug,content,image_default,ci_blog_tags.*');

		$this->db->join('ci_blog_tags','ci_blog_tags.post_id = ci_blog_posts.id');

		$this->db->where('ci_blog_tags.tag_slug',$slug);

		return $this->db->get('ci_blog_posts')->result_array();

	}



	public function get_all_post_by_category($slug)

	{

		$this->db->select('ci_blog_posts.id as post,

			ci_blog_posts.title,

			ci_blog_posts.slug,

			ci_blog_posts.content,

			ci_blog_posts.image_default,

			ci_blog_categories.id,

			ci_blog_categories.name,

			ci_blog_categories.slug as cat_slug

		');

		$this->db->join('ci_blog_categories','ci_blog_categories.id = ci_blog_posts.category_id','right');

		$this->db->where('ci_blog_categories.slug',$slug);

		return $this->db->get('ci_blog_posts')->result_array();

	}





}



?>