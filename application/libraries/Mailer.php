<?php

class Mailer 

{

    function __construct()

    {

        $this->CI =& get_instance();

    }



    //=============================================================

    // Eamil Templates

    function mail_template($to = '',$slug = '',$mail_data = '')

    {



        $template =  $this->CI->db->get_where('ci_email_templates',array('slug' => $slug))->row_array();

        

        // var_dump($template);exit();



        $body = $template['body'];



        $template_id = $template['id'];



        $data['head'] = $subject = $template['subject'];



        $data['content'] = $this->mail_template_variables($body,$slug,$mail_data);



        $data['title'] = $template['name'];



        $template =  $this->CI->load->view('admin/general_settings/email_templates/email_preview', $data,true);

        

        sendEmail($to,$subject,$template);



        return true;

    }



    //=============================================================

    // GET Eamil Templates AND REPLACE VARIABLES

    function mail_template_variables($content,$slug,$data = '')

    {

        switch ($slug) {

            case 'login-alert':

                $content = str_replace('{USERNAME}',$this->CI->session->userdata('username'),$content);

                $content = str_replace('{TIMESTAMP}',date('F j, Y H:i:s'),$content);

                return $content;

            break;



            case 'email-verification':

                $content = str_replace('{TIMESTAMP}',date('F j, Y H:i:s'),$content);

                $content = str_replace('{VERIFICATION_LINK}','LINK HERE');

                return $content;

            break;



            case 'welcome':

                $content = str_replace('{USERNAME}',$this->CI->session->userdata('username'),$content);

                return $content;

            break;



            case 'forget-password':

                $content = str_replace('{USERNAME}',$data['username'],$content);

                $content = str_replace('{RESET_LINK}',$data['reset_link'],$content);

                return $content;

            break;



            case 'ad-post':

                $content = str_replace('{USERNAME}',$data['username'],$content);

                $content = str_replace('{POST_TITLE}',$data['post_title'],$content);

                $content = str_replace('{POST_LINK}',$data['post_link'],$content);

                return $content;

            break;



            case 'create-post':

                $content = str_replace('{USERNAME}',$data['username'],$content);

                $content = str_replace('{POST_TITLE}',$data['post_title'],$content);

                return $content;

            break;



            case 'general-notification':

                $content = str_replace('{CONTENT}',$data['content'],$content);

                return $content;

            break;



            case 'message-alert':

                $content = str_replace('{MESSAGE}',$data['message'],$content);

                $content = str_replace('{POST_LINK}',$data['post_link'],$content);

                $content = str_replace('{POST_TITLE}',$data['post_title'],$content);

                return $content;

            break;

            

            default:

                # code...

                break;

        }

    }

    

    //=============================================================

    function send_verification_email($user_id)

    {

        $user = $this->CI->db->get_where('ci_users',array('id' => $user_id))->row_array();



        $token = md5((string)date('YmdHis'));



        // Update Token

        $this->CI->db->where(array('id' => $user_id))->update('ci_users',array('token' => $token));



        // Get Email Template

        $temp =  $this->CI->db->get_where('ci_email_templates',array('slug' => 'email-verification'))->row_array();



        $to = $user['email'];



        $varification_link = base_url('register/validate_email/'.$token);



        $data['content'] = str_replace('{VERIFICATION_LINK}',$varification_link,$temp['body']);



        $data['head'] = $temp['subject'];



        $data['title'] = $temp['name'];



        $template =  $this->CI->load->view('admin/general_settings/email_templates/email_preview', $data,true);

        

        sendEmail($to,$temp['subject'],$template);



        return true;



    }   



}

?>