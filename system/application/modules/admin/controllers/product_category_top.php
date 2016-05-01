<?php
class Product_category_top extends Controller {
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
            $data['page_title'] = 'ประเภทสินค้าระดับบนสุด';
            $data['page_content'] = 'admin/content/product_category_top_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้าระดับบนสุด'=>'admin/product_category_top'));
            /* other code */
            $this->load->helper('table_field');
            // Delete
            if($this->input->post('task')=='delete') {
                
            }
            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'category_code'=>array(get_field_lang('shop_product_category', 'category_code'), '150'),
                                    'name'=>array(get_field_lang('shop_product_category', 'name'), '200'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'category_code'=>get_field_lang('shop_product_category', 'category_code'),
                                    'name'=>get_field_lang('shop_product_category', 'name'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/product_category_top/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','category_code','name');
            // *** ชื่อ table
            $table = ' shop_product_category_top ';
            // *** default WHERE
            $whe = ' ';
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
            $data['datatable'] = $this->load->view('admin/template/product_category_top_datatable', $data, true);
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
            $data['page_content'] = 'admin/content/product_category_top_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้าระดับบนสุด'=>'admin/product_category_top', 'เพิ่มประเภทสินค้าระดับบนสุด'=>'admin/product_category_top/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'category_code'),
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'name')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $this->form_validation->set_rules('txt_category_code', get_field_lang('shop_product_category', 'category_code'), 'trim|required');

            if($this->form_validation->run()==true) {
                $this->product_category_model->add_product_category_top(array(
                    'category_code'=>$this->input->post('txt_category_code'),
                    'name'=>$this->input->post('txt_name')
                ));
                redirect(current_url());
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else {
            redirect(base_url());
        }
    }

    public function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลประเภทสินค้าระดับบนสุด';
            $data['page_content'] = 'admin/content/product_category_top_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ประเภทสินค้าระดับบนสุด'=>'admin/product_category_top', 'ข้อมูลประเภทสินค้าระดับบนสุด'=>'admin/product_category/edit'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $data['product_cat_top'] = $this->product_category_model->get_product_category_top('id', $this->uri->segment(4));
            $validation_config = get_validation_config(array(
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'category_code'),
                array('prefix'=>'txt', 'table'=>'shop_product_category', 'field'=>'name')
            ), '');
            $this->form_validation->set_rules($validation_config);
            $this->form_validation->set_rules('txt_category_code', get_field_lang('shop_product_category', 'category_code'), 'trim|required');
            if($this->form_validation->run()==true) {
                $this->product_category_model->edit_product_category_top('id',$this->uri->segment(4),array(
                    'category_code'=>$this->input->post('txt_category_code'),
                    'name'=>$this->input->post('txt_name')
                ));
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
