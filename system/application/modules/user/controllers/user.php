<?php
class User extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_category_model');
    }
    /* user register */
    public function register() {
        if(is_user_login()) {
            redirect();
        }
        /* set page title and view */
        $data['page_title'] = 'สมัครสมาชิก'; // ชื่อเพจ
        $data['user_content'] = 'user/content/user_register'; // view ชองเพจนี้
        $data['page_content'] = 'user/user_view'; // view หลักของ Controller User
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'user/register'));
        /* other code */
        $this->load->model('user_profile_model');
        $this->load->library('form_validation');
        $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
        $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
        $validation_config = get_validation_config(array(
            array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'password'),
            array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'firstname'),
            array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'lastname')
        ), 'register');
        $this->form_validation->set_rules($validation_config);
        $this->form_validation->set_rules('txt_email_register', get_field_lang('wive_user', 'email', 'validate'), 'trim|required|valid_email|unique[wive_user.email]');
        $this->form_validation->set_rules('txt_cpassword_register', get_field_lang('wive_user', 'cpassword', 'validate'), 'trim|required|matches[txt_password_register]');
        $this->form_validation->set_rules('txt_username_register', get_field_lang('wive_user', 'username', 'validate'), 'trim|required|unique[wive_user.username]|eng_num|deny_username|min_length[3]|max_length[50]');
        // กด submit register
        if($this->form_validation->run()==true) {
            // check form key
            if(validation_form_key($this->input->post('hid_form_key'))==true) {
                $this->user_model->register(array(
                    'email'=>$this->input->post('txt_email_register'),
                    'password'=>$this->input->post('txt_password_register'),
                    'username'=>strtolower($this->input->post('txt_username_register')),
                    'firstname'=>$this->input->post('txt_firstname_register'),
                    'lastname'=>$this->input->post('txt_lastname_register'),
                    'regis_date'=>date("Y-m-d H:i:s")
                ));
                // add user profile
                $user_data = $this->user_model->get_user('email', $this->input->post('txt_email_register'));
                $this->user_profile_model->add_user_profile(array(
                    'user_id'=>$user_data['id']
                ));


                // Send mail
                $this->config->load('email');
                $this->load->library('lib/PHPMailer');
                $mail = new PHPMailer();
                
                $mail->CharSet = "utf-8";

                $mail->IsSMTP();  // telling the class to use SMTP
                $mail->SMTPAuth = true;
                $mail->Host = $this->config->item('smtp_host');
                $mail->Port = $this->config->item('smtp_port');
                $mail->Username = $this->config->item('smtp_user');
                $mail->Password = $this->config->item('smtp_pass');

                $mail->SetFrom($this->config->item('activate_mail'), $this->config->item('activate_from'));
                $mail->AddAddress($this->input->post('txt_email_register'));
                $mail->Subject = $this->config->item('activate_subject');
                $data['url'] = base_url().'user/activate/'.strtolower($this->input->post('txt_username_register')).'/'.sha1(trim($this->input->post('txt_email_register')).md5(trim($this->input->post('txt_password_register'))));
                $mail->MsgHTML($this->load->view('mail_template/activate_mail',$data,true));
                $mail->Send();
                $data['user_content'] = 'user/content/user_register_success'; // view ชองเพจนี้


                
//                $this->config->load('email');
//                $this->load->helper('mailer');
//                $config['smtp_host'] = $this->config->item('smtp_host');
//                $config['smtp_port'] = $this->config->item('smtp_port');
//                $config['smtp_user'] = $this->config->item('smtp_user');
//                $config['smtp_pass'] = $this->config->item('smtp_pass');
//                $config['mail'] = $this->config->item('activate_mail');
//                $config['from'] = $this->config->item('activate_from');
//                $config['subject'] = $this->config->item('activate_subject');
//                $data['url'] = base_url().'user/activate/'.strtolower($this->input->post('txt_username_register')).'/'.sha1(trim($this->input->post('txt_email_register')).md5(trim($this->input->post('txt_password_register'))));
//                send_mail($this->input->post('txt_email_register'),$this->load->view('mail_template/activate_mail',$data,true),$config);
//                $data['user_content'] = 'user/content/user_register_success'; // view ชองเพจนี้
            }
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function activate() {

        // เช็ควว่า user available = true หรือไม่
        $user_data = $this->user_model->get_user('username',$this->uri->segment(3));
        if($user_data==null) { // ไม่มี user นี้
            redirect();
        }
        // เช็คว่า activate code ถูก
        $v1 = sha1($user_data['email'].$user_data['password']);
        $v2 = $this->uri->segment(4);
        if($v1!=$v2) { // activate code ไม่ถูก
            echo 'Activate ไม่สำเร็จ';
        } else {
            // set avaliable = true
            $this->user_model->edit_user('username',$this->uri->segment(3),array(
                'available'=>true
            ));
            // send mail
            $this->config->load('email');
            $this->load->helper('mailer');
            $config['smtp_host'] = $this->config->item('smtp_host');
            $config['smtp_port'] = $this->config->item('smtp_port');
            $config['smtp_user'] = $this->config->item('smtp_user');
            $config['smtp_pass'] = $this->config->item('smtp_pass');
            $config['mail'] = $this->config->item('regis_mail');
            $config['from'] = $this->config->item('regis_from');
            $config['subject'] = $this->config->item('regis_subject');
            $data['username'] = $user_data['username'];
            $data['email'] = $user_data['email'];
            $data['firstname'] = $user_data['firstname'];
            $data['lastname'] = $user_data['lastname'];
            send_mail($user_data['email'],$this->load->view('mail_template/regis_mail',$data,true),$config);
            // login
            $wive_login = array(
                'email'=>$user_data['email'],
                'level'=>$user_data['level']
            );
            do_login($wive_login, true);
            redirect();
        }
    }
    /* user login */
    public function login() {
        if(is_user_login ()) {
            redirect();
        }
        /* set page title and view */
        $data['page_title'] = 'เข้าสู่ระบบ';
        $data['user_content'] = 'user/content/user_login';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'user/login'));
        /* other code */
        $data['msg_login_error'] = '';
        $this->load->library('form_validation');
        $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
        $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
        $validation_config = get_validation_config(array(
            array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'password')
        ), 'login');
        $this->form_validation->set_rules($validation_config);
        // เช็คว่าเป็น mail หรือ username
        if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this->input->post('txt_email_login'))) {
            // เช็คว่า user available=false หรือไม่ ถ้าใช่จะส่ง mail activate ไปหา user 
            $u = $this->user_model->get_user('email',$this->input->post('txt_email_login'));
            if(count($u)>0 && $u['available']=='0') {
                $data['message'] = "<div class='msg_form_complete'>Account ของท่านยังไม่ได้ทำการ Activate และระบได้ทำการส่งอีเมลเพื่อทำการ Activate ให้ท่านแล้ว กรุณาตรวจสอบอีเมลของท่าน(รวมถึง Junk Mail)</div>";
                $user_data = $this->user_model->get_user('email', $this->input->post('txt_email_login'));
                $this->config->load('email');
                $this->load->helper('mailer');
                $config['smtp_host'] = $this->config->item('smtp_host');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_user'] = $this->config->item('smtp_user');
                $config['smtp_pass'] = $this->config->item('smtp_pass');
                $config['mail'] = $this->config->item('activate_mail');
                $config['from'] = $this->config->item('activate_from');
                $config['subject'] = $this->config->item('activate_subject');
                $data['url'] = base_url().'user/activate/'.$user_data['username'].'/'.sha1($user_data['email'].$user_data['password']);
                send_mail($user_data['email'],$this->load->view('mail_template/activate_mail',$data,true),$config);
            } else {
                $this->form_validation->set_rules('txt_email_login', 'E-mail / อีเมล', 'trim|required|valid_email|have[wive_user.email]');
                // กด submit register
                if($this->form_validation->run() == true) {
                    // เช็คว่ามี email / password นี้ใน DB หรือไม่
                    if($this->user_model->login_success($this->input->post('txt_email_login'), $this->input->post('txt_password_login'))==true) {
                        $user_data = $this->user_model->get_user('email', $this->input->post('txt_email_login'));
                        $wive_login = array(
                            'email'=>$this->input->post('txt_email_login'),
                            'level'=>$user_data['level']
                        );
                        $remember = false;
                        // check remember จะสร้าง cookie
                        if($this->input->post('chk_remember_login')) { // cookie
                            $remember = true;
                        }
                        do_login($wive_login, $remember);
                    }else { // Login ไม่สำเร็จ
                        $data['msg_login_error'] = '<span class="msg_form_error">Password / รหัสผ่าน ไม่ถูกต้อง กรุณาลองใหม่</span>';
                    }
                }
            }
        } else { // username
            $u = $this->user_model->get_user('username',$this->input->post('txt_email_login'));
            if(count($u)>0 && $u['available']=='0') {
                $data['message'] = "<div class='msg_form_complete'>Account ของท่านยังไม่ได้ทำการ Activate และระบได้ทำการส่งอีเมลเพื่อทำการ Activate ให้ท่านแล้ว กรุณาตรวจสอบอีเมลของท่าน(รวมถึง Junk Mail)</div>";
                $user_data = $this->user_model->get_user('username', $this->input->post('txt_email_login'));
                $this->config->load('email');
                $this->load->helper('mailer');
                $config['smtp_host'] = $this->config->item('smtp_host');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_user'] = $this->config->item('smtp_user');
                $config['smtp_pass'] = $this->config->item('smtp_pass');
                $config['mail'] = $this->config->item('activate_mail');
                $config['from'] = $this->config->item('activate_from');
                $config['subject'] = $this->config->item('activate_subject');
                $data['url'] = base_url().'user/activate/'.$user_data['username'].'/'.sha1($user_data['email'].$user_data['password']);
                send_mail($user_data['email'],$this->load->view('mail_template/activate_mail',$data,true),$config);
            } else {
                $this->form_validation->set_rules('txt_email_login', 'Shop Name / ชื่อร้านค้า', 'trim|required|have[wive_user.username]');
                // กด submit register
                if($this->form_validation->run() == true) {
                    if($this->user_model->username_login_success(strtolower($this->input->post('txt_email_login')), $this->input->post('txt_password_login'))==true) {
                        $user_data = $this->user_model->get_user('username', $this->input->post('txt_email_login'));
                        $wive_login = array(
                            'email'=>$user_data['email'],
                            'level'=>$user_data['level']
                        );
                        $remember = false;
                        // check remember จะสร้าง cookie
                        if($this->input->post('chk_remember_login')) { // cookie
                            $remember = true;
                        }
                        do_login($wive_login, $remember);
                    }else { // Login ไม่สำเร็จ
                        $data['msg_login_error'] = '<span class="msg_form_error">Password / รหัสผ่าน ไม่ถูกต้อง กรุณาลองใหม่</span>';
                    }
                }
            }
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    /* user profile / edit profile */
    public function profile() {
        if(is_user_login()==true) {
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลส่วนตัว';
            $data['user_content'] = 'user/content/user_profile';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'user/profile'));
            /* other code */
            $this->load->model('user_address_model');
            $this->load->model('user_profile_model');
            $this->load->model('user_shop_model');
            $this->load->helper('upload');
            $login_info = get_login_info();
            $user_data = $this->user_model->get_user('email', $login_info['email']);
            $data['user_data'] = $user_data;
            $user_profile_data = $this->user_profile_model->get_user_profile('user_id', $user_data['id']);
            $data['user_profile_data'] = $user_profile_data;
            $user_address_data = $this->user_address_model->get_user_address('', '', 'user_id="'.$user_data['id'].'" AND flag_del<>1');
            $data['user_address_data'] = $user_address_data;
            $data['user_shop_data'] = $this->user_shop_model->get_user_shop('user_id', $user_data['id']);
            $this->load->library('form_validation');
            $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
             // submit profile
            if($this->input->post('btn_profile')) {
                $validation_config = get_validation_config(array(
                    array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'firstname'),
                    array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'lastname'),
                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'identity_number'),
//                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'address'),
//                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'tambon'),
//                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'amphoe'),
//                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'province'),
//                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'postalcode'),
                    array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'tel_num')
                ), 'edit_profile');
                $this->form_validation->set_rules($validation_config);
                // กด submit edit profile
                if($this->form_validation->run() == true) {
                    // check form key
                    if(validation_form_key($this->input->post('hid_form_key'))==true) {
                        $this->user_model->edit_user('email', $login_info['email'], array(
                            'firstname' => $this->input->post('txt_firstname_edit_profile'),
                            'lastname' => $this->input->post('txt_lastname_edit_profile')
                        ));
                        // edit user profile
                        $this->user_profile_model->edit_user_profile('user_id', $user_data['id'], array(
                            'identity_number'=>$this->input->post('txt_identity_number_edit_profile'),
                            'address'=>$this->input->post('txt_address_edit_profile'),
                            'tambon'=>$this->input->post('txt_tambon_edit_profile'),
                            'amphoe'=>$this->input->post('txt_amphoe_edit_profile'),
                            'province'=>$this->input->post('txt_province_edit_profile'),
                            'postalcode'=>$this->input->post('txt_postalcode_edit_profile'),
                            'tel_num'=>($this->input->post('txt_tel_num_edit_profile')=='') ? null : $this->input->post('txt_tel_num_edit_profile'),
                        ));
                        $_SESSION['message'] = "<div class='msg_form_complete'>แก้ไขข้อมูลส่วนตัวเสร็จสมบูรณ์</div>";
                        redirect('user/profile');
                    }
                }
            }
            // submit shop profile
            if($this->input->post('btn_shop')) {
                $validation_config = get_validation_config(array(
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'email'),
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'tel_num'),
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'facebook_id'),
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'description'),
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'promotion'),
                    array('prefix'=>'txt', 'table'=>'shop_user_shop', 'field'=>'instruction')
                ), '');
                $this->form_validation->set_rules($validation_config);
                if($this->form_validation->run() == true) {
                    $shop_image = '';
                    if($this->input->post('hid_shop_image')) {
                        $shop_image = $this->input->post('hid_shop_image');
                    }
                    if($_FILES['file_shop_image']['name']!=null) {
                        $file_path_info = pathinfo($_FILES['file_shop_image']['name']);
                        $new_file_name = $user_data['username'].'_shop';
                        $shop_image = 'userfile/shop/'.$new_file_name.'.'.$file_path_info['extension'];
                        $shop_image_error = do_upload('file_shop_image', array(
                            'file_name'=>$new_file_name,
                            'upload_path'=>'./userfile/shop',
                            'allowed_types'=>'gif|jpg|png',
                            'max_size'=>'500',
                            'overwrite'=>true
                        ));
                        $_SESSION['error'] = $shop_image_error;
                    }
                    if(!isset($_SESSION['error'])) { // ไม่มี error จาก upload 
                        if(count($data['user_shop_data'])!=0) { // update
                            $this->user_shop_model->edit_user_shop('user_id',$user_data['id'] ,array(
                                'image'=>($shop_image!='') ? $shop_image : NULL,
                                'email'=>$this->input->post('txt_email'),
                                'tel_num'=>$this->input->post('txt_tel_num'),
                                'facebook_id'=>$this->input->post('txt_facebook_id'),
                                'description'=>$this->input->post('txt_description'),
                                'promotion'=>$this->input->post('txt_promotion'),
                                'instruction'=>$this->input->post('txt_instruction'),
                                'user_address_id'=>($this->input->post('ddl_address')==true) ? $this->input->post('ddl_address') : NULL
                            ));
                        } else { // add new shop data
                            $this->user_shop_model->add_user_shop(array(
                                'image'=>($shop_image!='') ? $shop_image : NULL,
                                'email'=>$this->input->post('txt_email'),
                                'tel_num'=>$this->input->post('txt_tel_num'),
                                'facebook_id'=>$this->input->post('txt_facebook_id'),
                                'description'=>$this->input->post('txt_description'),
                                'promotion'=>$this->input->post('txt_promotion'),
                                'instruction'=>$this->input->post('txt_instruction'),
                                'user_address_id'=>($this->input->post('ddl_address')) ?  $this->input->post('ddl_address') : NULL,
                                'user_id'=>$user_data['id']
                            ));
                        }
                        $_SESSION['message'] = "<div class='msg_form_complete'>แก้ไขข้อมูลร้านค้าเสร็จสมบูรณ์</div>";
                    }
                    
                    redirect('user/profile');
                }
            }

            /* load view */
            $this->load->view('main_view', $data);
            if(isset($_SESSION['error'])) {
                unset($_SESSION['error']);
            }
            
        } else {
            redirect();
        }
    }
    /* user edit password */
    public function edit_password() {
        if(is_user_login()==false) {
            redirect();
        }
        /* set page title and view */
        $data['page_title'] = 'เปลี่ยนรหัสผ่าน';
        $data['user_content'] = 'user/content/user_edit_password';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>'user/edit_password'));
        /* other code */
        $data['message'] = "";
        $this->load->helper('table_field');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt_old_password', get_field_lang('shop_user_edit_password', 'old_password', 'validate'), 'required');
        $this->form_validation->set_rules('txt_password', get_field_lang('shop_user_edit_password', 'new_password', 'validate'), 'required');
        $this->form_validation->set_rules('txt_cpassword', get_field_lang('shop_user_edit_password', 'confirm_new_password', 'validate'), 'required|matches[txt_password]');
        // กด submit edit password
        if($this->form_validation->run()==true && validation_form_key($this->input->post('hid_form_key'))==true) {
            $login_info = get_login_info();
            // รหัสผ่านเก่าถูกต้อง
            if($this->user_model->login_success($login_info['email'], $this->input->post('txt_old_password'))==true) {
                $this->user_model->edit_user('email',$login_info['email'],array(
                    'password'=>md5($this->input->post('txt_password'))
                ));
                $data['message'] = "<div class='msg_form_complete'>เปลี่ยนรหัสผ่านเสร็จสมบูรณ์</div>";
                
            } else {
                $data['error_message'] = 'รหัสผ่านเดิม ไม่ถูกต้อง';
            }
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function lost_password() {
        if(is_user_login ()) {
            redirect();
        }
        /* set page title and view */
        $data['page_title'] = 'ลืมรหัสผ่าน';
        $data['user_content'] = 'user/content/user_lost_password';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>'user/lost_password'));
        /* other code */
        $this->load->library('form_validation');
        // กด submit
        $this->load->helper('string');
        $new_pass = random_string('alnum', 10);
        $this->form_validation->set_rules('txt_email', 'อีเมลที่ใช้สมัครสมาชิก', 'required|valid_email|have[wive_user.email]');
        if($this->form_validation->run()==true && validation_form_key($this->input->post('hid_form_key'))==true) {
            // แก้ pass เดิม
            $this->user_model->edit_user('email', $this->input->post('txt_email'), array(
                'password'=>md5($new_pass)
            ));
            // ส่ง pass ใหม่ไปทาง mail
            // Send mail
            $this->config->load('email');
            $this->load->helper('mailer');
            $config['smtp_host'] = $this->config->item('smtp_host');
            $config['smtp_port'] = $this->config->item('smtp_port');
            $config['smtp_user'] = $this->config->item('smtp_user');
            $config['smtp_pass'] = $this->config->item('smtp_pass');
            $config['mail'] = $this->config->item('lost_password_mail');
            $config['from'] = $this->config->item('lost_password_from');
            $config['subject'] = $this->config->item('lost_password_subject');
            $data['new_password'] = $new_pass;
            $user_data = $this->user_model->get_user('email', $this->input->post('txt_email'));
            $data['firstname'] = $user_data['firstname'];
            $data['lastname'] = $user_data['lastname'];
            send_mail($this->input->post('txt_email'),$this->load->view('mail_template/lost_password_mail',$data,true),$config);
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    /* user logout */
    public function logout() {
        session_unset($_SESSION['wive_login']);
        setcookie('wive_login', '', time()-2592000, '/');
        $this->load->library('cart');
        // ลบ cart
        foreach($this->cart->contents() as $item) {
            $this->cart->update(array(
                'rowid'=>$item['rowid'],
                'qty'=>0
            ));
        }
        redirect();
    }
    /* manage product C2C */
    public function product() {
        if(is_user_login()==true) {
            /* set page title and view */
            $data['page_title'] = 'จัดการสินค้า';
            $data['user_content'] = 'user/content/user_product';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>'user/product'));
            /* other code */
            $this->load->model('shop/product_model');
            $this->load->model('user/user_profile_model');
            $login_info = get_login_info();
            $user_data = $this->user_model->get_user('email', $login_info['email']);
            $data['user_data'] = $user_data;

            $user_profile_data = $this->user_profile_model->get_user_profile('user_id',$user_data['id']);
            // เช้คว่าถ้าไม่กรอก id กะ tel num จะจัดการสินค้าและแอดสินค้าไม่ได้
            if($user_profile_data['identity_number']=='' || $user_profile_data['tel_num']=='') {
                $data['user_content'] = 'user/content/user_shop_warning';
            }

            // เช็คว่า user เป็น b2c (supplier) หรือ c2c (user)
            $start = '0';
            if($this->uri->segment(3)!='') {
                $start = $this->uri->segment(3);
            }
            if($user_data['level']=='supplier') {
                $this->load->model('shop/supplier_model');
                // หา supplier id ของ user
                $supplier_data = $this->supplier_model->get_supplier('user_id',$user_data['id']);
                $data['product_data'] = $this->product_model->get_product('','','AND owner_id="'.$supplier_data['id'].'" AND owner_type="b2c" ORDER BY add_date DESC LIMIT '.$start.',20');
//                if(count($data['product_data'])==0) {
//                    redirect();
//                }
                $config['total_rows'] = count($this->product_model->get_product('','','AND owner_id="'.$supplier_data['id'].'" AND owner_type="b2c"'));
            } else {
                $data['product_data'] = $this->product_model->get_product('','','AND owner_id="'.$user_data['id'].'" AND owner_type="c2c" ORDER BY add_date DESC LIMIT '.$start.',20');
//                if(count($data['product_data'])==0) {
//                    redirect();
//                }
                $config['total_rows'] = count($this->product_model->get_product('','','AND owner_id="'.$user_data['id'].'" AND owner_type="c2c"'));
            }
            $this->load->library('pagination');
            $config['base_url'] = base_url().'user/product/';
            $config['per_page'] = '20';
            $config['uri_segment'] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $this->pagination->initialize($config);
            $data['pagination'] =  $this->pagination->create_links();
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    /* add product C2C */
    public function add_product() {
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);

        if(is_user_login()==true && $user_data['level']!='supplier') {
            /* set page title and view */
            $data['page_title'] = 'เพิ่มสินค้า';
            $data['user_content'] = 'user/content/user_add_product';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', 'จัดการสินค้า'=>'user/product',  $data['page_title']=>'user/product'));
            $this->load->model('user/user_profile_model');
            $user_profile_data = $this->user_profile_model->get_user_profile('user_id',$user_data['id']);
            // เช้คว่าถ้าไม่กรอก id กะ tel num จะจัดการสินค้าและแอดสินค้าไม่ได้
            if($user_profile_data['identity_number']=='' || $user_profile_data['tel_num']=='') {
                $data['user_content'] = 'user/content/user_shop_warning';
            }
            /* other code */
            $this->load->model('shop/product_category_model');
            $this->load->model('shop/product_model');
            $this->load->model('shop/product_gallery_model');
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $this->load->helper('upload');
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'name'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'price'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'unit'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'title'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'detail'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'size'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'color'),
                array('prefix'=>'ddl', 'table'=>'shop_product', 'field'=>'product_category_id')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $data['product_category_data'] = $this->product_category_model->get_product_category('','','AND product_category_id IS NULL');
            $product_image_error = '';
            $product_gallery_error = '';
            $product_gallery_count_error = 0;
            // กด submit add product
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $product_image = '';
                    $product_gallery = array();
                    // Upload Product Image
                    $file_name = '';
                    $file_ext = '';
                    if($_FILES['txt_image']['name']!=null) {
                        list($file_name, $file_ext) = explode('.', $_FILES['txt_image']['name']);
//                        $new_file_name = $file_name.'_'.time();
//                        $new_file_name = str_replace(" ", "_", $new_file_name); // เอา string ว่างออก

                        $new_file_name = $user_data['username'].'_'.time();
                        //$product_image = base_url().'assets/user/product/'.$new_file_name.'.'.$file_ext;
                        $product_image = 'userfile/product/'.$new_file_name.'.'.$file_ext;
                        $product_image_error = do_upload('txt_image', array(
                            'file_name'=>$new_file_name,
                            'upload_path'=>'./userfile/product',
                            'allowed_types'=>'gif|jpg|png',
                            'max_size'=>'500'
                        ));
                        $data['error_message'] = $product_image_error;
                    }
                    // Upload Product Gallery
                    $is_gallery_null = true;
                    foreach($_FILES['txt_gallery']['name'] as $gallery_name) {
                        if($gallery_name!='') {
                            $is_gallery_null = false;
                            break;
                        }
                    }
                    // มีการ upload gallery ด้วย
                    if($is_gallery_null===false) {
                        //print_r($_FILES['txt_gallery']);
                        for($x = 0; $x < count($_FILES['txt_gallery']["name"]); $x++) {
                            if($_FILES['txt_gallery']['name'][$x] != '') {
                                $file_name = '';
                                $file_ext = '';
                                list($file_name, $file_ext) = explode('.', $_FILES['txt_gallery']['name'][$x]);
//                                $new_file_name = $file_name.'_'.time();
//                                $new_file_name = str_replace(" ", "_", $new_file_name); // เอา string ว่างออก

                                $new_file_name = $user_data['username'].'_g'.$x.time();

                                //$product_gallery[] = base_url().'assets/user/product/'.$new_file_name.'.'.$file_ext;
                                $product_gallery[] = 'userfile/product/'.$new_file_name.'.'.$file_ext;
                                $product_gallery_error[] = do_upload_array('txt_gallery', array(
                                    'file_name'=>$new_file_name,
                                    'upload_path'=>'./userfile/product',
                                    'allowed_types'=>'gif|jpg|png',
                                    'max_size'=>'500'
                                ), $x);
                                if($product_gallery_error[$x]!='') {
                                    $product_gallery_count_error++;
                                }
                                $data['error_message2'] = $product_gallery_error;
                            }
                        }
                    }
                    // add product to database
                    $user_data = get_login_info();
                    $user_data = $this->user_model->get_user('email', $user_data['email']);
                    if($product_image_error=='' && $product_gallery_count_error==0) { // ไม่มี error จาก product image
                        $this->product_model->add_product(array(
                            'name'=>$this->input->post('txt_name'),
                            'title'=>$this->input->post('txt_title'),
                            'detail'=>$this->input->post('txt_detail'),
                            'image'=>$product_image,
                            'price'=>(float)$this->input->post('txt_price'),
                            'unit'=>$this->input->post('txt_unit'),
                            'size'=>$this->input->post('txt_size'),
                            'color'=>$this->input->post('txt_color'),
                            'type'=>($this->input->post('ddl_type')=='null') ? NULL : $this->input->post('ddl_type'),
                            'options'=>'normal',
                            'add_date'=>date("Y-m-d H:i:s"),
                            'owner_id'=>$user_data['id'],
                            'owner_type'=>'c2c',
                            'product_category_id'=>($this->input->post('ddl_product_category_id')!=0) ? $this->input->post('ddl_product_category_id') : null
                        ));

                        // add product gallery to database
                        if($is_gallery_null===false) {
                            $query = $this->db->query("SELECT id FROM shop_product ORDER BY id DESC LIMIT 1");
                            $product = $query->row_array();
                            foreach ($product_gallery as $value) {
                                $this->product_gallery_model->add_product_gallery(array(
                                    'image'=>$value,
                                    'product_id'=>$product['id']
                                ));
                            }
                        }
                        $data['message'] = "<div class='msg_form_complete'>เพิ่มสินค้าเรียบร้อยแล้ว</div>";
                        $this->form_validation->_field_data = array();
                        //redirect('user/add_product');
                    }

                }
            }
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    function edit_product() {
        // เช็คว่า product นี้เป็นของคนที่ต้องการ edit หรือไม่
        $this->load->model('shop/product_model');
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);
        $check_owner = $this->product_model->get_product('id', $this->uri->segment(3), ' AND owner_id="'.$user_data['id'].'" AND owner_type="c2c"');
        if(count($check_owner)==0) { // คนแก้ไขไม่ได้เป็นเจ้าของสินค้านี้ จะเข้าเพจนไม่ได้ และ b2c เข้าไม่ได้
            redirect();
        }
        if(is_user_login()==true) {
            /* set page title and view */
            $data['page_title'] = 'แก้ไขสินค้า';
            $data['user_content'] = 'user/content/user_edit_product';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', 'จัดการสินค้า'=>'user/product',  $data['page_title']=>current_url()));
            /* other code */
            $this->load->model('shop/product_category_model');
            $this->load->model('shop/product_gallery_model');
            // submit edit
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $this->load->helper('upload');
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'name'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'price'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'unit'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'title'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'detail'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'size'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'color'),
                array('prefix'=>'ddl', 'table'=>'shop_product', 'field'=>'product_category_id')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $product_image_error = '';
            $product_gallery_error = '';
            $product_gallery_count_error = 0;
            // กด submit add product
            if($this->form_validation->run()==true) {
                // มีการแก้ไข product image
                $file_name = '';
                $file_ext = '';
                if($_FILES['txt_image']['name']!=null) {
                    list($file_name, $file_ext) = explode('.', $_FILES['txt_image']['name']);
//                    $new_file_name = $file_name.'_'.time();
//                    $new_file_name = str_replace(" ", "_", $new_file_name); // เอา string ว่างออก
                    $new_file_name = $user_data['username'].'_'.time();
                    //$product_image = base_url().'assets/user/product/'.$new_file_name.'.'.$file_ext;
                    $product_image = 'userfile/product/'.$new_file_name.'.'.$file_ext;
                    $product_image_error = do_upload('txt_image', array(
                        'file_name'=>$new_file_name,
                        'upload_path'=>'./userfile/product',
                        'allowed_types'=>'gif|jpg|png',
                        'max_size'=>'500'
                    ));
                    $data['error_message'] = $product_image_error;
                }
                // มีการแก้ไข gallery
                $is_gallery_null = true;
                if(isset($_FILES['txt_gallery']['name'])) {
                    foreach($_FILES['txt_gallery']['name'] as $gallery_name) {
                        if($gallery_name!='') {
                            $is_gallery_null = false;
                            break;
                        }
                    }
                }
                // ลบ gallery เดิมออกก่อนแล้ว add เข้าไปใหม่
                $old_gallery = $this->product_gallery_model->get_product_gallery('product_id', $this->uri->segment(3));
                foreach ($old_gallery as $value) {
                    $this->product_gallery_model->del_product_gallery('id', $value['id']);
                }
                if($is_gallery_null===false) {
                    // upload gallery
                    for($x = 0; $x < count($_FILES['txt_gallery']["name"]); $x++) {
                        if($_FILES['txt_gallery']['name'][$x] != '') {
                            $file_name = '';
                            $file_ext = '';
                            list($file_name, $file_ext) = explode('.', $_FILES['txt_gallery']['name'][$x]);
//                            $new_file_name = $file_name.'_'.time();
//                            $new_file_name = str_replace(" ", "_", $new_file_name); // เอา string ว่างออก
                            $new_file_name = $user_data['username'].'_g'.$x.time();
                            //$product_gallery[] = base_url().'assets/user/product/'.$new_file_name.'.'.$file_ext;
                            $product_gallery[] = 'userfile/product/'.$new_file_name.'.'.$file_ext;
                            $product_gallery_error[] = do_upload_array('txt_gallery', array(
                                'file_name'=>$new_file_name,
                                'upload_path'=>'./userfile/product',
                                'allowed_types'=>'gif|jpg|png',
                                'max_size'=>'500'
                            ), $x);
                                if($product_gallery_error[$x]!='') {
                                    $product_gallery_count_error++;
                                }
                                $data['error_message2'] = $product_gallery_error;
                        }
                    }
                    if( $product_gallery_count_error==0) {
                        // add ใหม่
                        foreach ($product_gallery as $value) {
                            $this->product_gallery_model->add_product_gallery(array(
                                'image'=>$value,
                                'product_id'=>$this->uri->segment(3)
                            ));
                        }
                    }
                }

                    if($this->input->post('hid_gallery_id')) { // ไม่ได้ลบ gallery เดิมออก
                        $gallery_image = $this->input->post('hid_gallery_image');
                        $gallery_product_id = $this->input->post('hid_gallery_product_id');
                        for($i=0;$i<count($gallery_image);$i++) {
                            $this->product_gallery_model->add_product_gallery(array(
                                'image'=>$gallery_image[$i],
                                'product_id'=>$gallery_product_id[$i]
                            ));
                        }
                    }

                if($product_image_error=='' && $product_gallery_count_error==0) {
                   // บันทึกลง db
                    $user_data = $this->user_model->get_user('email', $login_info['email']);
                    if($_FILES['txt_image']['name']!=null) { // มีการแก้ไข product image
                        $this->product_model->edit_product('id', $this->uri->segment(3), array(
                            'name'=>$this->input->post('txt_name'),
                            'title'=>$this->input->post('txt_title'),
                            'detail'=>$this->input->post('txt_detail'),
                            'image'=>$product_image,
                            'price'=>(float)$this->input->post('txt_price'),
                            'unit'=>$this->input->post('txt_unit'),
                            'size'=>$this->input->post('txt_size'),
                            'color'=>$this->input->post('txt_color'),
                            'type'=>($this->input->post('ddl_type')=='null') ? NULL : $this->input->post('ddl_type'),
                            'options'=>'normal',
                            'add_date'=>date("Y-m-d H:i:s"),
                            'owner_id'=>$user_data['id'],
                            'owner_type'=>'c2c',
                            'product_category_id'=>$this->input->post('ddl_product_category_id')
                        ));
                    } else {
                        $this->product_model->edit_product('id', $this->uri->segment(3), array(
                            'name'=>$this->input->post('txt_name'),
                            'title'=>$this->input->post('txt_title'),
                            'detail'=>$this->input->post('txt_detail'),
                            'price'=>(float)$this->input->post('txt_price'),
                            'unit'=>$this->input->post('txt_unit'),
                            'size'=>$this->input->post('txt_size'),
                            'color'=>$this->input->post('txt_color'),
                            'type'=>($this->input->post('ddl_type')=='null') ? NULL : $this->input->post('ddl_type'),
                            'options'=>'normal',
                            'add_date'=>date("Y-m-d H:i:s"),
                            'owner_id'=>$user_data['id'],
                            'owner_type'=>'c2c',
                            'product_category_id'=>$this->input->post('ddl_product_category_id')
                        ));
                    }
                    $data['message'] = "<div class='msg_form_complete'>แก้ไขสินค้าเรียบร้อย</div>";
                }

                // redirect
                //redirect('user/edit_product/'.$this->uri->segment(3));
            }
            $data['product_category_data'] = $this->product_category_model->get_product_category('','','AND product_category_id IS NULL');
            $data['product_data'] = $this->product_model->get_product('id', $this->uri->segment(3));
            $data['product_gallery_data'] = $this->product_gallery_model->get_product_gallery('product_id', $data['product_data']['id']);
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    function add_address() {
        if(is_user_login()==true) {
            $this->load->model('user/user_address_model');
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation');
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'firstname'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'lastname'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'address'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'tambon'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'amphoe'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'province'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'postalcode'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'tel_num'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'fax_num')
            ), '');
            $this->form_validation->set_rules($validation_config);
            if($this->form_validation->run()==true) {
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $login_info = get_login_info();
                    $user_data = $this->user_model->get_user('email', $login_info['email']);
                    $this->user_address_model->add_user_address(array(
                        'firstname'=>$this->input->post('txt_firstname'),
                        'lastname'=>$this->input->post('txt_lastname'),
                        'address'=>$this->input->post('txt_address'),
                        'tambon'=>$this->input->post('txt_tambon'),
                        'amphoe'=>$this->input->post('txt_amphoe'),
                        'province'=>$this->input->post('txt_province'),
                        'postalcode'=>$this->input->post('txt_postalcode'),
                        'tel_num'=>$this->input->post('txt_tel_num'),
                        'fax_num'=>$this->input->post('txt_fax_num'),
                        'user_id'=>$user_data['id']
                    ));
                    $_SESSION['message'] = "<div class='msg_form_complete'>เพิ่มที่อยู่เสร็จสมบูรณ์</div>";
                    redirect('user/profile');
                }
            }
            $data['page_title'] = 'เพิ่มที่อยู่';
            $data['user_content'] = 'user/content/user_add_address';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>current_url()));
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    function edit_address() {
        if(is_user_login()==true && $this->uri->segment(3)) {
            $this->load->model('user/user_address_model');
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation');
            $data['user_address_data'] = $this->user_address_model->get_user_address('id', $this->uri->segment(3));
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'firstname'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'lastname'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'address'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'tambon'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'amphoe'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'province'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'postalcode'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'tel_num'),
                array('prefix'=>'txt', 'table'=>'shop_user_address', 'field'=>'fax_num')
            ), '');
            $this->form_validation->set_rules($validation_config);
            if($this->form_validation->run()==true) {
                if(validation_form_key($this->input->post('hid_form_key')==true)) {
                    $this->user_address_model->edit_user_address('id', $this->uri->segment(3), array(
                        'firstname'=>$this->input->post('txt_firstname'),
                        'lastname'=>$this->input->post('txt_lastname'),
                        'address'=>$this->input->post('txt_address'),
                        'tambon'=>$this->input->post('txt_tambon'),
                        'amphoe'=>$this->input->post('txt_amphoe'),
                        'province'=>$this->input->post('txt_province'),
                        'postalcode'=>$this->input->post('txt_postalcode'),
                        'tel_num'=>$this->input->post('txt_tel_num'),
                        'fax_num'=>$this->input->post('txt_fax_num')
                    ));
                     $_SESSION['message'] = "<div class='msg_form_complete'>แก้ไขข้อมูลที่อยู่เสร็จสมบูรณ์</div>";
                    redirect(current_url());
                }
            }
            $data['page_title'] = 'แก้ไขที่อยู่';
            $data['user_content'] = 'user/content/user_edit_address';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>current_url()));
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    function del_address() {
        if(is_user_login()==true) {
            $this->load->model('user/user_address_model');
            $address_data = $this->user_address_model->get_user_address('id', $this->uri->segment(3));
            $login_info = get_login_info();
            $user_data = $this->user_model->get_user('email', $login_info['email']);
            if($address_data['user_id']==$user_data['id']) {
                $this->user_address_model->edit_user_address('id', $this->uri->segment(3), array(
                    'flag_del'=>true
                ));
            }
            redirect('user/profile');
        } else {
            redirect();
        }
    }
    function order() {
        if(is_user_login()==true) {
            $this->load->helper('table_field');
            $this->load->model('shop/product_model');
            $this->load->model('shop/order_model');
            $this->load->model('shop/order_item_model');
            $this->load->model('user/user_address_model');
            $login_info = get_login_info();
            $user_data = $this->user_model->get_user('email', $login_info['email']);
            $total_row = 0;
            $start = '0';
            if($this->uri->segment(3)!='') {
                $start = $this->uri->segment(3);
            }
            if($user_data['level']!='supplier') { 
                $data['owner_type'] = 'c2c';
                $data['order_data'] = $this->order_model->get_order('','','AND user_id="'.$user_data['id'].'" ORDER BY id DESC LIMIT '.$start.',20');
                $data['page_title'] = 'จัดการรายการสั่งซื้อ';
                $data['user_content'] = 'user/content/user_order';
                $data['page_content'] = 'user/user_view';
                $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>current_url()));
                $total_row = count($this->order_model->get_order('','','AND user_id="'.$user_data['id'].'" ORDER BY id DESC'));
            } else {
                $query = $this->db->query("
                    SELECT shop_order_item.id,shop_order_item.product_id, shop_order_item.order_id
                    FROM shop_order_item,shop_product,shop_supplier
                    WHERE shop_supplier.user_id=? AND
                    shop_supplier.id = shop_product.owner_id AND
                    shop_product.owner_type='b2c' AND
                    shop_order_item.product_id=shop_product.id
                    ORDER BY shop_order_item.id DESC
                    LIMIT {$start},20
                    ",array($user_data['id']));
                $data['owner_type'] = 'b2c';
                $data['order_data'] = $query->result_array();
                $data['page_title'] = 'สินค้าที่ถูกขาย';
                $data['user_content'] = 'user/content/user_order';
                $data['page_content'] = 'user/user_view';
                $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', $data['page_title']=>current_url()));
                $query_num = $this->db->query("
                    SELECT shop_order_item.id,shop_order_item.product_id, shop_order_item.order_id
                    FROM shop_order_item,shop_product,shop_supplier
                    WHERE shop_supplier.user_id=? AND
                    shop_supplier.id = shop_product.owner_id AND
                    shop_product.owner_type='b2c' AND
                    shop_order_item.product_id=shop_product.id
                    ORDER BY shop_order_item.id DESC
                    ",array($user_data['id']));
                $total_row = $query_num->num_rows();
            }
//            if(count($data['order_data'])==0) {
//                redirect('user/order');
//            }
            $this->load->library('pagination');
            $config['base_url'] = base_url()."user/order";
            $config['total_rows'] = $total_row;
            $config['per_page'] = '20';
            $config['uri_segment'] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $this->pagination->initialize($config);
            $data['pagination'] =  $this->pagination->create_links();
             /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }


    function view_order() {
        if(is_user_login()!=true) { // not login
            redirect();
        }
        $this->load->helper('table_field');
        $this->load->model('shop/product_model');
        $this->load->model('shop/order_model');
        $this->load->model('shop/order_item_model');
        $this->load->model('user/user_address_model');
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);
        $check_owner = $this->order_model->get_order('id', $this->uri->segment(3), ' AND user_id="'.$user_data['id'].'"');
        
        if($user_data['level']!='supplier') { // c2c
            // เช็คว่า order นี้เป็นของคนที่ต้องการ view หรือไม่
            if(count($check_owner)==0) { // คนดูไม่ใช้เจ้าของ order จะเข้าไม่ได้
                redirect();
            }
            $data['order_data'] = $this->order_model->get_order('id', $this->uri->segment(3));
            $data['order_item_data'] = $this->order_item_model->get_order_item('','', 'AND order_id="'.$this->uri->segment(3).'"');
            $data['page_title'] = 'ดูรายการสั่งซื้อ';
            $data['user_content'] = 'user/content/user_view_order';
            $data['page_content'] = 'user/user_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile', 'จัดการรายการสั่งซื้อ' =>'user/order',$data['page_title']=>current_url()));
            /* load view */
            $this->load->view('main_view', $data);
        } else { // b2c
   
        }
    }
    function send_payment() {
        if(is_user_login()!=true) { // not login
            redirect();
        }
        $this->load->library('form_validation');
        $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
        $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
        $this->load->model('shop/order_model');
        $this->load->model('user_profile_model');
        $this->load->model('shop/payment_model');
        $login_info = get_login_info();

        $data['user_data'] = $this->user_model->get_user('email',$login_info['email']);
        $data['user_profile_data'] = $this->user_profile_model->get_user_profile('user_id',$data['user_data']['id']);
        $data['order_data'] = $this->order_model->get_order('','','AND user_id="'.$data['user_data']['id'].'" AND status="wait"');
        $validation_config = get_validation_config(array(
            array('prefix'=>'txt', 'table'=>'shop_user_profile', 'field'=>'tel_num'),
            array('prefix'=>'txt', 'table'=>'shop_payment', 'field'=>'money'),
            array('prefix'=>'txt', 'table'=>'shop_payment', 'field'=>'payment_date')
        ), '');
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run()==true) {
            if($data['user_profile_data']!='') { // ยังไม่ได้กรอก tel num ใน user profile 
                $this->user_profile_model->edit_user_profile('user_id', $data['user_data']['id'], array(
                    'tel_num'=>$this->input->post('txt_tel_num')
                ));
            }
            if($this->input->post('ddl_order_id')!='0') {
                // add payment
                $this->payment_model->add_payment(array(
                    'money'=>$this->input->post('txt_money'),
                    'payment_method'=>$this->input->post('ddl_payment_method'),
                    'payment_date'=>$this->input->post('txt_payment_date'),
                    'detail'=>$this->input->post('txt_detail'),
                    'user_id'=>$data['user_data']['id'],
                    'order_id'=>$this->input->post('ddl_order_id'),
                ));
               // Send mail
                $this->config->load('email');
                $this->load->helper('mailer');
                $config['smtp_host'] = $this->config->item('smtp_host');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_user'] = $this->config->item('smtp_user');
                $config['smtp_pass'] = $this->config->item('smtp_pass');
                $config['mail'] = $this->config->item('send_payment_mail');
                $config['from'] = $this->config->item('send_payment_from');
                $config['subject'] = $this->config->item('send_payment_subject');
                $data['firstname'] = $data['user_data']['firstname'];
                $data['lastname'] = $data['user_data']['lastname'];
                $data['money'] = $this->input->post('txt_money');
                send_mail('customerservice@glixa.com',$this->load->view('mail_template/send_payment',$data,true),$config);
                $data['message'] = "<div class='msg_form_complete'>แจ้งการชำระเงินเรียบร้อย</div>";

            }
        }
        $data['page_title'] = 'แจ้งการชำระเงิน';
        $data['user_content'] = 'user/content/user_send_payment';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile',$data['page_title']=>current_url()));
        /* load view */
        $this->load->view('main_view', $data);
    }
    function del_order(){
        if(is_user_login()==false) {
            redirect();
        }
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);
        $this->load->model('shop/order_model');
        $this->load->model('shop/order_item_model');
        $order_data = $this->order_model->get_order('id',$this->uri->segment(3));
        // เช็คว่า order นี้เป็นของคนที่กดลบ
        if($user_data['id']==$order_data['user_id']) {
            $this->order_model->edit_order('id',$this->uri->segment(3), array(
                'flag_del'=>'1'
            ));
            $this->order_item_model->edit_order_item('order_id',$this->uri->segment(3), array(
                'flag_del'=>'1'
            ));
            redirect('user/order');
        }
    }
    function product_question() {
        if(is_user_login()==false) {
            redirect();
        }
        $this->load->model('shop/product_model');
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email',$login_info['email']);
        $this->load->helper('table_field');
        $query_num = $this->db->query("SELECT
            shop_product_qa.id,
            shop_product_qa.question,shop_product_qa.product_id,shop_product_qa.approve
            FROM shop_product_qa,shop_product,wive_user
            WHERE shop_product_qa.product_id=shop_product.id AND
            shop_product.owner_id=wive_user.id AND
            shop_product.owner_type='c2c' AND
            wive_user.id = '".$user_data['id']."'
            ORDER BY shop_product_qa.id DESC");
        $start = '0';
        if($this->uri->segment(3)!='') {
            $start = $this->uri->segment(3);
        }
        $query = $this->db->query("SELECT
            shop_product_qa.id,
            shop_product_qa.question,shop_product_qa.product_id,shop_product_qa.approve
            FROM shop_product_qa,shop_product,wive_user
            WHERE shop_product_qa.product_id=shop_product.id AND
            shop_product.owner_id=wive_user.id AND
            shop_product.owner_type='c2c' AND
            wive_user.id = '".$user_data['id']."'
            ORDER BY shop_product_qa.id DESC LIMIT {$start},20");
//        if($query->num_rows()==0) {
//            redirect('user/product_question');
//        }
        $data['product_qa_data'] = $query->result_array();
        $data['page_title'] = 'คำถามสินค้า';
        $data['user_content'] = 'user/content/user_product_question';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile',$data['page_title']=>current_url()));

        $this->load->library('pagination');
        $config['base_url'] = base_url().'user/product_question/';
        $config['total_rows'] = $query_num->num_rows();
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        /* load view */
        $this->load->view('main_view', $data);
    }
    function product_answer() {
        if(is_user_login()==false) {
            redirect();
        }
        $this->load->model('shop/product_model');
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email',$login_info['email']);
        $this->load->helper('table_field');
        $query = $this->db->query("SELECT
            shop_product_qa.id,
            shop_product_qa.question,shop_product_qa.product_id,shop_product_qa.approve
            FROM shop_product_qa,shop_product,wive_user
            WHERE shop_product_qa.product_id=shop_product.id AND
            shop_product.owner_id=wive_user.id AND
            shop_product.owner_type='c2c' AND
            wive_user.id = '".$user_data['id']."' AND
            shop_product_qa.id='".$this->uri->segment(3)."'
            ORDER BY shop_product_qa.id DESC");
        if($query->num_rows()==0) { // ไม่ใใช่เจ้าของ product
            redirect();
        }
        $data['product_qa_data'] = $this->product_qa_model->get_product_qa('id',$this->uri->segment(3));
        // submit
        if($this->input->post('btn_submit') && validation_form_key($this->input->post('hid_form_key'))==true) {
            $this->product_qa_model->edit_product_qa('id',$this->uri->segment(3),array(
                'answer'=>$this->input->post('txt_answer')
            ));
            if($data['product_qa_data']['user_id']!='') { // ส่ง mail กลับไปบอกคนถาม
                $data['ask_user_data'] = $this->user_model->get_user('id',$data['product_qa_data']['user_id']);
                $data['ask_product_data'] = $this->product_model->get_product('id',$data['product_qa_data']['product_id']);
                // send mail
                $this->config->load('email');
                $this->load->helper('mailer');
                $config['smtp_host'] = $this->config->item('smtp_host');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_user'] = $this->config->item('smtp_user');
                $config['smtp_pass'] = $this->config->item('smtp_pass');
                $config['mail'] = $user_data['email'];
                $config['from'] = $user_data['email'];
                $config['subject'] = $this->config->item('user_product_answer_subject');
                $data['url'] = 'http://localhost/Wive/shop/product/'.$data['ask_product_data']['id'].'/'.url_title($data['ask_product_data']['name']);
                send_mail($data['ask_user_data']['email'],$this->load->view('mail_template/user_product_answer',$data,true),$config);
                
            }
            redirect(current_url());
        }
        $data['page_title'] = 'ตอบคำถามสินค้า';
        $data['user_content'] = 'user/content/user_product_answer';
        $data['page_content'] = 'user/user_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ข้อมูลส่วนตัว'=>'user/profile','คำถามสินค้า'=>'user/product_question',$data['page_title']=>current_url()));
        /* load view */
        $this->load->view('main_view', $data);
    }
    function del_product() {
        if(is_user_login()==false) {
            redirect();
        }
        $this->load->model('shop/product_model');
        // เช็คว่า product ที่ลบเปนของเจ้าของจริงๆ
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);
        $product_data = $this->product_model->get_product('','',' AND owner_id="'.$user_data['id'].'" AND owner_type="c2c" AND id="'.$this->uri->segment(3).'"');
        if($product_data==null) { // ไม่ใช่เจ้าของสินค้าที่ต้องการลบ
            redirect();
        }
        // set flagdel=1
        $this->product_model->edit_product('id',$this->uri->segment(3),array(
            'flag_del'=>'1'
        ));
        redirect('user/product');
    }


    function mail() { 
//        $this->config->load('email');
//        $this->load->helper('mailer');
//        $config['smtp_host'] = $this->config->item('smtp_host');
//        $config['smtp_port'] = $this->config->item('smtp_port');
//        $config['smtp_user'] = $this->config->item('smtp_user');
//        $config['smtp_pass'] = $this->config->item('smtp_pass');
//        $config['regis_mail'] = $this->config->item('regis_mail');
//        $config['regis_from'] = $this->config->item('regis_from');
//        $config['regis_subject'] = $this->config->item('regis_subject');
//        send_mail('asd@asd.com',$this->load->view('mail_template/regis_mail','',true),$config);

        $this->config->load('email');
        $this->load->library('lib/PHPMailer');

            // Send mail
            $mail = new PHPMailer();

            $mail->CharSet = "utf-8";

            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->SMTPAuth = true;
            $mail->Host = 'ssl://smtp.gmail.com';
            $mail->Port = '465';
            $mail->Username = 'admin@glixa.com';
            $mail->Password = 'bank49215734';

            $mail->SetFrom('admin@glixa.com', 'Glixa Google App');
            $mail->AddAddress('banktp106@hotmail.com');
            $mail->AddAddress('siripong.tianpajeekul@gmail.com');
            $mail->AddAddress('ronaldomac9@gmail.com');
            $mail->AddAddress('ronaldomac9@hotmail.com');
            $mail->Subject = "ทดสอบ Google App Email";
            $mail->MsgHTML("ทดลองเล่นๆ <br /> ส่งเมล 12345");
            $mail->Send();


//        // GET USER
//        echo "<pre>";
//        $user_data = $this->user_model->get_user('', '', 'AND available=0 AND regis_date>date("2010-11-01 08:00:0")');
//
//        foreach ($user_data as $user) {
//            // Send mail
//            $mail = new PHPMailer();
//
//            $mail->CharSet = "utf-8";
//
//            $mail->IsSMTP();  // telling the class to use SMTP
//            $mail->SMTPAuth = true;
//            $mail->Host = $this->config->item('smtp_host');
//            $mail->Port = $this->config->item('smtp_port');
//            $mail->Username = $this->config->item('smtp_user');
//            $mail->Password = $this->config->item('smtp_pass');
//
//            $mail->SetFrom($this->config->item('activate_mail'), $this->config->item('activate_from'));
//            $mail->AddAddress($user['email']);
//            $mail->Subject = $this->config->item('activate_subject');
//            $data['url'] = base_url() . 'user/activate/' . strtolower($user['username']) . '/' . sha1($user['email'] . $user['password']);
//            $mail->MsgHTML($this->load->view('mail_template/activate_mail', $data, true));
//            $mail->Send();
//        }
    }
    public function act() {
        $user_data = $this->user_model->get_user('', '', 'AND available=0 AND regis_date>=date("2010-12-07 08:00:0")');

        foreach ($user_data as $user) {
            // Send mail
            $mail = new PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->SMTPAuth = true;
            $mail->Host = $this->config->item('smtp_host');
            $mail->Port = $this->config->item('smtp_port');
            $mail->Username = $this->config->item('smtp_user');
            $mail->Password = $this->config->item('smtp_pass');

            $mail->SetFrom($this->config->item('activate_mail'), $this->config->item('activate_from'));
            $mail->AddAddress($user['email']);
            $mail->Subject = $this->config->item('activate_subject');
            $data['url'] = base_url() . 'user/activate/' . strtolower($user['username']) . '/' . sha1($user['email'] . $user['password']);
            $mail->MsgHTML($this->load->view('mail_template/activate_mail', $data, true));
            $mail->Send();
        }
    }
    
}
?>
