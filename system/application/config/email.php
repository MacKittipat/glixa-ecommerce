<?php


//    $config['smtp_host'] = 'ssl://smtp.gmail.com'; // SMTP HOST
//    $config['smtp_port'] = 465; // SMTP PORT
//    $config['smtp_user'] = 'admin@glixa.com'; // SMTP USER
//    $config['smtp_pass'] = 'bank49215734'; // SMTP PASS


    $config['smtp_host'] = '127.0.0.1'; // SMTP HOST
    $config['smtp_port'] = 25; // SMTP PORT
    $config['smtp_user'] = 'Mac'; // SMTP USER
    $config['smtp_pass'] = 'mac'; // SMTP PASS

    // Mail สำหรับ Register
    $config['regis_mail'] = 'customerservice@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['regis_from'] = 'customerservice@glixa.com'; // ชื่อของเข้าของ email
    $config['regis_subject'] = 'Welcome to Glixa.com'; // subject ของ mail

    // Mail สำหรับ Lost Password
    $config['lost_password_mail'] = 'customerservice@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['lost_password_from'] = 'customerservice@glixa.com'; // ชื่อของเข้าของ email
    $config['lost_password_subject'] = 'แจ้งรหัสผ่าน'; // subject ของ mail

    // Mail สำหรับตอน Send Payment
    $config['send_payment_mail'] = 'no-reply@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['send_payment_from'] = 'Payment Alert'; // ชื่อของเข้าของ email
    $config['send_payment_subject'] = 'Payment Alert'; // subject ของ mail

    // Mail สำหรับตอน Send Payment
    $config['activate_mail'] = 'customerservice@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['activate_from'] = 'customerservice@glixa.com'; // ชื่อของเข้าของ email
    $config['activate_subject'] = 'Activate'; // subject ของ mail

    // Mail สำหรับตอน Admin Send Payment
    $config['admin_send_payment_mail'] = 'customerservice@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['admin_send_payment_from'] = 'customerservice@glixa.com'; // ชื่อของเข้าของ email
    $config['admin_send_payment_subject'] = 'แจ้งสินค้าที่ถูกขาย'; // subject ของ mail

    // Mail สำหรับส่งไปบอกเจ้าของสินค้าว่ามีคนถามคำถาม
    $config['user_product_question_mail'] = 'customerservice@glixa.com'; // mail ที่ส่งไปหา user เมื่อ register
    $config['user_product_question_from'] = 'customerservice@glixa.com'; // ชื่อของเข้าของ email
    $config['user_product_question_subject'] = 'แจ้งสินค้าที่ถูกถามคำถาม'; // subject ของ mail

    // Mail ส่งกลับไปหาคนถามสินค้า
    $config['user_product_answer_mail'] = 'customerservice@glixa.com';
    $config['user_product_answer_from'] = 'customerservice@glixa.com';
    $config['user_product_answer_subject'] = 'แจ้งสินค้าถูกตอบคำถาม';


?>
