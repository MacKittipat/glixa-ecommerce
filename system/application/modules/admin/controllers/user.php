<?php
class User extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'สมาชิก';
            $data['page_content'] = 'admin/content/user_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สมาชิก'=>'admin/user'));
            /* other code */
            $this->load->helper('table_field');

            // EDIT
            if($this->input->post('task')=='edit') {
                $this->user_model->edit_user('id', $this->input->post('edit_id'), array(
                    $this->input->post('edit_field')=>$this->input->post('edit_value')
                ));
            }
            // DELETE
            if($this->input->post('task')=='delete') {
                foreach ($this->input->post('chk_row') as $value) { // $value = user_id
                    $this->user_model->edit_user('id', $value, array(
                        'flag_del'=>'1'
                    ));
                }
            }

            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'email'=>array(get_field_lang('wive_user', 'email'), '200'),
                                    'firstname'=>array(get_field_lang('wive_user', 'firstname'), '160'),
                                    'lastname'=>array(get_field_lang('wive_user', 'lastname'), '160'),
                                    'level'=>array(get_field_lang('wive_user', 'level'), '100'),
                                    'available'=>array(get_field_lang('wive_user', 'available'), '80'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'email'=>get_field_lang('wive_user', 'email'),
                                    'firstname'=>get_field_lang('wive_user', 'firstname'),
                                    'lastname'=>get_field_lang('wive_user', 'lastname'),
                                    'level'=>get_field_lang('wive_user', 'level'),
                                    'available'=>get_field_lang('wive_user', 'available'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/user/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','email','firstname','lastname','level','available');
            // *** ชื่อ table
            $table = ' wive_user ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 ';
            // *** default ORDER BY
            $order = ' regis_date ';
            // *** จำนวน row ต่อ page
            $limit = 10;
            // *** base url ของเพจทีมี datatable
            $url = $data['datatable_url'];
            // *** default segment ของ pagination [ /user/index/p/NUM ] NUM = 4
            $config['uri_segment'] = 5;
            /* CREATE BASR URL FOR PAGINATION */
            $seg_url = $this->uri->uri_to_assoc($data['num_uri_to_assoc']);
            if(isset($seg_url['p'])) { // มี p ใน url ค่า pagination คือตัวสุดท้าย
                $config['uri_segment'] = $this->uri->total_segments();
            } 
            if(isset($seg_url['sf']) && isset($seg_url['sv']) && !isset($seg_url['of']) && !isset($seg_url['ov'])) { // มี search
                $url = $url.'sf/'.$seg_url['sf'].'/sv/'.$seg_url['sv'].'/p/';
            } else if(isset($seg_url['of']) && isset($seg_url['ov']) && !isset($seg_url['sf']) && !isset($seg_url['sv'])) { // มี order
                $url = $url.'of/'.$seg_url['of'].'/ov/'.$seg_url['ov'].'/p/';
            } else if(isset($seg_url['sf']) && isset($seg_url['sv']) && isset($seg_url['of']) && isset($seg_url['ov'])) { // มี search และ order
                $url = $url.'of/'.$seg_url['of'].'/ov/'.$seg_url['ov'].'/sf/'.$seg_url['sf'].'/sv/'.$seg_url['sv'].'/p/';
            } else { // ไม่มี search and sort
                $url = $url.'p/';
            }
           /* SELECT */
            $query = "SELECT ";
            foreach($field as $value) {
                $query .= $value.',';
            }
            $query = substr_replace($query, '', -1);
            /* FROM */
            $query .= ' FROM '.$table.' ';
            /* WHERE */
            // search
            if(isset($seg_url['sf']) && isset($seg_url['sv'])) { // have search
                $whe .= ' AND '.$seg_url['sf'].' LIKE "%'.$seg_url['sv'].'%" ';
                $query .= $whe;
            } else { // no search
                $query .= $whe;
            }
            /* ORDER BY */
            if(isset($seg_url['of']) && isset($seg_url['ov'])) { // have order
                $query .= ' ORDER BY '.$seg_url['of'].' '.strtoupper($seg_url['ov']);
            } else {
                $query .= ' ORDER BY '.$order.' DESC ';
            }
            /* LIMIT */
            $start = 0;
            if($this->uri->segment($config['uri_segment'])) {
                $start = intval($this->uri->segment($config['uri_segment']));
                $query .= ' LIMIT '.$start.','.$limit;
            } else {
                $query .= ' LIMIT 0,'.$limit;
            }
            // run query
            $table_data = $this->db->query($query);
            // data ของ table
            $data['table_data'] = $table_data->result_array();
            // pagination
            $query_data_all = $this->db->query('SELECT id FROM '.$table.' '.$whe);
            $this->load->library('pagination');
            $config['base_url'] = $url; // base url ของ pagination
            $config['total_rows'] = $query_data_all->num_rows(); // จำนวน row ทั้งหมด
            $config['num_links'] = 6; // จำนวน link ของ pagination
            $config['per_page'] = $limit; // จำนวน row ต่อ page
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // load datatable
            $data['datatable'] = $this->load->view('admin/template/user_datatable', $data, true);
            // ========== DATATABLE ==========
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
    
    public function profile() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลสมาชิก';
            $data['page_content'] = 'admin/content/user_profile';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สมาชิก'=>'admin/user', 'ข้อมูลสมาชิก'=>'admin/user/profile/'.$this->uri->segment(4)));
            /* other code */
            $this->load->model('shop/supplier_model');
            $this->load->helper('table_field');
            $user_data = $this->user_model->get_user('id', $this->uri->segment(4));
            $data['user_data'] = $user_data;
            // กด submit edit
            $this->load->library('form_validation');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'firstname'),
                array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'lastname')
            ), '');
            $this->form_validation->set_rules($validation_config);
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->user_model->edit_user('id', $this->uri->segment(4), array(
                        'firstname'=>$this->input->post('txt_firstname'),
                        'lastname'=>$this->input->post('txt_lastname')
                    ));
//                    $this->supplier_model->edit_supplier('id', $this->input->post('ddl_supplier_id'), array(
//                        'user_id'=>$data['user_data']['id']
//                    ));
                    redirect(current_url());
                }
            }
            if($user_data['level']=='supplier') {
                $data['supplier_data'] = $this->supplier_model->get_supplier('user_id',$user_data['id']);
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }

    public function add() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'เพิ่มสมาชิก';
            $data['page_content'] = 'admin/content/user_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สมาชิก'=>'admin/user', 'เพิ่มสมาชิก'=>'admin/user/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field'); // ใช้ช่วยโหลดภาษาของ table field
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'password'),
                array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'firstname'),
                array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'lastname')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $this->form_validation->set_rules('txt_email', get_field_lang('wive_user', 'email'), 'trim|required|valid_email|unique[wive_user.email]');
            $this->form_validation->set_rules('txt_cpassword', get_field_lang('wive_user', 'cpassword'), 'trim|required|matches[txt_password]');
            // กด submit register
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->user_model->register(array(
                        'email' => $this->input->post('txt_email'),
                        'password' => $this->input->post('txt_password'),
                        'firstname' => $this->input->post('txt_firstname'),
                        'lastname' => $this->input->post('txt_lastname'),
                        'regis_date'=>date("Y-m-d H:i:s")
                    ));
                // add user profile
                $this->load->model('user/user_profile_model');
                $user_data = $this->user_model->get_user('email', $this->input->post('txt_email'));
                $this->user_profile_model->add_user_profile(array(
                    'user_id'=>$user_data['id']
                ));
                    redirect('admin/user/add');
                }
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }

}
?>