<?php
    /*
     * create_form_key
     * สร้าง key ให้ form เพื่อความปลอดภัยในการ submit
     */
    function create_form_key() {
        $form_key = md5(uniqid(rand(), true));
        $_SESSION['form_key'] = $form_key;
        return '<input name="hid_form_key" type="hidden" value="'.$form_key.'" />';
    }

    /*
     * validation_form_key
     * เช็ค form key ว่ามีหรือไม่ ถ้ามี return true
     * $post_form_key = ค้าที่ได้จาก form (input hidden)
     */
    function validation_form_key($post_form_key) {
        if($post_form_key == $_SESSION['form_key']) {
            unset($_SESSION['form_key']);
            return true;
        }
        unset($_SESSION['form_key']);
        return false;
    }
?>
