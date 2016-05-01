<?php
class Product_media extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_model');
        $this->load->model('shop/product_category_model');
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function index() {
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_title'] = 'วิดีโอสินค้า';
            $data['page_content'] = 'admin/content/product_media_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin', $data['page_title']=>'admin/product_media'));
            /* other code */
            $this->load->helper('table_field');
            // EDIT
            if($this->input->post('task')=='edit') {
                $this->product_media_model->edit_product_media('id', $this->input->post('edit_id'), array(
                    $this->input->post('edit_field')=>$this->input->post('edit_value')
                ));
            }
            // DELETE
            if($this->input->post('task')=='delete') {
                foreach ($this->input->post('chk_row') as $value) { // $value = product_id
                    $this->product_media_model->edit_product_media('id', $value, array(
                        'flag_del'=>'1'
                    ));
                }
            }
            // ========== DATATABLE ==========
            // *** action page สำหรับ form submit
            $data['action_page'] = current_url();
            // *** field ที่แสดงใน table
            $data['tabel_field'] = array(
                                    'title'=>array(get_field_lang('shop_product_media', 'title'), '350'),
                                    'product_id'=>array(get_field_lang('shop_product_review', 'product_id'), '200'),
                                    'approve'=>array(get_field_lang('shop_product_media', 'approve'), '100'));
            // *** field ที่ใช้ search
            $data['search_field'] = array(
                                    'title'=>get_field_lang('shop_product_media', 'title'),
                                    'approve'=>get_field_lang('shop_product_media', 'approve'));
            // *** num of uri_to_assoc(num)
            $data['num_uri_to_assoc'] = 4;
            // *** page ที่ใช้ datatable
            $data['datatable_url'] = base_url().'admin/product_media/index/';
            $data['datatable_js'] = $this->load->view('admin/template/datatable_js', $data, true);
            // *** field ที่ต้องการ select
            $field = array(
                'shop_product_media.id',
                'shop_product_media.title',
                'shop_product_media.product_id',
                'shop_product_media.approve');
            // *** ชื่อ table
            $table = ' shop_product_media,shop_product ';
            // *** default WHERE
            $whe = ' WHERE shop_product_media.flag_del=0 AND shop_product_media.product_id=shop_product.id ';
            // *** default ORDER BY
            $order = ' shop_product_media.id ';
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
            $query_data_all = $this->db->query('SELECT shop_product_media.id FROM '.$table.' '.$whe);
            $this->load->library('pagination');
            $config['base_url'] = $url; // base url ของ pagination
            $config['total_rows'] = $query_data_all->num_rows(); // จำนวน row ทั้งหมด
            $config['num_links'] = 6; // จำนวน link ของ pagination
            $config['per_page'] = $limit; // จำนวน row ต่อ page
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // *** load datatable
            $data['datatable'] = $this->load->view('admin/template/product_media_datatable', $data, true);
            // ========== DATATABLE ==========


            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else {
            redirect(base_url());
        }
    }
}
?>
