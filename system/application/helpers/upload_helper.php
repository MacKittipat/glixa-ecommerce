<?php
    /*
     * $field_name = ชื่อของ input file
     * $config = เหมือน CI ปกติ
     */
    function do_upload($field_name, $config) {
        $CI =& get_instance();
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        $_FILES["userfiles"] = $_FILES[$field_name];
        if($CI->upload->do_upload('userfiles')) {
        } else {
            return $CI->upload->display_errors('<div>', '</div>');
        }
    }
    
    function do_upload_array($field_name, $config, $index) {
        $CI =& get_instance();
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        $_FILES["userfiles"]["name"]        = $_FILES[$field_name]["name"][$index];
        $_FILES["userfiles"]["type"]        = $_FILES[$field_name]["type"][$index];
        $_FILES["userfiles"]["tmp_name"]    = $_FILES[$field_name]["tmp_name"][$index];
        $_FILES["userfiles"]["error"]       = $_FILES[$field_name]["error"][$index];
        $_FILES["userfiles"]["size"]        = $_FILES[$field_name]["size"][$index];
        if($CI->upload->do_upload('userfiles')) {
        } else {
            return $CI->upload->display_errors('<div>', '</div>');
        }
    }
?>
