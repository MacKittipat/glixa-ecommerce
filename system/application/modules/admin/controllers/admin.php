<?php
class Admin extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('shop/product_review_model');
        $this->load->model('shop/product_qa_model');
        $this->load->model('shop/product_media_model');
    }
    public function index() {
        $data['page_title'] = 'ผู้ดูแลระบบ';
        if((is_user_login()==true) && (is_admin ()==true || is_super_admin()==true)) { // login และเป็น admin หรือ super_admin
            /* set page title and view */
            $data['page_content'] = 'admin/content/admin_index';
            $data['page_breadcrumb'] = simple_breadcrumb(array('หน้าหลัก'=>base_url(), 'ผู้ดูแลระบบ'=>'admin'));
            /* load view */
            $this->load->view('admin/admin_view', $data);
        } else { // not login
            redirect(base_url());
        }
    }
}
?>
