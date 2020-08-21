<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generic function to send email from the system
 * @param string $to
 * @param string $subject
 * @param string $body
 * @param string $attachment
 * @param string $cc
 * @return string
 */



function sendEmail($to = '', $subject  = '', $body = '', $attachment = '', $cc = '') {
    
    $controller =& get_instance();
    $controller->load->helper('path');
    $controller->load->library("sendMailer");
    $mail = new sendMailer();

    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host     = $controller->general_settings['smtp_host']; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->CharSet  = 'UTF-8';
    $mail->Username = $controller->general_settings['smtp_user']; // Correo completo a utilizar
    $mail->Password = $controller->general_settings['smtp_pass']; // Contraseña
    $mail->Port     = $controller->general_settings['smtp_port']; // Puerto a utilizar
    $mail->From     = $controller->general_settings['email_from']; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "laferiadeaudio.com";
    $mail->AddAddress($to); // Esta es la dirección a donde enviamos
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject  = $subject; // Este es el titulo del email.
    $mail->Body     = $body; // Mensaje a enviar


    if ($cc != '') {
        $mail->AddAddress($cc);
    }

    if ($attachment != '') {
        $mail->AddAttachment(base_url() . "uploads/invoices/" . $attachment);
    }
    
    $exito = $mail->Send(); // Envía el correo.

    if($exito){
        return 'success';
    }else{
        echo 'Hubo un inconveniente. Contacta a un administrador.';
    }
}

function sendEmailToAdmin($subject  = '', $body = '', $attachment = '', $cc = '')
{
    $to = "adsoft@adsoft.com.co";

    $controller =& get_instance();
    $controller->load->helper('path');
    $controller->load->library("sendMailer");
    $mail = new sendMailer();

    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host     = $controller->general_settings['smtp_host']; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->CharSet  = 'UTF-8';
    $mail->Username = $controller->general_settings['smtp_user']; // Correo completo a utilizar
    $mail->Password = $controller->general_settings['smtp_pass']; // Contraseña
    $mail->Port     = $controller->general_settings['smtp_port']; // Puerto a utilizar
    $mail->From     = $controller->general_settings['email_from']; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "laferiadeaudio.com";
    $mail->AddAddress($to); // Esta es la dirección a donde enviamos
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject  = $subject; // Este es el titulo del email.
    $mail->Body     = $body; // Mensaje a enviar


    if ($cc != '') {
        $mail->AddAddress($cc);
    }

    if ($attachment != '') {
        $mail->AddAttachment(base_url()."your_file_path/" .$attachment);
    }
    
    $exito = $mail->Send(); // Envía el correo.

    if($exito){
        return 'success';
    }else{
        echo 'Hubo un inconveniente. Contacta a un administrador.';
    }
}
?>