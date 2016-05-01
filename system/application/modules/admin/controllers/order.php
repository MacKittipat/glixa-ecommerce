<?php
class Order extends Controller {
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
    }
    function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'รายการสั่งซื้อ';
            $data['page_content'] = 'admin/content/order_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', $data['page_title']=>'admin/order'));
            /* other code */
            $this->load->helper('table_field');

            // DELETE
            if($this->input->post('task')=='delete') {
                print_r($this->input->post('chk_row'));
//                foreach ($this->input->post('chk_row') as $value) { // $value = product_id
//                    $this->product_model->edit_product('id', $value, array(
//                        'flag_del'=>'1'
//                    ));
//                }
            }

            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'order_date'=>array(get_field_lang('shop_order', 'order_date'), '100'),
                                    'status'=>array(get_field_lang('shop_order', 'status'), '100'),
                                    'shipping_method'=>array(get_field_lang('shop_order', 'shipping_method'), '100'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'shipping_method'=>get_field_lang('shop_order', 'shipping_method'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/order/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array('id','order_date','payment_date','status','shipping_method');
            // *** ชื่อ table
            $table = ' shop_order ';
            // *** default WHERE
            $whe = ' WHERE flag_del=0 ';
            // *** default ORDER BY
            $order = ' order_date ';
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
            $data['datatable'] = $this->load->view('admin/template/order_datatable', $data, true); // *** datatable template
            // ========== DATATABLE ==========
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else {
            redirect();
        }
    }

    function edit() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            $data['page_title'] = 'ข้อมูลรายการสั่งซื้อ';
            $data['page_content'] = 'admin/content/order_edit';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', 'รายการสั่งซื้อ'=>'admin/order', $data['page_title']=>'admin/order/edit/'.$this->uri->segment(4)));
            /* other code */
            $this->load->helper('table_field');
            $this->load->model('shop/order_model');
            $this->load->model('shop/order_item_model');
            $this->load->model('shop/order_item_lot_model');
            $this->load->model('user/user_address_model');
            $this->load->model('admin/product_lot_model');

            $data['order_data'] = $this->order_model->get_order('id', $this->uri->segment(4));
            $data['order_item_data'] = $this->order_item_model->get_order_item('', '', ' AND order_id='.$this->uri->segment(4));
            $data['billing_data'] = $this->user_address_model->get_user_address('id', $data['order_data']['billing_address_id']);
            $data['shipping_data'] = $this->user_address_model->get_user_address('id', $data['order_data']['shipping_address_id']);

            // Edit payment date
            if($this->input->post('hid_field')=='payment_date') {
                $this->order_model->edit_order('id', $this->uri->segment(4), array(
                    'payment_date'=>$this->input->post('txt_payment_date')
                ));
            } else if($this->input->post('hid_field')=='status') { // Edit status
               // echo $this->input->post('ddl_status');
                $this->order_model->edit_order('id', $this->uri->segment(4), array(
                    'status'=>$this->input->post('ddl_status')
                ));
                // ส่ง mail ไปบอก suppplier และตัด stock
                if($this->input->post('ddl_status')=='paid') {
                    // send mail to supplier
                    // หา supplier จาก order_id นี้ก่อน
                    $query = $this->db->query("SELECT DISTINCT shop_supplier.id,shop_supplier.name,shop_supplier.email
                            FROM shop_supplier,shop_product,shop_order_item
                            WHERE shop_order_item.order_id=? AND
                            shop_product.id= shop_order_item.product_id AND
                            shop_product.owner_type='b2c' AND
                            shop_product.owner_id=shop_supplier.id", array($this->uri->segment(4)));
                    $supplier = $query->result_array();
                    foreach($supplier as $s) {
                        $query = $this->db->query("SELECT DISTINCT shop_product.id,shop_product.name,shop_order_item.quantity
                            FROM shop_supplier,shop_product,shop_order_item
                            WHERE shop_order_item.order_id=? AND
                            shop_product.id= shop_order_item.product_id AND
                            shop_product.owner_type='b2c' AND
                            shop_product.owner_id=?",array($this->uri->segment(4),$s['id']));
                        $product = $query->result_array();
                        // Send mail ส่ง mail ไปบอก suppplier ว่าสินค้าถูกขาย
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

                        $mail->SetFrom($this->config->item('admin_send_payment_mail'), $this->config->item('admin_send_payment_from'));
                        $mail->AddAddress($s['email']);
                        $mail->Subject = $this->config->item('admin_send_payment_subject');
                        $data['supplier'] = $s;
                        $data['product'] = $product;
                        $mail->MsgHTML($this->load->view('mail_template/admin_send_payment',$data,true));
                        $mail->Send();
                    }
                    // ตัด stock
//                    foreach($data['order_item_data'] as $order_item) {
//                        $product_data = $this->product_model->get_product('id', $order_item['product_id']);
//                        // สินค้าของ supplier
//                        if($product_data['owner_type']=='b2c') {
//                            $supplier_data = $this->supplier_model->get_supplier('id',$product_data['owner_id']);
//                            // ตัด stock
//                            $new_quantity = (int)$product_data['quantity']-(int)$order_item['quantity'];
//                            $this->product_model->edit_product('id', $product_data['id'], array(
//                                'quantity'=>$new_quantity
//                            ));
//                        }
//                    }
                }
                redirect(current_url());
            } else if($this->input->post('hid_field')=='lot') { // เลือก lot
                $lot = $this->input->post('ddl_lot');
                $code = $this->input->post('txt_code');
                $remark = $this->input->post('txt_remark');
                $order_item_id = $this->input->post('hid_order_item_id');
                $i=0;
                $count = 0;
                foreach($lot as $l) {
                    if($l!='false' && $code[$i]!='') {
                        $this->order_item_model->edit_order_item('id', $order_item_id[$i], array(
                            'lot_id'=>$l,
                            'tracking_code'=>$code[$i],
                            'remark'=>$remark[$i]
                        ));
                        $i++;
                        $count++;
                    }
                }
                // set status of order partial delivery / (all) )delivery
                if($count == count($data['order_item_data'])) { // เลือก lot ทุกสินค้า
                    // change status
                    $this->order_model->edit_order('id',$this->uri->segment(4),array(
                        'status'=>'send'
                    ));
                } else {
                    $this->order_model->edit_order('id',$this->uri->segment(4),array(
                        'status'=>'partial_send'
                    ));
                }
                redirect(current_url());
            }
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else {
            redirect();
        }
    }
}
?>
