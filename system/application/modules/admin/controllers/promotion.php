<?php
class Promotion extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/payment_model');
        $this->load->model('shop/order_model');
        $this->load->model('user/user_model');
        $this->load->model('shop/product_model');
        $this->load->model('shop/product_media_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
    }
    function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            $data['page_title'] = 'โปรโมชั่น';
            $data['page_content'] = 'admin/content/promotion_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'โปรโมชั่น'=>'admin/promotion'));
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
                $data['datatable_url'] = base_url().'admin/promotion/index/';
                $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
                // *** field ที่ต้องการ select
                $field = array('id','name','cost','price','quantity','unit','available');
                // *** ชื่อ table
                $table = ' shop_product ';
                // *** default WHERE
                $whe = ' WHERE flag_del=0 AND type2="promotion"';
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
                $data['datatable'] = $this->load->view('admin/template/promotion_datatable', $data, true); // *** datatable template
                // ========== DATATABLE ==========
                /* load view */
                $this->load->view('admin/admin_view', $data);
        } else {
            redirect();
        }
        
    }
    function add() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            $data['page_title'] = 'เพิ่มโปรโมชั่น';
            $data['page_content'] = 'admin/content/promotion_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'โปรโมชั่น'=>'admin/promotion', 'เพิ่มโปรโมชั่น'=>'admin/promotion/add'));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule

            $this->form_validation->set_rules('txt_name', get_field_lang('shop_promotion', 'name'), 'required');
            $this->form_validation->set_rules('txt_real_price', get_field_lang('shop_promotion', 'real_price'), 'required|numeric');
            $this->form_validation->set_rules('txt_pro_price', get_field_lang('shop_promotion', 'pro_price'), 'required|numeric');
            $this->form_validation->set_rules('txt_end_date', get_field_lang('shop_promotion', 'end_date'), 'required');
            $this->form_validation->set_rules('txt_product', 'สินค้า', 'required');
            if($this->form_validation->run()==true) {
                $this->product_model->add_product(array(
                    'name'=>$this->input->post('txt_name'),
                    'detail'=>$this->input->post('txt_description'),
                    'cost'=>$this->input->post('txt_real_price'), // เก็บราคาจริง
                    'price'=>$this->input->post('txt_pro_price'), // เก็บราคาขาย (ราคา promotion
                    'type2'=>'promotion',
                    'add_date'=>date("Y-m-d:H:i:s"),
                    'end_date'=>$this->input->post('txt_end_date'),
                    'owner_type'=>'b2c'
                ));
                $query = $this->db->query("SELECT id FROM shop_product WHERE type2='promotion' ORDER BY id DESC LIMIT 1");
                $result = $query->row_array();
                $csv_products = $this->input->post('txt_product');
                $products = explode(",", $csv_products);
                foreach ($products as $value) {
                    $this->db->insert("shop_promotion_item",array('promotion_id'=>$result['id'],'product_id'=>$value));
                }
            }



            $this->load->view('admin/admin_view', $data);
        }
    }
    function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'ข้อมูลโปรโมชั่น';
            $data['page_content'] = 'admin/content/promotion_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'โปรโมชั่น'=>'admin/promotion', 'ข้อมูลโปรโมชั่น'=>'admin/promotion/edit/'.$this->uri->segment(4)));
            /* other code */
            $this->load->library('form_validation');
            $this->load->helper('table_field');
            $this->load->helper('form_validation'); // ใช้ช่วยโหลดค่า config validation rule
            $data['promotion_data'] = $this->product_model->get_product('id', $this->uri->segment(4));
            $query = $this->db->query("SELECT product_id FROM shop_promotion_item WHERE promotion_id=?",array($this->uri->segment(4)));
            $tmp = "";
            foreach ($query->result_array() as $row) {
                $tmp .= $row['product_id'].',';
            }
            $tmp = rtrim($tmp, ",");
            $data['csv_product'] = $tmp;
            $this->form_validation->set_rules('txt_name', get_field_lang('shop_promotion', 'name'), 'required');
            $this->form_validation->set_rules('txt_real_price', get_field_lang('shop_promotion', 'real_price'), 'required|numeric');
            $this->form_validation->set_rules('txt_pro_price', get_field_lang('shop_promotion', 'pro_price'), 'required|numeric');
            $this->form_validation->set_rules('txt_end_date', get_field_lang('shop_promotion', 'end_date'), 'required');
            $this->form_validation->set_rules('txt_product', 'สินค้า', 'required');
            if($this->form_validation->run()==true) {
                $this->product_model->edit_product('id',$this->uri->segment(4),array(
                    'name'=>$this->input->post('txt_name'),
                    'detail'=>$this->input->post('txt_description'),
                    'cost'=>$this->input->post('txt_real_price'), // เก็บราคาจริง
                    'price'=>$this->input->post('txt_pro_price'), // เก็บราคาขาย (ราคา promotion
                    'end_date'=>$this->input->post('txt_end_date'),
                ));
                $this->db->where('promotion_id', $this->uri->segment(4));
                $this->db->delete('shop_promotion_item');
                
                $csv_products = $this->input->post('txt_product');
                $products = explode(",", $csv_products);
                foreach ($products as $value) {
                    $this->db->insert("shop_promotion_item",array('promotion_id'=>$this->uri->segment(4),'product_id'=>$value));
                }
                redirect(current_url());
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else {
            redirect(base_url());
        }
    }

}
?>
