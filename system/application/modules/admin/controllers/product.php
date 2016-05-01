<?php
class Product extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_category_model');
        $this->load->model('shop/supplier_model');
        $this->load->model('shop/product_model');
        $this->load->model('shop/product_gallery_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
        $this->load->model('user/user_model');
        $this->load->model('admin/product_lot_model');
    }
    public function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'สินค้า';
            $data['page_content'] = 'admin/content/product_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สินค้า'=>'admin/product'));
            /* other code */
            $this->load->helper('table_field');

            // EDIT
            if($this->input->post('task')=='edit') {
                $this->product_model->edit_product('id', $this->input->post('edit_id'), array(
                    $this->input->post('edit_field')=>$this->input->post('edit_value')
                ));
            }
            // DELETE
            if($this->input->post('task')=='delete') {
                foreach ($this->input->post('chk_row') as $value) { // $value = product_id
                    $this->product_model->edit_product('id', $value, array(
                        'flag_del'=>'1'
                    ));
                }
            }
            
            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'name'=>array(get_field_lang('shop_product', 'name'), '200'),
                                    'cost'=>array(get_field_lang('shop_product', 'cost'), '120'),
                                    'price'=>array(get_field_lang('shop_product', 'price'), '120'),
                                    'quantity'=>array(get_field_lang('shop_product', 'quantity'), '100'),
                                    'unit'=>array(get_field_lang('shop_product', 'unit'), '80'),
                                    'available'=>array(get_field_lang('shop_product', 'available'), '80'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'name'=>get_field_lang('shop_product', 'name'),
                                    'cost'=>get_field_lang('shop_product', 'cost'),
                                    'price'=>get_field_lang('shop_product', 'price'),
                                    'quantity'=>get_field_lang('shop_product', 'quantity'),
                                    'unit'=>get_field_lang('shop_product', 'unit'),
                                    'available'=>get_field_lang('shop_product', 'available'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/product/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','name','cost','price','quantity','unit','available');
            // *** ชื่อ table
            $table = ' shop_product ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 AND (type2!="promotion" OR type2 IS NULL)';
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
            $data['datatable'] = $this->load->view('admin/template/product_datatable', $data, true); // *** datatable template
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
            $data['page_title'] = 'เพิ่มสินค้า';
            $data['page_content'] = 'admin/content/product_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สินค้า'=>'admin/product', 'เพิ่มสินค้า'=>'admin/product/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'name'),
//                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'cost'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'price'),
//                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'quantity'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'unit'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'title'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'detail'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'full_price'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'weight'),
//                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'size'),
//                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'color'),
                array('prefix'=>'ddl', 'table'=>'shop_product', 'field'=>'options'),
                array('prefix'=>'ddl', 'table'=>'shop_product', 'field'=>'owner_id'),
                array('prefix'=>'ddl', 'table'=>'shop_product', 'field'=>'product_category_id')
            ), '');
            $this->form_validation->set_rules($validation_config);
            // กด submit add product
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->product_model->add_product(array(
                        'name'=>$this->input->post('txt_name'),
                        'title'=>$this->input->post('txt_title'),
                        'detail'=>$this->input->post('txt_detail'),
                        'image'=>($this->input->post('txt_image')!='คลิก') ? $this->input->post('txt_image') : null,
                        //'cost'=>(float)$this->input->post('txt_cost'),
                        'price'=>(float)$this->input->post('txt_price'),
                        //'quantity'=>$this->input->post('txt_quantity'),
                        'unit'=>$this->input->post('txt_unit'),
                        'full_price'=>($this->input->post('txt_full_price')!='') ? $this->input->post('txt_full_price') : null,
                        'weight'=>($this->input->post('txt_weight')!='') ? $this->input->post('txt_weight') : null,
                        //'size'=>$this->input->post('txt_size'),
                        //'color'=>$this->input->post('txt_color'),
                        'type'=>($this->input->post('ddl_type')=='null') ? NULL : $this->input->post('ddl_type'),
                        'options'=>$this->input->post('ddl_options'),
                        'add_date'=>date("Y-m-d H:i:s"),
                        'owner_id'=>$this->input->post('ddl_supplier_id'),
                        'owner_type'=>$this->input->post('ddl_owner_type'),
                        'product_category_id'=>$this->input->post('ddl_product_category_id')
                    ));
                    // add product gallery
                    if($this->input->post('txt_gallery')) {
                        $query = $this->db->query("SELECT id FROM shop_product ORDER BY id DESC LIMIT 1");
                        $product = $query->row_array();
                        foreach ($this->input->post('txt_gallery') as $value) {
                            if($value != 'คลิก') {
                                $this->product_gallery_model->add_product_gallery(array(
                                    'image'=>$value,
                                    'product_id'=>$product['id']
                                ));
                            }
                        }
                    }
                    // add product option
                    if($this->input->post('txt_option') && $this->input->post('txt_value')) {
                        $query = $this->db->query("SELECT id FROM shop_product ORDER BY id DESC LIMIT 1");
                        $product = $query->row_array();
                        $this->load->model('shop/product_option_model');
                        $option = $this->input->post('txt_option');
                        $option_value = $this->input->post('txt_value');
                        for($i=0;$i<count($option);$i++) {
                            if($option[$i]!='' && $option_value[$i]!='') {
                                $this->product_option_model->add_product_option(array(
                                    'options'=>$option[$i],
                                    'value'=>$option_value[$i],
                                    'product_id'=>$product['id']
                                ));
                            }
                        }
                    }
                    redirect('admin/product/add');
                }
            }
            $data['supplier_data'] = $this->supplier_model->get_supplier('','','');
            $data['product_category_data'] = $this->product_category_model->get_product_category('', '', 'AND product_category_id IS NULL'); // เลือก childe category
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
    public function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            $this->load->model('shop/product_review_model');
            //$this->load->model('shop/product_link_model');
            $this->load->model('shop/product_qa_model');
            $this->load->model('shop/product_option_model');
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลสินค้า';
            $data['page_content'] = 'admin/content/product_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'สินค้า'=>'admin/product', 'ข้อมูลสินค้า'=>'admin/product/edit/'.$this->uri->segment(4)));
            /* other code */
            $this->load->helper('table_field');
            $data['product_data'] = $this->product_model->get_product('id', $this->uri->segment(4));
            $data['product_gallery_data'] = $this->product_gallery_model->get_product_gallery('product_id', $this->uri->segment(4));

            // เช็คว่าเป็น b2c หรือ c2c
            if($data['product_data']['owner_type']=='b2c') { // ของ supplier
                $data['owner_data'] = $this->supplier_model->get_supplier('','','');
            } else { // ของ user
                $data['owner_data'] = $this->user_model->get_user('','','');
            }

            $data['product_category_data'] = $this->product_category_model->get_product_category('', '', 'AND product_category_id IS NULL'); // เลือก childe category
            $data['product_review'] = $this->product_review_model->get_product_review('','','');
            $data['product_lot_data'] = $this->product_lot_model->get_product_lot('','',' AND product_id="'.$this->uri->segment(4).'"');
            $data['product_option_data'] = $this->product_option_model->get_product_option('','', 'product_id="'.$this->uri->segment(4).'"');
            $this->load->library('form_validation');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'name'),
                //array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'cost'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'price'),
                //array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'quantity'),
                array('prefix'=>'txt', 'table'=>'shop_product', 'field'=>'unit')
            ), '');
            $this->form_validation->set_rules($validation_config);
            // กด submit add product
            if($this->form_validation->run()==true) {
                // edit product
                $this->product_model->edit_product('id',$this->uri->segment(4),array(
                    'name'=>$this->input->post('txt_name'),
                    'title'=>$this->input->post('txt_title'),
                    'detail'=>$this->input->post('txt_detail'),
                    'image'=>($this->input->post('txt_image')!='คลิก') ? $this->input->post('txt_image') : null,
                    //'cost'=>(float)$this->input->post('txt_cost'),
                    'price'=>(float)$this->input->post('txt_price'),
                    //'quantity'=>$this->input->post('txt_quantity'),
                    'unit'=>$this->input->post('txt_unit'),
                    'full_price'=>($this->input->post('txt_full_price')!='') ? $this->input->post('txt_full_price') : null,
                    'weight'=>($this->input->post('txt_weight')!='') ? $this->input->post('txt_weight') : null,

                    //'size'=>$this->input->post('txt_size'),
                    //'color'=>$this->input->post('txt_color'),
                    'type'=>($this->input->post('ddl_type')=='null') ? NULL : $this->input->post('ddl_type'),
                    'owner_id'=>$this->input->post('owner_id'),
                    //'owner_type'=>$this->input->post('ddl_owner_type'),
                    'product_category_id'=>$this->input->post('ddl_product_category_id')
                ));
                // edit product gallery
                if($this->input->post('txt_gallery')) {
                    // ลบ gallery เดิมออกก่อนแล้ว add เข้าไปใหม่
                    $old_gallery = $this->product_gallery_model->get_product_gallery('product_id', $this->uri->segment(4));
                    foreach ($old_gallery as $value) {
                        $this->product_gallery_model->del_product_gallery('id', $value['id']);
                    }
                    // add gallery เข้าไปใหม่
                    foreach ($this->input->post('txt_gallery') as $value) {
                        if($value != 'คลิก') {
                            $this->product_gallery_model->add_product_gallery(array(
                                'image'=>$value,
                                'product_id'=>$this->uri->segment(4)
                            ));
                        }
                    }
                } else {
                    $old_gallery = $this->product_gallery_model->get_product_gallery('product_id', $this->uri->segment(4));
                    foreach ($old_gallery as $value) {
                        $this->product_gallery_model->del_product_gallery('id', $value['id']);
                    }
                }
                // edit product option
                if($this->input->post('txt_option') && $this->input->post('txt_value')) {
                    // ลบของเก่าออกไป
                    foreach($data['product_option_data'] as $option) {
                        $this->product_option_model->del_product_option('product_id',$option['product_id']);
                    }
                    // add ของใหม่
                    $option = $this->input->post('txt_option');
                    $option_value = $this->input->post('txt_value');
                    for($i=0;$i<count($option);$i++) {
                        if($option[$i]!='' && $option_value[$i]!='') {
                            $this->product_option_model->add_product_option(array(
                                'options'=>$option[$i],
                                'value'=>$option_value[$i],
                                'product_id'=>$this->uri->segment(4)
                            ));
                        }
                    }
                } else {
                    // ลบของเก่าออกไป
                    foreach($data['product_option_data'] as $option) {
                        $this->product_option_model->del_product_option('product_id',$option['product_id']);
                    }
                }
                redirect(current_url());
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
}
?>
