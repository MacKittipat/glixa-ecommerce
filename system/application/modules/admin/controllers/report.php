<?php
class Report extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function inventory_start_up() {
        $data['page_title'] = 'รายงาน inventory start up';
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            $this->load->model('shop/supplier_model');
            $data['supplier_data'] = $this->supplier_model->get_supplier('','','ORDER BY name ASC');
            /* set page title and view */
            $data['page_content'] = 'admin/content/report_inventory_start_up';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), $data['page_title']=>'admin/report/inventory_start_up'));
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
}
?>
