<?php
class supplier extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/supplier_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ผู้ผลิดสินค้า';
            $data['page_content'] = 'admin/content/supplier_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ผู้ผลิดสินค้า'=>'admin/supplier'));
            /* other code */
            $this->load->helper('table_field');

            // DELETE
            if($this->input->post('task')=='delete') {
                foreach ($this->input->post('chk_row') as $value) { // $value = product_id
                    $this->supplier_model->edit_supplier('id', $value, array(
                        'flag_del'=>'1'
                    ));
                }
            }
            
            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'name'=>array(get_field_lang('shop_supplier', 'name'), '200'),
                                    'contact_firstname'=>array(get_field_lang('shop_supplier', 'contact_firstname'), '160'),
                                    'contact_lastname'=>array(get_field_lang('shop_supplier', 'contact_lastname'), '160'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'name'=>get_field_lang('shop_supplier', 'name'),
                                    'contact_firstname'=>get_field_lang('shop_supplier', 'contact_firstname'),
                                    'contact_lastname'=>get_field_lang('shop_supplier', 'contact_lastname'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/supplier/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','name','contact_firstname','contact_lastname');
            // *** ชื่อ table
            $table = ' shop_supplier ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 ';
            // *** default ORDER BY
            $order = ' name ';
            // *** จำนวน row ต่อ page
            $limit = 10;
            // *** base url ของเพจทีมี datatable
            $url = $data['datatable_url'];
            // *** default segment ของ pagination [ /user/index/p/NUM ] NUM = 4
            $config['uri_segment'] = 5;
            /* CREATE BASR URL FOR PAGINATION */
            $seg_url = $this->uri->uri_to_assoc($data['num_uri_to_assoc']);
            $config['uri_segment'] = $this->uri->total_segments();
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
                $query .= ' ORDER BY '.$order.' ASC ';
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
            $data['datatable'] = $this->load->view('admin/template/supplier_datatable', $data, true);
            // ========== DATATABLE ==========
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
    public function add() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'เพิ่มผู้ผลิดสินค้า';
            $data['page_content'] = 'admin/content/supplier_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ผู้ผลิดสินค้า'=>'admin/supplier', 'เพิ่มผู้ผลิดสินค้า'=>'admin/supplier/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'name'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'address'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'tambon'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'amphoe'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'province'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'postalcode'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'phone_number1'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'phone_number2'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'fax_number1'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'fax_number2'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'contact_firstname'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'contact_lastname'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'email'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'website'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'detail')
            ), '');
            $this->form_validation->set_rules($validation_config);
            // กด submit add supplier
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->supplier_model->add_supplier(array(
                        'name'=>$this->input->post('txt_name'),
                        'contact_firstname'=>$this->input->post('txt_contact_firstname'),
                        'contact_lastname'=>$this->input->post('txt_contact_lastname'),
                        'address'=>nl2br($this->input->post('txt_address')),
                        'tambon'=>$this->input->post('txt_tambon'),
                        'amphoe'=>$this->input->post('txt_amphoe'),
                        'province'=>$this->input->post('txt_province'),
                        'postalcode'=>$this->input->post('txt_postalcode'),
                        'phone_number1'=>$this->input->post('txt_phone_number1'),
                        'phone_number2'=>$this->input->post('txt_phone_number2'),
                        'fax_number1'=>$this->input->post('txt_fax_number1'),
                        'fax_number2'=>$this->input->post('txt_fax_number2'),
                        'email'=>$this->input->post('txt_email'),
                        'website'=>$this->input->post('txt_website'),
                        'detail'=>nl2br($this->input->post('txt_detail')),
                        'add_date'=>date("Y-m-d H:i:s")
                    ));
                    redirect('admin/supplier/add');
                }
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }

    public function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ข้อผู้ผลิตสินค้า';
            $data['page_content'] = 'admin/content/supplier_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ผู้ผลิตสินค้า'=>'admin/supplier', 'ข้อมูลสินค้า'=>'admin/supplier/edit/'.$this->uri->segment(4)));
            /* other code */
            $this->load->helper('table_field');
            $data['supplier_data'] = $this->supplier_model->get_supplier('id', $this->uri->segment(4));
            // หาปีที่มีก่ารส่งของ
            $query = $this->db->query("SELECT DISTINCT YEAR(deliver_date) AS year FROM shop_purchase_item WHERE deliver_date IS NOT NULL ORDER BY YEAR(deliver_date) ASC");
            $data['year'] = $query->result_array();
            // submit edit supplier

            $this->load->library('form_validation');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'name'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'address'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'tambon'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'amphoe'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'province'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'postalcode'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'phone_number1'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'phone_number2'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'fax_number1'),
                array('prefix'=>'txt', 'table'=>'shop_supplier', 'field'=>'fax_number2')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $this->form_validation->set_rules('txt_user_id', 'รหัสของผู้ใช้งานที่เป็นเจ้าของแอคเคาท์', 'numeric');
            // กด submit edit supplier
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->supplier_model->edit_supplier('id', $this->uri->segment(4), array(
                        'name'=>$this->input->post('txt_name'),
                        'contact_firstname'=>$this->input->post('txt_contact_firstname'),
                        'contact_lastname'=>$this->input->post('txt_contact_lastname'),
                        'address'=>nl2br($this->input->post('txt_address')),
                        'tambon'=>$this->input->post('txt_tambon'),
                        'amphoe'=>$this->input->post('txt_amphoe'),
                        'province'=>$this->input->post('txt_province'),
                        'postalcode'=>$this->input->post('txt_postalcode'),
                        'phone_number1'=>$this->input->post('txt_phone_number1'),
                        'phone_number2'=>$this->input->post('txt_phone_number2'),
                        'fax_number1'=>$this->input->post('txt_fax_number1'),
                        'fax_number2'=>$this->input->post('txt_fax_number2'),
                        'email'=>$this->input->post('txt_email'),
                        'website'=>$this->input->post('txt_website'),
                        'detail'=>nl2br($this->input->post('txt_detail')),
                        'user_id'=>($this->input->post('txt_user_id')=='') ? null : $this->input->post('txt_user_id')
                    ));
                    redirect(current_url());
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
