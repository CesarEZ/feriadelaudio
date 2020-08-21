<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends Main_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('seller/ad_model','ad_model');
		$this->load->model('common_model'); // load common model 
		$this->load->library('mailer'); // load custom mailer library
		$this->load->helper('email');
		$this->load->model('admin/setting_model', 'setting_model');
	}

	//---------------------------------------------------------------------------------------
	public function add($view_payment="")
	{
		$product_code = $this->generateRandomString();

		if(!$this->session->userdata('is_user_login'))
		{
			redirect('login');
		}

		if($this->input->post()){

			$this->form_validation->set_rules('verify_link_fb_user', 'Cuenta de Facebook', 'trim|required');

			$this->form_validation->set_rules('category', 'Categoría', 'trim|required');

			$this->form_validation->set_rules('subcategory', 'Subcategoría', 'trim');

			$this->form_validation->set_rules('title', 'Titulo', 'trim|required|min_length[3]');

			$this->form_validation->set_rules('price', 'Precio', 'trim|required|numeric');

			$this->form_validation->set_rules('tags', 'Tags', 'trim|min_length[3]');

			$this->form_validation->set_rules('description', 'Descripción', 'trim|min_length[20]');

			$payment = $this->setting_model->get_stripe_settings();
			$statusPayment = $payment['stripe_status'];
			if ($statusPayment == 1) {

				$this->form_validation->set_rules('package', 'Package', 'trim|required');
			}

			$this->form_validation->set_rules('state', 'State', 'trim|required');

			$this->form_validation->set_rules('city', 'City', 'trim|required');

			$this->form_validation->set_rules('address', 'Street Address', 'trim|required');

			$this->form_validation->set_rules('address-lang', 'No se encuentra la dirección que ingresó. Dirección exacta', 'trim|required');


			if ($this->form_validation->run() == FALSE) {

				$response =  array('status' => 'error', 'msg' => strip_tags(validation_errors()));
				echo json_encode($response);
			}
			else
			{


				$user_id = $this->session->userdata('user_id');
				$slug = make_slug($this->input->post('title'));

				if ($statusPayment == 1) {
					$package_id = $this->input->post('package');
				} else {
					$package_id = "26";
				}

				if ($statusPayment != 1) {
					$is_payment = 1;
				}

				$payment_method = $this->input->post('payment_method');

				$data = array(
					'category' => $this->input->post('category'),
					'subcategory' => $this->input->post('subcategory'),
					'title' => ucwords($this->input->post('title')),
					'slug' => $slug,
					'price' => $this->input->post('price'),
					'negotiable' => $this->input->post('negotiable'),
					'tags' => (!empty($this->input->post('tags'))) ? $this->input->post('tags') : NULL,
					'description' => $this->input->post('description'),
					'seller' => $user_id,
					'package' => $package_id,
					'is_payment' => $is_payment,
					'country' => $this->session->userdata('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'location' => $this->input->post('address'),
					'lang' => $this->input->post('address-lang'),
					'lat' => $this->input->post('address-lat'),
					'product_code' => $product_code,
					'expiration_date_reminder' => '0',
					'expiry_date' => create_package_expiry_date($package_id)
				);

				// Images

				$path = "assets/ads/";

				// check all mendatory files
				if(empty($_FILES['img_1']['name']))
				{
					$response =  array('status' => 'error', 'msg' => 'La imagen en miniatura es obligatoria');
					echo json_encode($response);
					exit();
				}

				// thumbnail picture
				if(!empty($_FILES['img_1']['name']))
				{
					$result = $this->functions->post_file_insert($path, 'img_1', '20000');
					if($result['status'] == 1){
						$data['img_1'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
						exit();
					}
				}

				//  picture
				if(!empty($_FILES['img_2']['name']))
				{
					$result = $this->functions->post_file_insert($path, 'img_2', '20000');
					if($result['status'] == 1){
						$data['img_2'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
						exit();
					}
				}

				//  picture
				if(!empty($_FILES['img_3']['name']))
				{
					$result = $this->functions->post_file_insert($path, 'img_3', '20000');
					if($result['status'] == 1){
						$data['img_3'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
						exit();
					}
				}

				$data['video_1'] = htmlspecialchars(htmlentities($this->input->post('video_1')));
				$data['video_2'] = htmlspecialchars(htmlentities($this->input->post('video_2')));
				$data['video_3'] = htmlspecialchars(htmlentities($this->input->post('video_3')));

				$data = $this->security->xss_clean($data);

				$ad_id = $this->ad_model->add_ad($data);

				$slug = $slug.'-'.$ad_id;

				$this->ad_model->update_ad_slug_by_id($slug,$ad_id);

				// CUSTOM FIELDS

				if(isset($_POST['field']) && count($_POST['field']) > 0)
				{

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

				// MAKE PAYMENT
				if($payment_method == '2')
				{
					$payment_result = $this->pay_with_stripe($package_id,$ad_id,$payment_method);
					$payment = $payment_result['status'];
				}
				else
				{
					$payment = true;
				}

				if($payment)
				{
    				// Send Email

					$to = $this->session->userdata('email');

					$mail_data = array(
						'username' => $this->session->userdata('username'),
						'post_title' => $data['title'],
					);

					$template = $this->mailer->mail_template($to,'create-post',$mail_data);

    				// Ending Email

    				// User Notification
					$notification = array(
						'user_id' => $user_id,
						'content' => 'Su anuncio <b>'.$data['title'].'</b> está pendiente por aprobación del administrador'
					);
					$this->common_model->add_notification($notification);

    				// End Notification

					if ($statusPayment == "1") {
						//Se crea una cookie con el ID del producto y luego se leera y se traera todos los datos del producto 
						$cookie_name  = "product_code";
						$cookie_value = $product_code;

						$response =  array('status' => 'success', 'msg' => 'Su anuncio se creó correctamente', 'redirect' => 'add/pay');
						setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
						echo json_encode($response);
					} else {
						$this->session->set_flashdata('success','Su anuncio se creó correctamente.');
						$response =  array('status' => 'success', 'msg' => 'Su anuncio se creó correctamente', 'redirect' => '../../profile/ads');
						echo json_encode($response);
					}
				}
				else
				{
					$response =  array('status' => 'error', 'msg' => $payment_result['message']);
					echo json_encode($response);
				}
			}
		}
		else if ($view_payment=="pay") {

			$cookie_code = $_COOKIE['product_code'];

			$data['info_ad'] = $this->common_model->get_ad_by_product_code($cookie_code);

			$data['title'] = 'Pagar anuncio';

			$data['layout'] = 'themes/ads/ad_payment';

			$this->load->view('themes/layout', $data);

		}
		else
		{
			$data['countries'] = $this->common_model->get_countries_list();

			$data['packages'] = $this->common_model->get_packages();

			$data['title'] = 'Publicar anuncio';

			$data['layout'] = 'themes/ads/ad_add';

			$this->load->view('themes/layout', $data);
		}
	}


	function epayco_response($place="", $x_ref_payco="", $extra="") {

		if ($place=="POST") {

			if ($extra == "view") {

				$cSession = curl_init();
				curl_setopt($cSession,CURLOPT_URL,"https://secure.epayco.co/validation/v1/reference/".$x_ref_payco);
				curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($cSession,CURLOPT_HEADER, false); 
				$result=curl_exec($cSession);
				curl_close($cSession);
				$resultArray = json_decode($result, true);

				$x_ref_payco      = $resultArray['data']['x_ref_payco'];
				$x_transaction_id = $resultArray['data']['x_transaction_id'];
				$x_amount         = $resultArray['data']['x_amount'];
				$x_currency_code  = $resultArray['data']['x_currency_code'];
				$x_signature      = $resultArray['data']['x_signature'];
				$x_response       = $resultArray['data']['x_response'];
				$x_motivo         = $resultArray['data']['x_response_reason_text'];
				$x_id_invoice     = $resultArray['data']['x_id_invoice'];
				$x_autorizacion   = $resultArray['data']['x_approval_code'];
				$x_description    = $resultArray['data']['x_description'];
				$x_des_explode1   = explode("-", $x_description);
				$x_des_explode2   = explode("_", $x_des_explode1[2]);
				$ad_id            = $x_des_explode2[0];
				$user_id          = $x_des_explode2[1];
				$package_id       = $x_des_explode2[2];
				$payment_method   = $x_des_explode2[3];
				$package          = $this->ad_model->get_package_detail_by_id($package_id);
				$info_user        = $this->common_model->get_user_by_id($user_id);
				$no_of_days       = $package['no_of_days']; 
				$payer_email      = $info_user['email'];
				$x_cod_response   = $resultArray['data']['x_cod_response'];
			} else {

				$x_ref_payco      = $_REQUEST['x_ref_payco'];
				$x_transaction_id = $_REQUEST['x_transaction_id'];
				$x_amount         = $_REQUEST['x_amount'];
				$x_currency_code  = $_REQUEST['x_currency_code'];
				$x_signature      = $_REQUEST['x_signature'];
				$x_response       = $_REQUEST['x_response'];
				$x_motivo         = $_REQUEST['x_response_reason_text'];
				$x_id_invoice     = $_REQUEST['x_id_invoice'];
				$x_autorizacion   = $_REQUEST['x_approval_code'];
				$x_description    = $_REQUEST['x_description'];
				$x_des_explode1   = explode("-", $x_description);
				$x_des_explode2   = explode("_", $x_des_explode1[2]);
				$ad_id            = $x_des_explode2[0];
				$user_id          = $x_des_explode2[1];
				$package_id       = $x_des_explode2[2];
				$payment_method   = $x_des_explode2[3];
				$package          = $this->ad_model->get_package_detail_by_id($package_id);
				$info_user        = $this->common_model->get_user_by_id($user_id);
				$no_of_days       = $package['no_of_days']; 
				$payer_email      = $info_user['email'];    
				$x_cod_response   = $_REQUEST['x_cod_response'];
			}

			$payment_data = array(
				'user_id'        => $user_id,
				'txn_id'         => $x_transaction_id,
				'package_id'     => $package_id,
				'invoice_no'     => $x_id_invoice,
				'ad_id'          => $ad_id,
				'sub_total'      => $x_amount,
				'grand_total'    => $x_amount,
				'currency'       => $x_currency_code,
				'payment_method' => $payment_method,
				'payment_status' => $x_cod_response,
				'payer_email'    => $payer_email,
				'created_date'   => date('Y-m-d'),
				'due_date'       => date('Y-m-d',strtotime('+'.$no_of_days.' days')),
			);
			if ($x_cod_response == 1) {
				if (!$this->common_model->get_payment_by_id($x_id_invoice)) {

					$payment_data = $this->security->xss_clean($payment_data);

					$this->ad_model->add_payment($payment_data);

					if ($package_id == 25) {
						
						$ad_update_data = array(
							'is_featured' => 1,
							'is_search'   => 99,
							'is_interest' => 99,
							'is_payment'  => 1
						);
					} else if ($package_id == 26) {
						
						$ad_update_data = array(
							'is_featured' => 1,
							'is_search'   => 1,
							'is_interest' => 99,
							'is_payment'  => 1						
						);
					} else if ($package_id == 27) {
						
						$ad_update_data = array(
							'is_featured' => 1,
							'is_search'   => 1,
							'is_interest' => 1,
							'is_payment'  => 1
						);
					} 

					$this->ad_model->ad_update_data($ad_update_data, $ad_id);

				}
			}
		}
		else if ($place=="view") {

			$data['title'] = 'Pago finalizado';

			$data['layout'] = 'themes/ads/ad_response';

			$this->load->view('themes/layout', $data);

		}
	}

	//-----------------------------------------------------------------------------------------
	// Edit Ad
	public function edit($ad_id=0)
	{
		$data['countries'] = $this->common_model->get_countries_list();
		$data['packages'] = $this->common_model->get_packages();
		$user_id = $this->session->userdata('user_id');

		if($this->input->post()){

		     //  Set Custom Fields Validation Rules
			if(isset($_POST['field']) && count($_POST) > 0):
				foreach ($_POST['field'] as $id) 
				{
					$name = 'fd-'.$id;

					$field = $this->db->select('*')->where('id',$id)->get('ci_fields')->row_array();

					$required = ($field['required']) ? '|required' : '';

					$length = ($field['length']) ? '|min_length['.$field['length'].']' : '';

					$this->form_validation->set_rules($name, $field['name'], 'trim'.$required.$length);
				}
			endif;

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

				$response =  array('status' => 'error', 'msg' => strip_tags(validation_errors()));
				echo json_encode($response);
			}
			else
			{
				$slug = make_slug($this->input->post('title'));

				$data = array(
					'category' => $this->input->post('category'),
					'subcategory' => $this->input->post('subcategory'),
					'title' => ucwords($this->input->post('title')),
					'slug' => $slug,
					'price' => $this->input->post('price'),
					'negotiable' => $this->input->post('negotiable'),
					'tags' => (!empty($this->input->post('tags'))) ? $this->input->post('tags') : NULL,
					'description' => $this->input->post('description'),
					'is_featured' => is_featured_package($this->input->post('package')),
					'is_status' => 0,
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'location' => $this->input->post('address'),
					'lang' => $this->input->post('address-lang'),
					'lat' => $this->input->post('address-lat'),
				);

				// Images

				$path = "assets/ads/";

				// check all mendatory files
				if(empty($_POST['old_img_1']))
				{
					$response =  array('status' => 'error', 'msg' => 'La imagen en miniatura es obligatoria');
					echo json_encode($response);
				}

				// update pictures
				if(!empty($_FILES['img_1']['name']))
				{
					unlink($this->input->post('old_img_1'));

					$result = $this->functions->post_file_insert($path, 'img_1', '20000');
					if($result['status'] == 1){
						$data['img_1'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
					}
				}

				if(!empty($_FILES['img_2']['name']))
				{
					if(!empty($_POST['old_img_2']))
						unlink($this->input->post('old_img_2'));

					$result = $this->functions->post_file_insert($path, 'img_2', '20000');
					if($result['status'] == 1){
						$data['img_2'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
					}
				}

				if(!empty($_FILES['img_3']['name']))
				{
					if(!empty($_POST['old_img_3']))
						unlink($this->input->post('old_img_3'));

					$result = $this->functions->post_file_insert($path, 'img_3', '20000');
					if($result['status'] == 1){
						$data['img_3'] = $path.$result['msg'];
					}
					else
					{
						$response =  array('status' => 'error', 'msg' => $result['msg']);
						echo json_encode($response);
					}
				}

				$data['video_1'] = htmlspecialchars(htmlentities($this->input->post('video_1')));
				$data['video_2'] = htmlspecialchars(htmlentities($this->input->post('video_2')));
				$data['video_3'] = htmlspecialchars(htmlentities($this->input->post('video_3')));

				$slug = $slug.'-'.$ad_id;

				$this->ad_model->update_ad_slug_by_id($slug,$ad_id);

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

				// User Notification
				$notification = array(
					'user_id' => $user_id,
					'content' => 'Tu anuncio <b>'.ucwords($this->input->post('title')).'</b> se actualizó'
				);
				$this->common_model->add_notification($notification);

				// End Notification

				$this->session->set_flashdata('success','Su anuncio ha sido actualizado exitosamente.');
				$response =  array('status' => 'success', 'msg' => 'Su anuncio ha sido actualizado exitosamente', 'redirect' => '../../../profile/ads');
				echo json_encode($response);
			}
		}
		else{

			$data['post'] = $this->ad_model->get_ad_by_id($ad_id,$user_id);
			$data['other_detail'] = $this->ad_model->get_ad_other_detail_by_id($ad_id);

			if(!$data['post'])
			{
				$this->session->set_flashdata('error','Solicitud no válida');
				redirect('profile/ads');
			}

			if ($data['post']['is_status'] == "1") {

				redirect('profile/ads');
			} else {

				$data['title'] = 'Editar anuncio';
				$data['layout'] = 'themes/ads/ad_edit';
				$this->load->view('themes/layout', $data);
			}
		}
	}

	//-----------------------------------------------------------------------------------------
	// Delete Ad
	public function delete($id=0)
	{
		$user_id = $this->session->userdata('user_id');

		$data = $this->db->get_where('ci_ads',array('id' => $id,'seller' => $user_id))->row_array();

		if(!empty($data['img_1']))
			unlink($data['img_1']);

		if(!empty($data['img_2']))
			unlink($data['img_2']);

		if(!empty($data['img_3']))
			unlink($data['img_3']);

		if(!empty($data['video_1']))
			unlink($data['video_1']);

		if(!empty($data['video_2']))
			unlink($data['video_2']);

		if(!empty($data['video_3']))
			unlink($data['video_3']);

		$this->db->where('id',$id);
		$this->db->where('seller',$user_id);
		$this->db->delete('ci_ads');

		$this->session->set_flashdata('success','Su anuncio se eliminó correctamente.');

		redirect(base_url('profile/ads'));

	}	

	// Change Status Ad
	public function change_status($status="", $id=0)
	{
		$user_id = $this->session->userdata('user_id');
		$msg = "";
		if ($status == "sold") { 
			$status = 3;
			$msg = "vendido";
		} else if ($status=="reactivate") {
			$status = 1;
			$msg = "reactivado";
		$this->db->set('expiry_date', create_package_expiry_date(25));
		$this->db->set('expiration_date_reminder', 0);
		}
		$this->db->set('is_status', $status);
		$this->db->where('id',$id);
		$this->db->where('seller',$user_id);
		$this->db->update('ci_ads');

		$this->session->set_flashdata('success','El estado del anuncio cambió ha '.$msg.'.');

		redirect(base_url('profile/ads'));

	}

	/*
		STRIPE PAYMENT METHOD
	*/

		public function pay_with_stripe($package_id,$ad_id,$payment_method)
		{
            //get token, card and user info from the form
			$user_id = $this->session->userdata('user_id');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$card_num = $this->input->post('card-number');
			$card_cvc = $this->input->post('card-cvc');
			$card_exp_month = $this->input->post('card-expiry-month');
			$card_exp_year = $this->input->post('card-expiry-year');

            //include Stripe PHP library
			require_once APPPATH."third_party/stripe/init.php";

            //set api key
			$this->CI =& get_instance();

			$stripe_secret_key = $this->general_settings['secrate_key'];
			$stripe_publish_key = $this->general_settings['publishable_key'];
			$stripe = array(
				"secret_key"      => $stripe_secret_key,
				"publishable_key" => $stripe_publish_key
			);

			$key = \Stripe\Stripe::setApiKey($stripe['secret_key']);

            // get token
			$token = \Stripe\Token::create([
				'card' => [
					'number' => $card_num,
					'exp_month' => $card_exp_month,
					'exp_year' => $card_exp_year,
					'cvc' => $card_cvc
				]
			]);
			
			try {
			     //add customer to stripe
				$customer = \Stripe\Customer::create(array(
					'email' => $email,
					'source'  => $token
				));
			}
			catch(Stripe_CardError  $e) {
				$error = $e->getMessage();
			} catch (Stripe_InvalidRequestError $e) {
              // Invalid parameters were supplied to Stripe's API
				$error = $e->getMessage();
			} catch (Stripe_AuthenticationError $e) {
              // Authentication with Stripe's API failed
				$error = $e->getMessage();
			} catch (Stripe_ApiConnectionError $e) {
              // Network communication with Stripe failed
				$error = $e->getMessage();
			} catch (Stripe_Error $e) {
              // Display a very generic error to the user, and maybe send
              // yourself an email
				$error = $e->getMessage();
			} catch (Stripe_Validation_Error $e) {
              //Errors triggered by our client-side libraries when failing to validate fields 
              //(e.g., when a card number or expiration date is invalid or incomplete).
				$error = $e->getMessage();
			} catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
				$error = $e->getMessage();
			}

			if (isset($error))
			{
				return array('status' => false,'message' => $error);
			}

            // Package

			$package = $this->ad_model->get_package_detail_by_id($package_id);
			
			$price = $package['price'];

            //item information
			$item_name = $package['title'];
			$item_number = 1;
			$item_price = $price;
			$order_id = time().mt_rand().$user_id;
			$currency = get_currency_short_code($this->general_settings['currency']);

            //charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $item_price,
				'currency' => $currency,
				'description' => $item_number,
				'metadata' => array(
					'item_id' => $item_number
				)
			));

            //retrieve charge details
			$chargeJson = $charge->jsonSerialize();

            //check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
                //order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];

				// Save into DB
				
				$payment_data = array(
					'user_id' => $user_id,
					'txn_id' => $balance_transaction,
					'package_id' => $package_id,
					'invoice_no' => 'INV-100'.$ad_id,
					'ad_id' => $ad_id,
					'sub_total' => number_format($price,2),
					'grand_total' => number_format($price,2),
					'currency' => $currency,
					'payment_method' => $payment_method,
					'payment_status' => $status,
					'payer_email' => $email,
					'created_date' => date('Y-m-d'),
					'due_date' => date('Y-m-d',strtotime('+'.$package['no_of_days'].' days')),
				);

				$payment_data = $this->security->xss_clean($payment_data);

				$this->ad_model->add_payment($payment_data);

				if($status == 'succeeded'){
					return array('status' => true,'message' => 'El pago ha sido pagado exitosamente');
				} else {
					return array('status' => false,'message' => 'Error al guardar los datos de pago en la base de datos local');
				}


			}
			else
			{
				$package_id = $this->input->post('item_number');
				$this->session->set_flashdata('errors', 'Simbolo no valido');
				return false;
			}
		}

	// Rating

		public function update_rating()
		{

			$data = array(

				'user_id' => $this->input->post('user_id'),

				'ad_id' => $this->input->post('ad_id'),

				'rating' => $this->input->post('rating_value'),

			);

			$data = $this->security->xss_clean($data);

			$this->ad_model->update_ad_rating($data);
		}

	//---------------------------------------------------------------------
	// Save Favorite
		public function save_favorite()
		{
			if($this->input->post())
			{
				if(!$this->session->userdata('is_user_login')){
					echo 'not_login';
					exit();
				}
				
				$data = array(
					'ad_id' => $this->input->post('ad_id'),
					'user_id' => $this->session->userdata('user_id'),
				);

				$result = $this->ad_model->save_favorite($data);

				if($result){
					echo 'saved';
					exit();
				}
				else
				{
					echo 'removed';
					exit();
				}
			}
		}

		//Esta funcion genera string aleatorios para la creación del token
		public function generateRandomString($length = 15) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		} 

}// endclass