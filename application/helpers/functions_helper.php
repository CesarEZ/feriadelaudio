<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    // -----------------------------------------------------------------------------
    //check auth
    if (!function_exists('auth_check')) {
        function auth_check()
        {
            // Get a reference to the controller object
            $ci =& get_instance();
            if(!$ci->session->has_userdata('is_admin_login'))
            {
                redirect('admin/auth/login', 'refresh');
            }
        }
    }

    // -----------------------------------------------------------------------------
    // Make Slug Function    
    if (!function_exists('make_slug'))
    {
       function make_slug($string)
        {
            $lower_case_string = strtolower($string);
            return url_title($lower_case_string);
        }
    }

     // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings()
        {
            $ci =& get_instance();
            $ci->load->model('admin/setting_model');
            return $ci->setting_model->get_general_settings();
        }
    }

    // -----------------------------------------------------------------------------
    //get recaptcha
    if (!function_exists('generate_recaptcha')) {
        function generate_recaptcha()
        {
            $ci =& get_instance();
            if ($ci->recaptcha_status) {
                $ci->load->library('recaptcha');
                echo '<div class="form-group mt-2">';
                echo $ci->recaptcha->getWidget();
                echo $ci->recaptcha->getScriptTag();
                echo ' </div>';
            }
        }
    }

    //---------------------------------------------------------------------
    // Pagination Association function
    function pagination_assoc($varkey, $assoc_n)
    {
        $ci =& get_instance();
        
        $qs_arr = $ci->uri->uri_to_assoc($assoc_n);
        $qs_tmp_arr = array();

        foreach ($qs_arr as $key => $value) {
            if ($key != $varkey) {
                $qs_tmp_arr[$key] = $value;
                $assoc_n = 0;
            }
        }

        foreach ($ci->uri->segment_array() as $key => $value) {
            if ($value == 'p') {
                $assoc_n = $key;
            }
        }

        $offset = (isset($qs_arr [$varkey]))? $qs_arr[$varkey]: 0;

        $qs_uri = $ci->uri->assoc_to_uri($qs_tmp_arr). '/'. $varkey;

        $arr = array(
            'offset' => $offset,
            'seg' => $assoc_n + 1,
            'uri' => $qs_uri
        );

        return $arr;

    }

     // ----------------------------------------------------------------------------
    //print old form data
    if (!function_exists('old')) {
        function old($field)
        {
            $ci =& get_instance();
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }

    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Menu
    if (!function_exists('get_sidebar_menu')) {
        function get_sidebar_menu()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('ci_module')->result_array();
        }
    }

    // -----------------------------------------------------------------------------
    // Footer Settings
    if (!function_exists('get_footer_settings')) {
        function get_footer_settings()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            return $ci->db->get('ci_footer_settings')->result_array();
        }
    }

    // -----------------------------------------------------------------------------
    // Generate User Menu
    if (!function_exists('get_user_menu')) {
        function get_user_menu()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('ci_menu')->result_array();
        }
    }

    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Sub Menu
    if (!function_exists('get_sidebar_sub_menu')) {
        function get_sidebar_sub_menu($parent_id)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->order_by('sort_order','asc');
            $ci->db->where('parent',$parent_id);
            return $ci->db->get('ci_sub_module')->result_array();
        }
    }

    // -----------------------------------------------------------------------------
    // Get Field options in custom fields
    if (!function_exists('get_field_options')) {
        function get_field_options($field_id)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->where('parent_field',$field_id);
            return $ci->db->get('ci_field_options')->result_array();
        }
    }  

    // -----------------------------------------------------------------------------
    function clean_url($string)
     {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
        $string = preg_replace('/-+/', '-', $string); //
        return $result = strtolower($string);
     
     }    

    // -----------------------------------------------------------------------------
    function time_ago($date) {
        if(empty($date)) {
            return "No date provided";
        }
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);
        // check validity of date
        if(empty($unix_date)) {
            return "";
        }
        // is it future date or past date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

    // --------------------------------------------------------------------------------
    function date_time($datetime) 
    {
       return date('F j, Y',strtotime($datetime));
    }

    // --------------------------------------------------------------------------------
    // limit the no of characters
    function text_limit($x, $length)
    {
      if(strlen($x)<=$length)
      {
        echo $x;
      }
      else
      {
        $y=substr($x,0,$length) . '...';
        echo $y;
      }
    }

    //-----------------------------------------------------------------------------
    function encode($input) 
    {
        return urlencode(base64_encode($input));
    }
    
    //-----------------------------------------------------------------------------
    function decode($input) 
    {
        return base64_decode(urldecode($input) );
    }

    //get translated message
    if (!function_exists('trans')) {
        function trans($string)
        {
            $ci =& get_instance();
            return $ci->lang->line($string);
        }
    }

?>