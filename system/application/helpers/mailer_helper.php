<?php
    function send_mail($mailto,$message,$config) {
        $CI =& get_instance();
        $CI->load->library('lib/PHPMailer');
        $CI->phpmailer->CharSet = "utf-8";
        
        $CI->phpmailer->IsSMTP();  // telling the class to use SMTP
        $CI->phpmailer->SMTPAuth = true;
        $CI->phpmailer->Host = $config['smtp_host'];
        $CI->phpmailer->Port = $config['smtp_port'];
        $CI->phpmailer->Username = $config['smtp_user'];
        $CI->phpmailer->Password = $config['smtp_pass'];

        $CI->phpmailer->SetFrom($config['mail'], $config['from']);
        $CI->phpmailer->AddAddress($mailto); 
        $CI->phpmailer->Subject = $config['subject'];
        $CI->phpmailer->MsgHTML($message);
        return $CI->phpmailer->Send(); 
    }
?>
