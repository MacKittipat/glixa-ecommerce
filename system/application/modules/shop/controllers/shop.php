<?php
class Shop extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_model');
        $this->load->model('shop/product_category_model');
        $this->load->model('shop/product_option_model');
        //$this->load->model('shop/product_gallery_model');
        //$this->load->model('shop/product_media_model');
    }
    public function index() {
        redirect('shop/shopping');
        /* set page title and view */
        $data['page_title'] = 'ร้านค้า';
        $data['shop_content'] = 'shop/content/shop_index';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'shop'));
        /* other code */
        $data['product_new_data'] = $this->product_model->get_product('','','AND options="normal" AND available=1 ORDER BY add_date DESC LIMIT 12');
        $data['product_promotion_data'] = $this->product_model->get_product('','','AND options="Promotion" AND available=1 ORDER BY add_date DESC LIMIT 12');
        $data['product_hot_data'] = $this->product_model->get_product('','','AND options="Hot" AND available=1 ORDER BY add_date DESC LIMIT 12');
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function glixa_guarantee() {
        /* set page title and view */
        $data['page_title'] = 'Glixa Guarantee';
        $data['shop_content'] = 'shop/content/shop_glixa_guarantee';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(),$data['page_title']=>'shop/glixa_guarantee'));
        /* set page title and view */
        $start = '0';
        if($this->uri->segment(3)!='') {
            $start = $this->uri->segment(3);
        }
        $data['product_data'] = $this->product_model->get_product('', '', ' AND owner_type="b2c" AND (type2!="promotion" OR type2 IS NULL)  ORDER BY add_date DESC LIMIT '.$start.',20');
        $this->load->library('pagination');
        $config['base_url'] = base_url().'shop/glixa_guarantee/';
        $config['total_rows'] = count($this->product_model->get_product('', '', 'AND owner_type="b2c"'));
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function shopping() {
        /* set page title and view */
        $data['page_title'] = 'Shopping';
        $data['shop_content'] = 'shop/content/shop_shopping';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'shop/shopping'));
        /* set page title and view */
        $start = '0';
        if($this->uri->segment(3)!='') {
            $start = $this->uri->segment(3);
        }
        $data['product_data'] = $this->product_model->get_product('', '', ' AND owner_type="c2c" ORDER BY add_date DESC LIMIT '.$start.',20');
        
        $this->load->library('pagination');
        $config['base_url'] = base_url().'shop/shopping/';
        $config['total_rows'] = count($this->product_model->get_product('', '', 'AND owner_type="c2c"'));
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function promotion() {
        /* set page title and view */
        $data['page_title'] = 'Promotion';
        $data['shop_content'] = 'shop/content/shop_promotion';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'shop/promotion'));
        /* set page title and view */
        $start = '0';
        if($this->uri->segment(3)!='') {
            $start = $this->uri->segment(3);
        }
        $data['product_data'] = $this->product_model->get_product('', '', ' AND owner_type="b2c" AND type2="promotion" ORDER BY add_date DESC LIMIT '.$start.',20');
        
        $this->load->library('pagination');
        $config['base_url'] = base_url().'shop/promotion/';
        $config['total_rows'] = count($this->product_model->get_product('', '', 'AND owner_type="c2c" AND type2="promotion"'));
        $config['per_page'] = '20';
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function view_promotion() {
        /* set page title and view */
        $data['page_title'] = 'View Promotion';
        $data['shop_content'] = 'shop/content/shop_product_promotion';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'shop/promotion'));
        // Other code
         $this->load->helper('table_field');
        $data['promotion_data'] = $data['product_data'] = $this->product_model->get_product('id', $this->uri->segment(3));
        $data['promotion_item_data'] = $this->db->query("SELECT product_id FROM shop_promotion_item WHERE promotion_id=?",array($this->uri->segment(3)))->result_array();

        /* load view */
        $this->load->view('main_view', $data);
    }
    public function category() {
        $category_id = $this->uri->segment(3);
        $data['category_data'] = $this->product_category_model->get_product_category('id', $category_id);
        /* set page title and view */
        $data['page_title'] = 'สินค้าประเภท '.$data['category_data']['name'];
        $data['shop_content'] = 'shop/content/shop_category';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ร้านค้า'=>'shop', $data['page_title']=>'shop/category/'.$category_id.'/'.$data['category_data']['name']));
        /* other code */
        $start = '0';
        if($this->uri->segment(5)!='') {
            $start = $this->uri->segment(5);
        }
        $data['product_data'] = $this->product_model->get_product('', '', ' AND product_category_id='.$category_id.' ORDER BY add_date DESC LIMIT '.$start.',20');
//        if(count($data['product_data'])==0) {
//            redirect('shop/category/'.$category_id.'/'.$data['category_data']['name']);
//        }
        $this->load->library('pagination');
        $config['base_url'] = base_url().'shop/category/'.$category_id.'/'.$data['category_data']['name'].'/';
        $config['total_rows'] = count($this->product_model->get_product('', '', ' AND product_category_id='.$category_id.''));
        $config['per_page'] = '20';
        $config['uri_segment'] = 5;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        /* load view */
        $this->load->view('main_view', $data);
    }
    function view_category() {
        /* set page title and view */
        $category_data = $this->product_category_model->get_product_category('id',$this->uri->segment(3));
        $data['page_title'] = 'ประเภทสินค้า '.$category_data['name'];
        $data['shop_content'] = 'shop/content/shop_view_category';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'shop/view_category/'.$this->uri->segment(3).'/'.url_title($category_data['name'])));
        /* other code */
        $data['sub_category_data'] = $this->product_category_model->get_product_category('','','AND product_category_id="'.$this->uri->segment(3).'"');
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function user() {
        /* set page title and view */
        
        $data['shop_content'] = 'shop/content/shop_user';
        $data['page_content'] = 'shop/shop_view';
        
        /* other code */
        $username = $this->uri->segment(1);
        $data['username'] = $username;
        if($username=='') {
            redirect();
        }
        $this->load->helper('table_field');
        $this->load->model('user/user_shop_model');
        $this->load->model('user/user_address_model');
        $data['user_data'] = $this->user_model->get_user('username', $username);
        // ถ้า user ไม่ activate จะเข้า shop ไม่ได้
        if($data['user_data']['available']=='0') {
            redirect();
        }


        $data['user_shop_data'] = $this->user_shop_model->get_user_shop('user_id',$data['user_data']['id']);
        $data['page_title'] = 'สินค้าของ '.$data['user_data']['username'];
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>base_url().$data['user_data']['username']));
        // เช็คว่ามี username นี้ใน db
        if($data['user_data']==null) {
            redirect(); // ไม่มี username นี้
        }
        
        // pagination
        $start = '0';
        if($this->uri->segment(2)!='') {
            $start = $this->uri->segment(2);
        }
        $this->load->library('pagination');
        $config['base_url'] = base_url().$username;
        $config['per_page'] = '20';
        $config['uri_segment'] = 2;
        $config['num_links'] = 10;
        $config['total_rows'] = count($this->product_model->get_product('','',' AND owner_id="'.$data['user_data']['id'].'" AND owner_type="c2c" AND available=1'));
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $data['pagination'] =  $this->pagination->create_links();
        // get ptoduct ของ username นี้
        $data['product_data'] = $this->product_model->get_product('','',' AND owner_id="'.$data['user_data']['id'].'" AND owner_type="c2c" AND available=1 ORDER BY add_date DESC LIMIT '.$start.',20');
