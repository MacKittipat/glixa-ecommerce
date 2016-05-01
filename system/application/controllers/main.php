<?php
class Main extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->model('user/user_model');
        $this->load->model('shop/product_category_model');
    }
    public function index() {
        /* set page title and view */
        $data['page_title'] = 'Glixa';
        $data['page_content'] = 'content/home';
        $data['page_breadcrumb'] = '';
        /* other code */
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function contact() {
        /* set page title and view */
        $data['page_title'] = 'ติดต่อเรา';
        $data['page_content'] = 'content/contact';
        $data['page_breadcrumb'] = '';
        /* other code */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt_name', 'ชื่อ - นามสกุล', 'required');
        $this->form_validation->set_rules('txt_mail', 'อีเมล', 'required|valid_email');
        $this->form_validation->set_rules('txt_subject', 'หัวข้อ', 'required');
        $this->form_validation->set_rules('txt_detail', 'รายละเอียด', 'required');
        $this->form_validation->set_rules('txt_tel_num', 'หมายเลขโทรศัพท์', 'numeric');
        if ($this->form_validation->run() == true) {
            // send mail
            $this->config->load('email');
            $this->load->helper('mailer');
            $config['smtp_host'] = $this->config->item('smtp_host');
            $config['smtp_port'] = $this->config->item('smtp_port');
            $config['smtp_user'] = $this->config->item('smtp_user');
            $config['smtp_pass'] = $this->config->item('smtp_pass');
            $config['mail'] = $this->input->post('txt_mail');
            $config['from'] = $this->input->post('txt_mail');
            $config['subject'] = $this->input->post('txt_subject');
            $data['name'] = $this->input->post('txt_name');
            $data['tel_num'] = ($this->input->post('txt_tel_num')=='') ? '-' : $this->input->post('txt_tel_num');
            $data['detail'] = $this->input->post('txt_detail');
            send_mail('support@glixa.com',$this->load->view('mail_template/contact_mail',$data,true),$config);
            $data['page_content'] = 'content/contact_complete';
        }
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function term_of_service() {
        /* set page title and view */
        $data['page_title'] = 'Term Of Service';
        $data['page_content'] = 'content/term_of_service';
        $data['page_breadcrumb'] = '';
        /* other code */
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function payment_detail() {
        /* set page title and view */
        $data['page_title'] = 'วิธีการชำระเงิน';
        $data['page_content'] = 'content/payment_detail';
        $data['page_breadcrumb'] = '';
        /* other code */
        /* load view */
        $this->load->view('main_view', $data);
    }
    public function get_analytic() {
        //$this->load->library('gapi',array('email'=>'','password'=>'','token'=>null));
        include APPPATH.'/libraries/Gapi.php';
        $ga = new gapi(array('email'=>'marketing@glixa.com','password'=>'marketing','token'=>null));
        $ga->requestReportData(38474440,array('browser','browserVersion'),array('pageviews','visits'));
        echo 'Total visits: ' . $ga->getVisits();
    }
}
?>
