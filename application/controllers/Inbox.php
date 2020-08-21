<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends Main_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('common_model'); // load common model 
		$this->load->model('inbox_model'); // load common model 
		$this->load->library('mailer'); // load custom mailer library
	}

	//------------------------------------------------------------------
	public function index($ad_id = '',$slug = ''){

		if(!$this->session->userdata('is_user_login'))
		{
			$this->session->set_userdata('last_request_page',current_url());
			
			redirect('login');
		}

		if(empty($ad_id))
		{
			$data['title'] = 'Inbox';

			$data['messages'] = $this->inbox_model->get_messages_list();

			$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user

			$data['layout'] = 'themes/inbox/list';

			$this->load->view('themes/layout', $data);
		}
		else
		{
			$data['ad'] = $this->inbox_model->get_ad_by_slug($slug);

			$data['messages'] = $this->inbox_model->get_messages_by_ad($ad_id,$slug);

			$data['title'] = $data['ad']['title'].' Inbox';

			$data['user_sidebar'] = 'themes/user/user_sidebar'; // load sidebar for user

			$data['layout'] = 'themes/inbox/chat';

			$this->load->view('themes/layout', $data);
		}
	}

	public function send_message()
	{
		if($_POST)
		{
			$data = array(
				'ad' => $_POST['post'],
				'sender' => $this->session->user_id,
				'receiver' => $_POST['receiver'],
				'message' => $_POST['message'],
			);

			$data = $this->security->xss_clean($data);

			$this->inbox_model->add_message($data);

			$post = $this->common_model->get_ad_by_id($_POST['post']);

			// Email Alert

				$mail_data = array(
					'post_title' => $post['title'],
					'post_link' => base_url('ad/'.$post['slug']),
					'message' => $_POST['message']
				);

				$to = get_user_email($_POST['receiver']);

				$this->mailer->mail_template($to,'message-alert',$mail_data);
			// 

			$response =  array('status' => 'success', 'msg' =>  'Mensaje enviado');

			echo json_encode($response);
		}
	}

}// end class
?>