//        if(count($data['product_data'])==0) {
//            redirect();
//        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function product() {
        $this->load->model('shop/product_gallery_model');
        $this->load->model('shop/product_media_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('user/user_shop_model');
        $this->load->model('admin/product_lot_model');
        $this->load->model('shop/product_option_model');
        $data['product_data'] = $this->product_model->get_product('id', $this->uri->segment(3));
        // เปน promotion ให้ redirect ไป promotion
        if($data['product_data']['type2']=='promotion') {
            redirect('shop/view_promotion/'.$data['product_data']['id'].'/'.$data['product_data']['name']);
        }
        $data['product_category_data'] = $this->product_category_model->get_product_category('id', $data['product_data']['product_category_id']);
        // parent category 
        $data['p_product_category_data'] = $this->product_category_model->get_product_category('id', $data['product_category_data']['product_category_id']);
        /* set page title and view */
        $data['page_title'] = $data['product_data']['name'];
        $data['shop_content'] = 'shop/content/shop_product';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(),
        $data['p_product_category_data']['name']=>'shop/view_category/'.$data['p_product_category_data']['id'].'/'.url_title($data['p_product_category_data']['name']),
        $data['product_category_data']['name']=>'shop/category/'.$data['product_category_data']['id'].'/'.url_title($data['product_category_data']['name']),
        $data['page_title']=>'shop/product/'.$this->uri->segment(3).'/'.url_title($data['product_data']['name'])));
        $data['option_data'] = $this->product_option_model->get_product_option('','','product_id="'.$this->uri->segment(3).'"');
        $query = $this->db->query("SELECT SUM(quantity) as qty FROM shop_product_lot WHERE product_id='".$data['product_data']['id']."'");
        $product_lot_data = $query->row_array();
        $data['product_qty'] = $product_lot_data['qty'];
        /* other code */
        $this->load->library('form_validation');
        $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
        $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
        // Validate
        $validation_config = array();
        if($this->input->post('hid_task')=='review') { // Validate ของ Review
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_review', 'field'=>'title'),
                array('prefix'=>'txt', 'table'=>'shop_product_review', 'field'=>'detail'),
                array('prefix'=>'chk', 'table'=>'shop_product_review', 'field'=>'overall_rating'),
                array('prefix'=>'chk', 'table'=>'shop_product_review', 'field'=>'money_rating'),
                array('prefix'=>'chk', 'table'=>'shop_product_review', 'field'=>'expectation_rating')
            ), '');
            $this->form_validation->set_rules('txt_user_name_review', get_field_lang('shop_product_review', 'user_name'), 'trim|required');
        } else if($this->input->post('hid_task')=='qa') { // Validate ของ QA
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_qa', 'field'=>'question')
            ), '');
            $this->form_validation->set_rules('txt_user_name_qa', get_field_lang('shop_product_qa', 'user_name'), 'trim|required');
        } else if($this->input->post('hid_task')=='media') {
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_media', 'field'=>'link')
            ), '');
            $this->form_validation->set_rules('txt_title_media', get_field_lang('shop_product_media', 'title'), 'trim|required');
            $this->form_validation->set_rules('txt_user_name_media', get_field_lang('shop_product_media', 'user_name'), 'trim|required');
        } else if($this->input->post('hid_task')=='contact') {
            $this->form_validation->set_rules('contact_email', 'อีเมล', 'trim|required|valid_email');
            $this->form_validation->set_rules('contact_qty', 'จำนวน', 'trim|required|numeric');
        }
        $this->form_validation->set_rules($validation_config);
        // submit form
        if($this->form_validation->run()==true) {
            // Submit Review
            if($this->input->post('hid_task')=='review') {
                if(is_user_login()==true) {
                    $this->product_review_model->add_product_review(array(
                        'title'=>$this->input->post('txt_title'),
                        'detail'=>nl2br($this->input->post('txt_detail')),
                        'overall_rating'=>$this->input->post('chk_overall_rating'),
                        'money_rating'=>$this->input->post('chk_money_rating'),
                        'expectation_rating'=>$this->input->post('chk_expectation_rating'),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>$this->input->post('txt_user_id'),
                        'user_name'=>$this->input->post('txt_user_name_review'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                } else {
                    $this->product_review_model->add_product_review(array(
                        'title'=>$this->input->post('txt_title'),
                        'detail'=>nl2br($this->input->post('txt_detail')),
                        'overall_rating'=>$this->input->post('chk_overall_rating'),
                        'money_rating'=>$this->input->post('chk_money_rating'),
                        'expectation_rating'=>$this->input->post('chk_expectation_rating'),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>NULL,
                        'user_name'=>$this->input->post('txt_user_name_review'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                }
                $_SESSION['tab_message'] = '<div class="msg_form_complete">ส่งรีวิวเสร็จสมบูรณ์</div>';
                redirect('shop/product/'.$this->uri->segment(3));
            } 
            // Submit Q&A
            else if($this->input->post('hid_task')=='qa') {
                if(is_user_login()==true) {
                    $this->product_qa_model->add_product_qa(array(
                        'question'=>nl2br($this->input->post('txt_question')),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>$this->input->post('txt_user_id'),
                        'user_name'=>$this->input->post('txt_user_name_qa'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                } else {
                    $this->product_qa_model->add_product_qa(array(
                        'question'=>nl2br($this->input->post('txt_question')),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>NULL,
                        'user_name'=>$this->input->post('txt_user_name_qa'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                }
                // send mail ไปหาเจ้าของสินค้ว่ามีคนถามคำถามเฉพาะ c2c
                if($data['product_data']['owner_type']=='c2c') {
                    // เอา id ของคำถามล่าสุดของสินต้านี้
                    $product_qa_data = $this->product_qa_model->get_product_qa('product_id',$data['product_data']['id'], 'ORDER BY id DESC LIMIT 1');
                    $user_data = $this->user_model->get_user('id',$data['product_data']['owner_id']);
                    // Send mail
                    $this->config->load('email');
                    $this->load->helper('mailer');
                    $config['smtp_host'] = $this->config->item('smtp_host');
                    $config['smtp_port'] = $this->config->item('smtp_port');
                    $config['smtp_user'] = $this->config->item('smtp_user');
                    $config['smtp_pass'] = $this->config->item('smtp_pass');
                    $config['mail'] = $this->config->item('user_product_question_mail');
                    $config['from'] = $this->config->item('user_product_question_from');
                    $config['subject'] = $this->config->item('user_product_question_subject');
                    $data['url'] = base_url().'user/product_answer/'.$product_qa_data['id'];
                    send_mail($user_data['email'],$this->load->view('mail_template/user_product_question',$data,true),$config);
                }
                $_SESSION['tab_message'] = '<div class="msg_form_complete">ส่งคำถามเสร็จสมบูรณ์</div>';
                redirect('shop/product/'.$this->uri->segment(3).'/'.url_title($data['product_data']['name']));
            }
            // Submit Media
            else if($this->input->post('hid_task')=='media') {
                if(is_user_login()==true) {
                    $this->product_media_model->add_product_media(array(
                        'title'=>$this->input->post('txt_title_media'),
                        'link'=>$this->input->post('txt_link'),
                        'detail'=>nl2br($this->input->post('txt_detail_media')),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>$this->input->post('txt_user_id'),
                        'user_name'=>$this->input->post('txt_user_name_media'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                } else {
                    $this->product_media_model->add_product_media(array(
                        'title'=>$this->input->post('txt_title_media'),
                        'link'=>$this->input->post('txt_link'),
                        'detail'=>nl2br($this->input->post('txt_detail_media')),
                        'approve'=>($data['product_data']['owner_type']=='b2c') ? 0 : 1,
                        'add_date'=>date("Y-m-d H:i:s"),
                        'user_id'=>NULL,
                        'user_name'=>$this->input->post('txt_user_name_media'),
                        'product_id'=>$this->input->post('hid_product_id')
                    ));
                }
                $_SESSION['tab_message'] = '<div class="msg_form_complete">ส่งวิดีโอเสร็จสมบูรณ์</div>';
                redirect('shop/product/'.$this->uri->segment(3));
            }
            // Submit Contact (C2c Only)
            else if($this->input->post('hid_task')=='contact') {
                    $this->config->load('email');
                    $this->load->helper('mailer');
                    $config['smtp_host'] = $this->config->item('smtp_host');
                    $config['smtp_port'] = $this->config->item('smtp_port');
                    $config['smtp_user'] = $this->config->item('smtp_user');
                    $config['smtp_pass'] = $this->config->item('smtp_pass');
                    $sender_mail = '';
                    if(is_user_login()) {
                        $user_data = get_login_info();
                        $sender_mail = $user_data['email'];
                    } else {
                        $sender_mail = $this->input->post('contact_email');
                    }
                    $product_owner = $this->user_model->get_user('id',$data['product_data']['owner_id']);
                    $config['mail'] = $sender_mail;
                    $config['from'] = $sender_mail;
                    $config['subject'] = 'ติดต่อสั่งซื้อ';
                    $data['product'] = $data['product_data'];
                    $data['qty'] = $this->input->post('contact_qty');
                    $data['detail'] = $this->input->post('contact_detail');
                    $data['sender_mail'] = $sender_mail;
                    send_mail($product_owner['email'],$this->load->view('mail_template/user_product_contact',$data,true),$config);
            }
        }
        $data['product_gallery_data'] = $this->product_gallery_model->get_product_gallery('product_id', $this->uri->segment(3));
        $login_info = get_login_info();
        $data['user_datas'] = $this->user_model->get_user('email', $login_info['email']);
        $data['review_data'] = $this->product_review_model->get_product_review('','','AND product_id="'.$data['product_data']['id'].'" AND approve=1');
        $data['media_data'] = $this->product_media_model->get_product_media('','','AND product_id="'.$data['product_data']['id'].'" AND approve=1');
        $data['qa_data'] = $this->product_qa_model->get_product_qa('','','AND product_id="'.$data['product_data']['id'].'" AND approve=1');
        $data['tab_message'] = isset($_SESSION['tab_message']) ? $_SESSION['tab_message'] : '';
        if(isset($_SESSION['tab_message'])) {
            unset($_SESSION['tab_message']);
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function cart() {
        if(is_user_login()==true) {
            /* set page title and view */
            $data['page_title'] = 'ตะกร้าสินค้า';
            $data['shop_content'] = 'shop/content/shop_cart';
            $data['page_content'] = 'shop/shop_view';
            $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ร้านค้า'=>'shop' ,$data['page_title']=>'shop/cart'));
            /* other code */
            $data['cart_item'] = $this->cart->contents();
            /* load view */
            $this->load->view('main_view', $data);
        } else {
            redirect();
        }
    }
    public function cart_login() {
        /* set page title and view */
        $data['page_title'] = 'เข้าสู่ระบบเพื่อสั่งซื้อสินค้า';
        $data['shop_content'] = 'shop/content/shop_cart_login';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url()));
       /* load view */
        $this->load->view('main_view', $data);
    }
    public function search() {
        /* set page title and view */
        $data['page_title'] = 'ค้นหา';
        $data['shop_content'] = 'shop/content/shop_search';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ร้านค้า'=>'shop'));
        // ENABLE QUERY STRING 
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        /* other code */
        $category = '';
        $price = '';
        $b = '';
        if($this->input->get('c')) {
            if($this->input->get('c')!='all') {
                $category = ' AND product_category_id="'.$this->input->get('c').'"';
                $b .= '?c='.$this->input->get('c');
            } else {
                $b .= '?c=all';
            }
            if($this->input->get('s')!='' && $this->input->get('e')!='') {
                $price = ' AND price BETWEEN '.$this->input->get('s').' AND '.$this->input->get('e');
                $b .= '&s='.$this->input->get('s').'&e='.$this->input->get('e');
            } else if($this->input->get('s')!='') {
                $price = ' AND price >= '.$this->input->get('s');
                $b .= '&s='.$this->input->get('s').'&e=';
            } else if($this->input->get('e')!='') {
                $price = ' AND price <= '.$this->input->get('e');
                $b .= '&s=&e='.$this->input->get('e');
            } else {
                $b .= '&s=&e=';
            }
            $guarantee = '';
            if($this->input->get('g') == 'all'){
                $guarantee ='';
                $b .= '&g=all';
            } else if($this->input->get('g') == 'guarantee') {
                $guarantee =' AND owner_type="b2c" ';
                $b .= '&g=guarantee';
            } else if($this->input->get('g') == 'shopping') {
                $guarantee ='AND owner_type="c2c" ';
                $b .= '&g=shopping';
            }
            $st = '0';
            if($this->input->get('per_page')) {
                $st = $this->input->get('per_page');
            }
            $product_name = $this->input->get('q');
            $b .= '&q='.$this->input->get('q');
            $data['keyword'] = $this->input->get('q');
            $data['product_data'] =  $this->product_model->get_product('', '', $guarantee.' AND name LIKE "%'.$product_name.'%" '.$category.''.$price.' LIMIT '.$st.',20');
            $this->load->library('pagination');
            $config['base_url'] = base_url().'shop/search/'.$b;
            $config['total_rows'] = count($this->product_model->get_product('', '', $guarantee.' AND name LIKE "%'.$product_name.'%" '.$category.''.$price));
            $config['per_page'] = '10';
            $config['uri_segment'] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

        }



            
//        if($this->input->post('btn_search')) {
//            $category = '';
//            $price = '';
//            if($this->input->post('ddl_category')!='all') {
//                $category = ' AND product_category_id="'.$this->input->post('ddl_category').'"';
//            }
//            if($this->input->post('txt_price_start')!='' && $this->input->post('txt_price_end')!='') {
//                $price = ' AND price BETWEEN '.$this->input->post('txt_price_start').' AND '.$this->input->post('txt_price_end');
//            } else if($this->input->post('txt_price_start')!='') {
//                $price = ' AND price >= '.$this->input->post('txt_price_start');
//            } else if($this->input->post('txt_price_end')!='') {
//                $price = ' AND price <= '.$this->input->post('txt_price_end');
//            }
//            $guarantee = '';
//            if($this->input->post('ddl_guarantee') == 'all'){
//                $guarantee ='';
//            } else if($this->input->post('ddl_guarantee') == 'guarantee') {
//                $guarantee =' AND owner_type="b2c" ';
//            } else if($this->input->post('ddl_guarantee') == 'shopping') {
//                $guarantee ='AND owner_type="c2c" ';
//            }
//            $product_name = $this->input->post('txt_search');
//            $data['keyword'] = $this->input->post('txt_search');
//            $data['product_data'] =  $this->product_model->get_product('', '', $guarantee.' AND name LIKE "%'.$product_name.'%" '.$category.''.$price);
//        }

        /* load view */
        $this->load->view('main_view', $data);
    }
    public function checkout() {
        /* set page title and view */
        $data['page_title'] = 'ชำระเงิน';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(), 'ร้านค้า'=>'shop', 'ตะกร้าสินค้า'=>'shop/cart', $data['page_title']=>'shop/checkout'));
        /* other code */
        $this->load->library('cart');
        $this->load->library('paypal_lib');
        $this->load->helper('table_field');
        $this->load->model('user/user_address_model');
        $this->load->model('user/user_profile_model');
        $this->load->model('shop/order_model');
        $this->load->model('shop/order_item_model');
        $this->load->model('shop/supplier_model');
        $login_info = '';

//        // Paypal
//        $this->paypal_lib->add_field('image_url', assets_image('logo.png')); // <-- Verify return
//        $this->paypal_lib->add_field('business', $this->config->item('paypal_email'));
//        $this->paypal_lib->add_field('return', site_url('shop/checkout_summary'));
//        $this->paypal_lib->add_field('cancel_return', site_url());
//        $this->paypal_lib->add_field('notify_url', site_url('shop/ipn')); // <-- IPN url
//        $this->paypal_lib->add_field('custom', '1234567890glixa'); // <-- Verify return
//        $this->paypal_lib->add_field('charset', 'utf-8'); // <-- Verify return
//        $this->paypal_lib->multi_items('true');
//
//        $this->paypal_lib->add_field('item_name_1', 'abc');
//        $this->paypal_lib->add_field('item_number_1', '1');
//        $this->paypal_lib->add_field('amount_1', '2');
//        $this->paypal_lib->add_field('quantity_1', '10');
//
//        $this->paypal_lib->add_field('item_name_2', 'abc123');
//        $this->paypal_lib->add_field('item_number_2', '2');
//        $this->paypal_lib->add_field('amount_2', '5');
//        $this->paypal_lib->add_field('quantity_2', '15');

        if(is_user_login()==true && $this->cart->total()>0) { //  login และมีสินค้าในตะกร้า
            $data['shop_content'] = 'shop/content/shop_checkout_login';
            $login_info = get_login_info();
            $data['user_data'] = $this->user_model->get_user('email', $login_info['email']);
            $data['user_profile_data'] = $this->user_profile_model->get_user_profile('user_id', $data['user_data']['id']);
            $data['user_address_data'] = $this->user_address_model->get_user_address('', '', ' user_id="'.$data['user_data']['id'].'" AND flag_del<>1');
        } else {
            redirect();
        }
        /* load view */
        $this->load->view('main_view', $data);
    }

    public function checkout_summary() {
        if(is_user_login()==false) {
            redirect();
        }
//        if(!isset($_SESSION['checkout_complete'])) {
//            redirect();
//        }
        // หน้าสรุปข้อมูลหลังจากการกด checkout
        $data['page_title'] = 'สรุปการชำระเงิน';
        $data['shop_content'] = 'shop/content/shop_checkout_summary';
        $data['page_content'] = 'shop/shop_view';
        /* other code */
        $data['page_breadcrumb'] = '';
          /* load view */
        $this->load->view('main_view', $data);
        // DELETE CHECKOUT DATA
        $this->cart->destroy();
        unset($_SESSION['order']);
        unset($_SESSION['checkout_complete']);
    }

    public function ipn() {
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        // post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        //If testing on Sandbox use:
        //$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        if (!$fp) {
        // HTTP ERROR
        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp($res, "VERIFIED") == 0) {
                // check the payment_status is Completed
                // check that txn_id has not been previously processed
                // check that receiver_email is your Primary PayPal email
                // check that payment_amount/payment_currency are correct
                // process payment
                // echo the response
                    echo "The response from IPN was: <b>" . $res . "</b><br><br>";
                    //loop through the $_POST array and print all vars to the screen.
//                    foreach ($_POST as $key => $value) {
//                        echo $key . " = " . $value . "<br>";
//                    }

                    $stringData = "";
                    $myFile = "C:\\ipn.txt";
                    foreach ($_POST as $key => $value) {
                        $stringData .= $key . " => " . $value . "\n";
                    }
                    $fh = fopen($myFile, 'w') or die("can't open file");
                    fwrite($fh, $stringData);



                } else if (strcmp($res, "INVALID") == 0) {
                    // log for manual investigation
                    // echo the response
                    echo "The response from IPN was: <b>" . $res . "</b>";
                }
            }
            fclose($fp);
        }
//        $stringData = "";
//        $myFile = "C:\\ipn.txt";
//        foreach ($_POST as $key => $value) {
//            $stringData .= $key . " => " . $value . "\n";
//        }
//        $fh = fopen($myFile, 'w') or die("can't open file");
//        fwrite($fh, $stringData);
//        fclose($fh);
    }


    // =========================================================================
    /*
     * Submit Add Item to Cart
     * ทำงานตอนกดปุ่มใส่ตะกร้า
     */
    public function add_cart() {
        if(is_user_login()) {
            $id = $this->input->post('hid_id');
            $options = array();
            if($this->input->post('ddl_option')) {
                foreach($this->input->post('ddl_option') as $opt) {
                    $tmp_opt = explode(',', $opt);
                    $options[$tmp_opt[0]] = $tmp_opt[1];
                }
            }
            $rowid = md5($id.($options!=null ? implode('',$options) : ''));
            echo $rowid;
            $product_data = $this->product_model->get_product('id', $id);
            $cart = $this->cart->contents();
            if (isset($cart[$rowid])) { // มี item นี้ใน cart อยู่แล้ qty จะ +1
                $qty = intval($cart[$rowid]['qty']) + 1;
                $this->cart->update(array(
                    'rowid' => $rowid,
                    'qty'   => $qty
                ));
            } else { // ยังไม่มี item นี้ใน cart จะ add เพิ่มเข้าไป
                if($this->input->post('ddl_option')) {
                    $this->cart->insert(array(
                        'id' => $id,
                        'qty' => 1,
                        'price' => $product_data['price'],
                        'name' => $product_data['name'],
                        'options' => $options
                    ));
                } else {
                    $this->cart->insert(array(
                        'id' => $id,
                        'qty' => 1,
                        'price' => $product_data['price'],
                        'name' => $product_data['name']
                    ));
                }
            }
            //echo '==<br><pre>';
            //print_r($this->cart->contents());
            redirect($this->input->post('hid_current_url'));
        } else {
            redirect('shop/cart_login');
        }


    }
    /*
     * Submit Update Item in Cart
     * ทำงานตอน update / delete item ใน cart
     */
    public function update_cart() {
        $rowids = $this->input->post('hid_rowid');
        $i=0;
        foreach($this->input->post('txt_quality') as $qty) {
            $rowid = $rowids[$i];
            if($qty=='') {
                $qty = 0;
            }
            $this->cart->update(array(
                'rowid'=>$rowid,
                'qty'=>$qty
            ));
            $i++;
        }
        redirect('shop/cart');
    }
    public function del_cart() {
        $rowid = $this->uri->segment(3);
        $this->cart->update(array(
            'rowid'=>$rowid,
            'qty'=>0
        ));
        redirect('shop/cart');
    }
    public function checkout_billing() {
        if($this->input->post('ajax')=='true') {
            $_SESSION['order']['shipping_billing'] = 'false'; // บอกว่า shipping ใช้ address เดียวกะ billing หรือไม่
            // Billing
            if($this->input->post('step')=='billing1') { // ใช้ Address ที่มีอยู่แล้ว
                if($this->input->post('goto')=='shipping') {
                    // เลือกที่อยู่ของ Billing แล้วกด Bill to this address
                    $_SESSION['order']['billing'] = $this->input->post('value');
                } else if ($this->input->post('goto')=='shipping_method') {
                    // เลือกที่อยู่ของ Billing แล้วกด Bill & Ship to this address
                    $_SESSION['order']['billing'] = $this->input->post('value');
                    $_SESSION['order']['shipping'] = $this->input->post('value');
                    $_SESSION['order']['shipping_billing'] = 'true'; // บอกว่า shipping ใช้ address เดียวกะ billing
                }
            } else if($this->input->post('step')=='billing2') { // เพิ่ม Address ใหม่
                if($this->input->post('goto')=='shipping') {
                    // เพิ่มที่อยู่ของ Billing แล้วกด Bill to this address
                    $_SESSION['order']['billing'] = array(
                        'firstname'=>$this->input->post('firstname'),
                        'lastname'=>$this->input->post('lastname'),
                        'address'=>$this->input->post('address'),
                        'tambon'=>$this->input->post('tambon'),
                        'amphoe'=>$this->input->post('amphoe'),
                        'province'=>$this->input->post('province'),
                        'postalcode'=>$this->input->post('postalcode'),
                        'tel_num'=>$this->input->post('tel_num'),
                        'fax_num'=>$this->input->post('fax_num')
                    );
                    // ***
                } else if ($this->input->post('goto')=='shipping_method') {
                    // เพิ่มที่อยู่ของ Billing แล้วกด Bill & Ship to this address
                    $_SESSION['order']['billing'] = array(
                        'firstname'=>$this->input->post('firstname'),
                        'lastname'=>$this->input->post('lastname'),
                        'address'=>$this->input->post('address'),
                        'tambon'=>$this->input->post('tambon'),
                        'amphoe'=>$this->input->post('amphoe'),
                        'province'=>$this->input->post('province'),
                        'postalcode'=>$this->input->post('postalcode'),
                        'tel_num'=>$this->input->post('tel_num'),
                        'fax_num'=>$this->input->post('fax_num')
                    );
                    $_SESSION['order']['shipping'] = array(
                        'firstname'=>$this->input->post('firstname'),
                        'lastname'=>$this->input->post('lastname'),
                        'address'=>$this->input->post('address'),
                        'tambon'=>$this->input->post('tambon'),
                        'amphoe'=>$this->input->post('amphoe'),
                        'province'=>$this->input->post('province'),
                        'postalcode'=>$this->input->post('postalcode'),
                        'tel_num'=>$this->input->post('tel_num'),
                        'fax_num'=>$this->input->post('fax_num')
                    );
                    $_SESSION['order']['shipping_billing'] = 'true'; // บอกว่า shipping ใช้ address เดียวกะ billing
                    // ***
                }
            }
        } else {
            redirect();
        }
    }
    public function checkout_shipping() {
        if($this->input->post('ajax')=='true') {
            if($this->input->post('step')=='shipping1') {
                $_SESSION['order']['shipping'] = $this->input->post('value');
                echo ($_SESSION['order']['shipping']);
            } else if($this->input->post('step')=='shipping2') {
                $_SESSION['order']['shipping'] = array(
                    'firstname'=>$this->input->post('firstname'),
                    'lastname'=>$this->input->post('lastname'),
                    'address'=>$this->input->post('address'),
                    'tambon'=>$this->input->post('tambon'),
                    'amphoe'=>$this->input->post('amphoe'),
                    'province'=>$this->input->post('province'),
                    'postalcode'=>$this->input->post('postalcode'),
                    'tel_num'=>$this->input->post('tel_num'),
                    'fax_num'=>$this->input->post('fax_num')
                );
                print_r($_SESSION['order']['shipping']);
            }
        } else {
            redirect();
        }
    }
    public function checkout_shipping_method() {
        if($this->input->post('ajax')=='true') {
            $_SESSION['order']['shipping_method'] = $this->input->post('value');
        } else {
            redirect();
        }
    }
    public function checkout_payment() {
        $login_info = get_login_info();
        $user_data = $this->user_model->get_user('email', $login_info['email']);
        $this->load->model('shop/order_model');
        $this->load->model('shop/order_item_model');
        $this->load->model('user/user_address_model');
        $billing_address_id = '';
        $shipping_address_id = '';
        $shipping_method = '';

        // Billing
        if(is_array($_SESSION['order']['billing'])==true) { // เพิ่ม address ใหม่
            // add address to db
            $this->user_address_model->add_user_address(array(
                'firstname'=>$_SESSION['order']['billing']['firstname'],
                'lastname'=>$_SESSION['order']['billing']['lastname'],
                'address'=>$_SESSION['order']['billing']['address'],
                'tambon'=>$_SESSION['order']['billing']['tambon'],
                'amphoe'=>$_SESSION['order']['billing']['amphoe'],
                'province'=>$_SESSION['order']['billing']['province'],
                'postalcode'=>$_SESSION['order']['billing']['postalcode'],
                'tel_num'=>$_SESSION['order']['billing']['tel_num'],
                'fax_num'=>$_SESSION['order']['billing']['fax_num'],
                'user_id'=>$user_data['id']
            ));
            // เอาค่า id ของ address ล่าสุดที่ถูกเพิ่ม
            $user_address_data = $this->user_address_model->get_user_address('user_id', $user_data['id'], 'ORDER BY id DESC');
            $billing_address_id = $user_address_data['id'];
        } else { // เลือก address เดิมที่มีอย่แล้ว
            $billing_address_id = $_SESSION['order']['billing'];
        }

        // Shipping
        if($_SESSION['order']['shipping_billing']=='true') { // shipping ใช้ address เดียวกับ billing (go shiping method)
            $shipping_address_id = $billing_address_id;
        } else { // shipping ใช้ address คนละอันกัน billing (go shipping)
            if(is_array($_SESSION['order']['shipping'])==true) { // เพิ่ม address ใหม่
                // add address to db
                $this->user_address_model->add_user_address(array(
                    'firstname'=>$_SESSION['order']['shipping']['firstname'],
                    'lastname'=>$_SESSION['order']['shipping']['lastname'],
                    'address'=>$_SESSION['order']['shipping']['address'],
                    'tambon'=>$_SESSION['order']['shipping']['tambon'],
                    'amphoe'=>$_SESSION['order']['shipping']['amphoe'],
                    'province'=>$_SESSION['order']['shipping']['province'],
                    'postalcode'=>$_SESSION['order']['shipping']['postalcode'],
                    'tel_num'=>$_SESSION['order']['shipping']['tel_num'],
                    'fax_num'=>$_SESSION['order']['shipping']['fax_num'],
                    'user_id'=>$user_data['id']
                ));
                // เอาค่า id ของ address ล่าสุดที่ถูกเพิ่ม
                $user_address_data = $this->user_address_model->get_user_address('user_id', $user_data['id'], 'ORDER BY id DESC');
                $shipping_address_id = $user_address_data['id'];
            } else { // เลือก address เดิมที่มีอย่แล้ว
                $shipping_address_id = $_SESSION['order']['shipping'];
            }
        }
        // Shipping Method
        $shipping_method = $_SESSION['order']['shipping_method'];
        $shipping_price = 0;
        if($shipping_method=='mail' && $this->cart->total()>100) {
            $shipping_price = 0;
        } else if($shipping_method=='mail' && $this->cart->total()<=100) {
            $shipping_price = 20;
        } else if($shipping_method=='ems' && $this->cart->total()>1000) {
            $shipping_price = 0;
        } else if($shipping_method=='ems' && $this->cart->total()<=1000) {
            $shipping_price = 30;
        }
        // Payment Details
        // add ทั้งหมดลง db
        $billing_address_data = $this->user_address_model->get_user_address('id', $billing_address_id);
        $shipping_address_data = $this->user_address_model->get_user_address('id', $shipping_address_id);
        $this->order_model->add_order(array(
            'order_date'=>date('Y-m-d H:i:s'),
            'shipping_method'=>$shipping_method,
            'total_price'=>(float)$shipping_price+(float)$this->cart->total(),
            'billing_address_id'=>$billing_address_id,
            'billing_firstname'=>$billing_address_data['firstname'],
            'billing_lastname'=>$billing_address_data['lastname'],
            'billing_address'=>$billing_address_data['address'],
            'billing_tambon'=>$billing_address_data['tambon'],
            'billing_amphoe'=>$billing_address_data['amphoe'],
            'billing_province'=>$billing_address_data['province'],
            'billing_postalcode'=>$billing_address_data['postalcode'],
            'billing_tel_num'=>$billing_address_data['tel_num'],
            'billing_fax_num'=>$billing_address_data['fax_num'],
            'shipping_address_id'=>$shipping_address_id,
            'shipping_firstname'=>$shipping_address_data['firstname'],
            'shipping_lastname'=>$shipping_address_data['lastname'],
            'shipping_address'=>$shipping_address_data['address'],
            'shipping_tambon'=>$shipping_address_data['tambon'],
            'shipping_amphoe'=>$shipping_address_data['amphoe'],
            'shipping_province'=>$shipping_address_data['province'],
            'shipping_postalcode'=>$shipping_address_data['postalcode'],
            'shipping_tel_num'=>$shipping_address_data['tel_num'],
            'shipping_fax_num'=>$shipping_address_data['fax_num'],
            'user_id'=>$user_data['id']
        ));
        // get last order_id ของ user คนนี้
        $order_data = $this->order_model->get_order('','','AND user_id="'.$user_data['id'].'" ORDER BY id DESC LIMIT 1');
        // add สินค้า
        foreach($this->cart->contents() as $items) {
            $this->order_item_model->add_order_item(array(
                'quantity'=>$items['qty'],
                'present_price'=>$items['price'],
                'product_id'=>$items['id'],
                'order_id'=>$order_data[0]['id']
            ));
            $query = $this->db->query("SELECT id FROM shop_order_item ORDER BY id DESC LIMIT 1");
            $last_order_item = $query->row_array();
//            echo $last_order_item;
            // add option of order item
            $this->load->model('order_item_option_model');
            if(isset($items['options'])) {
                foreach($items['options'] as $key => $val) {
                    $this->order_item_option_model->add_order_item_option(array(
                        'options'=>$key,
                        'value'=>$val,
                        'order_item_id'=>$last_order_item['id']
                    ));
                }
            }
//                foreach($items['options'] as $key => $val) {
//                    $this->order_item_option_model->add_order_item_option(array(
//                        'options'=>$key,
//                        'value'=>$val,
//                        'order_item_id'=>$last_order_item['id']
//                    ));
//                }
        }
        $deilver_record = explode(",", substr_replace($this->input->post('datas'),"",-1));
        foreach($deilver_record as $dr) {
            $deliver_col = explode(":",$dr);
            $this->order_item_model->add_order_item(array(
                'quantity'=>1,
                'present_price'=>str_replace("฿","",$deliver_col[1]),
                'product_des'=>trim($deliver_col[0]),
                'order_id' => $order_data[0]['id']
            ));
        }
        $_SESSION['checkout_complete'] = 'true';

//        // DELETE
//        $this->cart->destroy();
//        unset($_SESSION['order']);
    }

    function calculate_ems() {
        header("content-type: text/html; charset=utf-8");
        $this->load->model("supplier_model");
        $g_product = array();
        $s_product = array();
        foreach($this->cart->contents() as $item) {
            $product_data = $this->product_model->get_product('id',$item['id']);
            $supplier_data = $this->supplier_model->get_supplier('id',$product_data['owner_id']);
            if($product_data['owner_type']=='b2c') { // gold
                $g_product[] = $product_data;
            } else { // silver
                $s_product[] = $product_data;
            }
        }
//        echo "<pre>";
//        print_r($g_product);
        $sum_gold_price = 0;
        foreach($g_product as $gp) {
            $query = $this->db->query("SELECT price FROM ems WHERE min_weight<=? AND max_weight>=?",array($gp['weight'],$gp['weight']));
            $result = $query->row_array();
            $sum_gold_price+=(float)$result['price'];
//            echo $result['price']."<br>";
        }
        echo $sum_gold_price.',';
        $sum_silver_price = array();
        $supp = array();
        foreach ($s_product as $sp) {
            $product_data = $this->product_model->get_product('id', $sp['id']);
            $supplier_data = $this->supplier_model->get_supplier('id', $product_data['owner_id']);
            if ($product_data['owner_type'] == 'silver') { // silver
                $supp[] = $supplier_data['name'];
            }
            //$query = $this->db->query("SELECT price FROM ems WHERE min_weight<=? AND max_weight>=?",array($gp['weight'],$gp['weight']));
        }
        $supp = array_unique($supp);
        $sum_s_price = 0;
        foreach ($supp as $value) {
            $sum_s_price = 0;
            foreach ($s_product as $sp) {
                
                $product_data = $this->product_model->get_product('id', $sp['id']);
                $supplier_data = $this->supplier_model->get_supplier('id', $product_data['owner_id']);
                if ($supplier_data['name'] == $value && $product_data['owner_type'] == 'silver') {
                    $query = $this->db->query("SELECT price FROM ems WHERE min_weight<=? AND max_weight>=?",array($sp['weight'],$sp['weight']));
                    $result = $query->row_array();
                    $sum_s_price +=(float)$result['price'];
                }
            }
            echo $sum_s_price.",";
        }
//        echo $sum_gold_price.',';
//        foreach($sum_silver_price as $ssp) {
//            echo $ssp.',';
//        }
        
    }


    function contact() {
        /* set page title and view */
        $data['user_data'] = $this->user_model->get_user('username',$this->uri->segment(3));
        $data['product_data'] = $this->product_model->get_product('','', 'AND owner_id="'.$data['user_data']['id'].'" AND owner_type="c2c"');
        $data['page_title'] = 'ติดต่อ '.$data['user_data']['username'];
        $data['shop_content'] = 'shop/content/shop_contact';
        $data['page_content'] = 'shop/shop_view';
        $data['page_breadcrumb'] = breadcrumb(array('หน้าหลัก'=>base_url(),'สินค้าของ '.$data['user_data']['username']=>base_url().$data['user_data']['username'],$data['page_title']=>'shop/contact/'.$data['user_data']['username']));
        // ตรวจสอบว่า user มีสินค้าหรือไม่ ถ้าไม่มีจะ contact ไม่ได้
        $user_product_data = $this->product_model->get_product('','','AND owner_id="'.$data['user_data']['id'].'" AND owner_type="c2c"');
        if(count($user_product_data)==0) {
            redirect();
        }
        /* other code */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('contact_email', 'อีเมล', 'required|valid_email');
        $this->form_validation->set_rules('contact_qty', 'จำนวน', 'required|numeric');
        // กด submit edit password
        if($this->form_validation->run()==true) {
            $sender_mail = $this->input->post('contact_email');
            $contact_product = $this->product_model->get_product('id',$this->input->post('contact_product'));
            $this->config->load('email');
            $this->load->helper('mailer');
            $config['smtp_host'] = $this->config->item('smtp_host');
            $config['smtp_port'] = $this->config->item('smtp_port');
            $config['smtp_user'] = $this->config->item('smtp_user');
            $config['smtp_pass'] = $this->config->item('smtp_pass');
            $config['mail'] = $sender_mail;
            $config['from'] = $sender_mail;
            $config['subject'] = 'ติดต่อสั่งซื้อ';
            $data['product'] = $contact_product;
            $data['qty'] = $this->input->post('contact_qty');
            $data['detail'] = $this->input->post('contact_detail');
            $data['sender_mail'] = $sender_mail;
            send_mail($data['user_data']['email'],$this->load->view('mail_template/user_product_contact',$data,true),$config);
            $data['message'] = "<div class='msg_form_complete'>ส่งอีเมลติดต่อสั่งซื้อเรียบร้อย</div>";
        }
        /* load view */
        $this->load->view('main_view', $data);
    }

    public function pdf() {
        $this->load->library('tcpdf/tcpdf');
          ob_end_clean();
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 002');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray(2);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('angsanaupc', '', 20);

        // add a page
        $pdf->AddPage();

        $pdf->writeHTML('<b>ทดสอบ</b>');
        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_002.pdf', 'I');
        
    }
    function des() {
        $this->cart->destroy();
    }
}
?>
