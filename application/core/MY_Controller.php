<?php
	class MY_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			if(!$this->session->has_userdata('is_admin_login'))
			{
				// redirect('admin/auth/login', 'refresh');
			}

			/* -----------------  ------------------------------------------------------/
			/				Javascript Scripting Prevention Code 						/
			/--------------------------------------------------------------------------*/
			
			$current = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$patern = '/%3C\s*[a-zA-Z](.*)%3E/';
			$found = preg_match($patern,$current);
			if($found)
			{
				$current = preg_replace('/%3C\s*[a-zA-Z](.*)%3E/','REMOVED', $current);
				redirect($current);
			}
			//

			//general settings
	        $global_data['general_settings'] = $this->setting_model->get_general_settings();
	        $this->general_settings = $global_data['general_settings'];

	        //set timezone
	        date_default_timezone_set($this->general_settings['timezone']);

	        

		}
	}

	class Main_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			/* -----------------  ------------------------------------------------------/
			/				Javascript Scripting Prevention Code 						/
			/--------------------------------------------------------------------------*/
			
			$current = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$patern = '/%3C\s*[a-zA-Z](.*)%3E/';
			$found = preg_match($patern,$current);
			if($found)
			{
				$current = preg_replace('/%3C\s*[a-zA-Z](.*)%3E/','REMOVED', $current);
				redirect($current);
			}
			//

			//general settings
	        $global_data['general_settings'] = $this->setting_model->get_general_settings();
	        $this->general_settings = $global_data['general_settings'];
	        
	        //set timezone
	        date_default_timezone_set($this->general_settings['timezone']);

	        //recaptcha status
	        $global_data['recaptcha_status'] = true;
	        if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key'])) {
	            $global_data['recaptcha_status'] = false;
	        }
	        $this->recaptcha_status = $global_data['recaptcha_status'];

	        //languages
	        $global_data['languages'] = get_languages_list();
	        $this->languages = $global_data['languages'];

	        //site lang

	        $user_lang = $this->session->userdata('site_lang');
	        $user_lang = (isset($user_lang)) ? $user_lang : $this->general_settings['language'];
	        $global_data['site_lang'] = get_language_by_id($user_lang);
	        
	        if (empty($global_data['site_lang'])) {
	            $global_data['site_lang'] = get_language_by_id('1');
	        }

	        $global_data['selected_lang'] = $global_data['site_lang']['name'];
	        $this->selected_lang = $global_data['site_lang']['name'];

	        // Load language files
	        $lang_files = array('site');
	        $this->lang->load($lang_files,$this->selected_lang);

		}

		//verify recaptcha
	    public function recaptcha_verify_request()
	    {
	        if (!$this->recaptcha_status) {
	            return true;
	        }

	        $this->load->library('recaptcha');
	        $recaptcha = $this->input->post('g-recaptcha-response');
	        if (!empty($recaptcha)) {
	            $response = $this->recaptcha->verifyResponse($recaptcha);
	            if (isset($response['success']) && $response['success'] === true) {
	                return true;
	            }
	        }
	        return false;
	    }

	}
?>