<?php
class Purchase extends Controller {
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
            $data['page_title'] = 'สินค้า';
            $data['page_content'] = 'admin/content/purchase_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ใบสั่งของ'=>'admin/purchase'));
            /* other code */
            $this->load->helper('table_field');
            
            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'supplier_name'=>array(get_field_lang('shop_purchase', 'supplier_name'), '300'),
                                    'status'=>array(get_field_lang('shop_purchase', 'status'), '200'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'supplier_name'=>get_field_lang('shop_purchase', 'supplier_name'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/purchase/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','supplier_name','status','create_date','purchase_date');
            // *** ชื่อ table
            $table = ' shop_purchase ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 ';
            // *** default ORDER BY
            $order = ' create_date ';
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
            $data['datatable'] = $this->load->view('admin/template/purchase_datatable', $data, true); // *** datatable template
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
            $data['page_title'] = 'เพิ่มใบสั่งของ';
            $data['page_content'] = 'admin/content/purchase_add';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ใบสั่งของ'=>'admin/purchase', 'เพิ่มใบสั่งของ'=>'admin/purchase/add'));
            /* other code */
            $this->load->model('admin/purchase_model');
            $this->load->helper('table_field');
            $data['all_supplier_data'] = $this->supplier_model->get_supplier('','','');
            // submit เลือก supplier แล้ว
            if($this->input->post("ddl_supplier_first")) {
                $this->load->model('shop/product_model');
                $data['supplier_data'] = $this->supplier_model->get_supplier('id',$this->input->post("ddl_supplier_first"));
                $data['product_data'] = $this->product_model->get_product('','','AND owner_id="'.$data['supplier_data']['id'].'" AND owner_type="b2c"');
            }
            // submit add purchase
            if($this->input->post('btn_submit')) {
                $this->load->model('admin/purchase_item_model');
                $this->load->model('admin/product_lot_model');
                $supplier = $this->supplier_model->get_supplier('id',$this->input->post('hid_supplier_id'));
                $user_data = get_login_info();
                $user_data = $this->user_model->get_user('email', $user_data['email']);
                // add in purchase table
                $this->purchase_model->add_purchase(array(
                    'status'=>'no_receive',
                    'create_date'=>date('Y-m-d H:i:s'),
                    'supplier_id'=>$this->input->post('hid_supplier_id'),
                    'supplier_name'=>$supplier['name'],
                    'supplier_contact_firstname'=>$supplier['contact_firstname'],
                    'supplier_contact_lastname'=>$supplier['contact_lastname'],
                    'supplier_address'=>$supplier['address'],
                    'supplier_tambon'=>$supplier['tambon'],
                    'supplier_amphoe'=>$supplier['amphoe'],
                    'supplier_province'=>$supplier['province'],
                    'supplier_postalcode'=>$supplier['postalcode'],
                    'supplier_phone_number1'=>$supplier['phone_number1'],
                    'supplier_phone_number2'=>$supplier['phone_number2'],
                    'supplier_fax_number1'=>$supplier['fax_number1'],
                    'supplier_fax_number2'=>$supplier['fax_number2'],
                    'supplier_email'=>$supplier['email'],
                    'supplier_website'=>$supplier['website'],
                    'supplier_detail'=>$supplier['detail'],
                    'user_id'=>$user_data['id']
                ));
                // get last id of purchase
                $purchase_data = $this->purchase_model->get_purchase('supplier_id',$this->input->post('hid_supplier_id'), 'ORDER BY id DESC');
                // add in purchase item table & product lot
                $i = 0;
                $price = $this->input->post('txt_price');
                $qty = $this->input->post('txt_quantity');
                foreach($this->input->post('ddl_product') as $product) {
                    $this->purchase_item_model->add_purchase_item(array(
                        'product_id'=>$product,
                        'quantity'=>$qty[$i],
                        'price'=>$price[$i],
                        'purchase_id'=>$purchase_data['id']
                    ));
                    $this->product_lot_model->add_product_lot(array(
                        'product_id'=>$product,
                        'quantity'=>'0', // เริ่มต้นเป็น 0 เพราะยังไม่ได้รับสินค้า
                        'price'=>$price[$i],
                        'purchase_id'=>$purchase_data['id']
                    ));
                    $i++;
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
            $data['page_title'] = 'แก้ไขใบสั่งของ';
            $data['page_content'] = 'admin/content/purchase_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'ใบสั่งของ'=>'admin/purchase','แก้ไขใบสั่งของ'=>current_url()));
            $this->load->model('admin/purchase_model');
            $this->load->model('admin/purchase_item_model');
            $this->load->model('shop/product_model');
            $this->load->model('admin/product_lot_model');
            $this->load->helper('table_field');
            $data['purchase_data'] = $this->purchase_model->get_purchase('id', $this->uri->segment(4));
            $data['purchase_item_data'] = $this->purchase_item_model->get_purchase_item('','','AND purchase_id="'.$data['purchase_data']['id'].'"');
            
            if($this->input->post('hid_action')=='submit') {
                // edit po item
                $qty = $this->input->post('txt_quantity');
                $price = $this->input->post('txt_price');
                $deliver_date = $this->input->post('txt_deliver_date');
                $payment_price = $this->input->post('txt_payment_price');
                $payment_date = $this->input->post('txt_payment_date');
                $i = 0;
                foreach($this->input->post('hid_product') as $product_id) { // บันทึกวันที่จ่ายเงินกับเงินที่จ่ายด้วย
                    $this->purchase_item_model->edit_purchase_item(array('purchase_id'=>$this->uri->segment(4),'product_id'=>$product_id),array(
                        'quantity'=>$qty[$i],
                        'price'=>$price[$i],
                        'deliver_date'=>($deliver_date[$i]!='') ? $deliver_date[$i] : NULL,
                        'payment_price'=>($payment_price[$i]!='') ? $payment_price[$i] : NULL,
                        'payment_date'=>($payment_date[$i]!='') ? $payment_date[$i] : NULL
                    ));
                    $this->product_lot_model->edit_product_lot(array('purchase_id'=>$this->uri->segment(4),'product_id'=>$product_id),array(
                        'price'=>$price[$i]
                    ));
                    // เพิ่ม stock ใน product lot เมื่อกรอก deliver date
                    if($deliver_date[$i]!='' && $data['purchase_item_data'][$i]['deliver_date']!=$deliver_date[$i]) {
                        $currenty_lot = $this->product_lot_model->get_product_lot('','',' AND purchase_id="'.$this->uri->segment(4).'" AND product_id="'.$product_id.'"');
                        $this->product_lot_model->edit_product_lot(array('purchase_id'=>$this->uri->segment(4),'product_id'=>$product_id),array(
                            'quantity'=>(int)$qty[$i]+(int)$currenty_lot[0]['quantity']
                        ));
                    }
                    $i++;
                }
                // edit po status
                // นับจำนวนสินค้าใน po นี้
                $status = 'no_receive';
                $all_po_item = $this->purchase_item_model->get_purchase_item('','','AND purchase_id="'.$this->uri->segment(4).'"');
                $count_all_po_item = count($all_po_item);
                $po = $this->purchase_item_model->get_purchase_item('','','AND purchase_id="'.$this->uri->segment(4).'" AND deliver_date IS NOT NULL');
                if(count($all_po_item) == count($po)) { // deliver all item already
                    $status = 'all_receive';
                } else if(count($po)=='0') {
                    $status = 'no_receive';
                } else {
                    $status = 'partial_receive';
                }
                $this->purchase_model->edit_purchase(array('id'=>$this->uri->segment(4)), array(
                    'status'=>$status
                ));
                

                // update stock of product
                redirect(current_url());
            }
            // click cancel or close
            if($this->input->post('hid_action')=='cancel') {
                $qty = $this->input->post('txt_quantity');
                $price = $this->input->post('txt_price');
                $deliver_date = $this->input->post('txt_deliver_date');
                // นับจำนวนสินค้าใน po นี้
                $status = 'no_receive';
                $all_po_item = $this->purchase_item_model->get_purchase_item('','','AND purchase_id="'.$this->uri->segment(4).'"');
                $count_all_po_item = count($all_po_item);
                $po = $this->purchase_item_model->get_purchase_item('','','AND purchase_id="'.$this->uri->segment(4).'" AND deliver_date IS NOT NULL');
                if(count($po) > 0) { // ได้รับสินค้ามาบ้างแล้วหรือรับมาหมดแล้วยกเลิกจะลด stock
                    // ลด stock คืนตามเดิม
                    $i=0;
                    foreach($this->input->post('hid_product') as $product_id) {
                        if($deliver_date[$i]!='') {
                            $currenty_lot = $this->product_lot_model->get_product_lot('','',' AND purchase_id="'.$this->uri->segment(4).'" AND product_id="'.$product_id.'"');
                            $this->product_lot_model->edit_product_lot(array('purchase_id'=>$this->uri->segment(4),'product_id'=>$product_id),array(
                                'quantity'=>(int)$currenty_lot[0]['quantity']-(int)$qty[$i],
                            ));
                        }
                        $i++;
                    }
                }
                // set status cancel
                $this->purchase_model->edit_purchase(array('id'=>$this->uri->segment(4)), array(
                    'status'=>'cancel'
                ));
                redirect(current_url());
            }
            if($this->input->post('hid_action')=='close') {
                $this->purchase_model->edit_purchase(array('id'=>$this->uri->segment(4)), array(
                    'status'=>'close'
                ));
                redirect(current_url());
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        }
    }
}
?>
