<?php
class Product_category extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_category_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ประเภทสินค้า';
            $data['page_content'] = 'admin/content/product_category_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้า'=>'admin/product_category'));
            /* other code */
            $this->load->helper('table_field');

            // Delete
            if($this->input->post('task')=='delete') {
                $this->load->model('shop/product_model');
                // ถ้าลบ parent category : ลบ sub category และ set category ของ product เป็น null
                $q = $this->db->query('SELECT id FROM shop_product_category WHERE id=? AND product_category_id IS NULL', array($this->input->post('edit_id')));
                if($q->num_rows()!=0) {
                    // del parent
                    $this->product_category_model->edit_product_category('id', $this->input->post('edit_id'), array(
                        'flag_del'=>'1'
                    ));
                    // del child
                    $this->product_category_model->edit_product_category('product_category_id', $this->input->post('edit_id'), array(
                        'flag_del'=>'1'
                    ));
                    // ==set product category to null==
                    // select sub category id
                    $q = $this->db->query('SELECT id FROM shop_product_category WHERE product_category_id=?', array($this->input->post('edit_id')));
                    foreach ($q->result_array() as $row) {
                        $this->product_model->edit_product('product_category_id',$row['id'], array(
                            'product_category_id'=>NULL
                        ));
                    }
                } else {
                    // ==set product category to null==
                    $this->product_model->edit_product('product_category_id',$this->input->post('edit_id'), array(
                        'product_category_id'=>NULL
                    ));
                    // delete sub category
                    $this->product_category_model->edit_product_category('id', $this->input->post('edit_id'), array(
                        'flag_del'=>'1'
                    ));
                }
            }

            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'category_code'=>array(get_field_lang('shop_product_category', 'category_code'), '150'),
                                    'name'=>array(get_field_lang('shop_product_category', 'name'), '200'),
                                    'product_category_id'=>array(get_field_lang('shop_product_category', 'product_category_id'), '200'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'category_code'=>get_field_lang('shop_product_category', 'category_code'),
                                    'name'=>get_field_lang('shop_product_category', 'name'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/product_category/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','category_code','name','product_category_id');
            // *** ชื่อ table
            $table = ' shop_product_category ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 ';
            // *** default ORDER BY
            $order = ' category_code ';
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
            $data['datatable'] = $this->load->view('admin/template/product_category_datatable', $data, true);
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
            $data['page_title'] = 'เพิ่มประเภทสินค้า';
            $data['page_content'] = 'admin/content/product_category_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้า'=>'admin/product_category', 'เพิ่มประเภทสินค้า'=>'admin/product_category/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            // มีการเลือก parent category
            $product_category_id = null;
            if($this->input->post('ddl_product_category_id')) {
                $product_category_id = $this->input->post('ddl_product_category_id');
            }
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'category_code'),
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'name'),
                array('prefix'=>'ddl', 'table'=>'shop_product_category', 'field'=>'product_category_id')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $this->form_validation->set_rules('txt_category_code', get_field_lang('shop_product_category', 'category_code'), 'trim|required');
            // submit add
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->product_category_model->add_product_category(array(
                        'category_code'=>$this->input->post('txt_category_code'),
                        'name'=>$this->input->post('txt_name'),
                        'product_category_id'=>$product_category_id
                    ));
                    redirect('admin/product_category/add');
                }
            }
            $product_category_data = $this->product_category_model->get_product_category('','',' AND product_category_id IS NULL');
            $data['product_category_data'] = $product_category_data;
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
    public function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลประเภทสินค้า';
            $data['page_content'] = 'admin/content/product_category_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้า'=>'admin/product_category', 'ข้อมูลประเภทสินค้า'=>'admin/product_category/edit'));
            /* other code */
            $this->load->helper('table_field');
            $product_category_data = $this->product_category_model->get_product_category('id', $this->uri->segment(4));
            unset($product_category_data['id']);
            unset($product_category_data['flag_del']);
            unset($product_category_data['id']);
            $data['product_category_data'] = $product_category_data;
            $data['parent_category_all_data'] = $this->product_category_model->get_product_category('', '', 'AND product_category_id IS NULL'); // เลือก parent category
            // ประเภทสินค้าระดับบรสุด
            $data['top_category'] = $this->product_category_model->get_product_category_top();
            // กด submit edit
            $this->load->library('form_validation');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'category_code'),
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'name')
            ), '');
            $this->form_validation->set_rules($validation_config);
            if($this->form_validation->run()==true) {
                // check form key
                if(validation_form_key($this->input->post('hid_form_key'))==true) {
                    $this->product_category_model->edit_product_category('id', $this->uri->segment(4), array(
                        'category_code'=>$this->input->post('txt_category_code'),
                        'name'=>$this->input->post('txt_name'),
                        'product_category_id'=>($this->input->post('ddl_product_categoty_id')=='0') ? null : $this->input->post('ddl_product_categoty_id'),
                        'product_category_top_id'=>($this->input->post('ddl_product_categoty_top_id')=='0') ? null : $this->input->post('ddl_product_categoty_top_id')
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
