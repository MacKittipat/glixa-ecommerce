<?php
    /*
     * is_user_login
     * เช็คว่า user login อยู่หรือไม่ ถ้า login อยู่ return true
     */
    function is_user_login() {
        if(isset($_SESSION['wive_login']) || isset($_COOKIE['wive_login'])) {
            return true;
        }
        return false;
    }
    /*
     * is_admin
     * เช็คว่า user ที่ login เป็น admin หรือไม่ถ้าเป็น return true
     */
    function is_admin() {
        $login_info = get_login_info();
        if($login_info['level']=='admin') {
            return true;
        }
        return false;
    }
    /*
     * is_super_admin
     * เช็คว่า user ที่ login เป็น super_admin หรือไม่ถ้าเป็น return true
     */
    function is_super_admin() {
        $login_info = get_login_info();
        if($login_info['level']=='super_admin') {
            return true;
        }
        return false;
    }
    /*
     * get_login_info
     * อ่านค่า login จาก session / cookie
     */
    function get_login_info() {
        if(isset($_SESSION['wive_login'])) {
            return unserialize($_SESSION['wive_login']);
        } elseif(isset($_COOKIE['wive_login'])) {
            return unserialize($_COOKIE['wive_login']);
        }
        return false;
    }

    /*
     * ทำการ login
     */
    function do_login($login_info, $remember) {
        if($remember==true) {
            // cookie 1 month
            setcookie('wive_login', serialize($login_info), time()+2592000, '/');
        } else {
            $_SESSION['wive_login'] = serialize($login_info);
        }
        $CI =& get_instance();
        $CI->load->library('cart');
        // ลบ cart
        foreach($CI->cart->contents() as $item) {
            $CI->cart->update(array(
                'rowid'=>$item['rowid'],
                'qty'=>0
            ));
        }
        // redirect
        redirect();
    }
?>
