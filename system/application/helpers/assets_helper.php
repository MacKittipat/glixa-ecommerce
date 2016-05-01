<?php
    /*
     * $file_path = path ไปยังไฟล์นั่นรวมชื่อไฟล์ด้วย เช่น some_dir/jquery.js
     */

    /* Return path to Assets */
    function assets($file_path) {
        return base_url().'assets/'.$file_path;
    }
    /* Return path to CSS */
    function assets_css($file_path) {
        return base_url().'assets/css/'.$file_path;
    }
    /* Return path to Image */
    function assets_image($file_path) {
        return base_url().'assets/image/'.$file_path;
    }
    /* Return path to JS */
    function assets_js($file_path) {
        return base_url().'assets/js/'.$file_path;
    }
    /* Return path to Template */
    function assets_template($file_path) {
        return base_url().'assets/template/'.$file_path;
    }
    /* Return path to Product Image / Gallery */
    function assets_product($file_path, $owner_type='') {
        if($owner_type=='b2c') {
            return assets_kcfinder($file_path);
        } else if($owner_type=='c2c') {
            return base_url().$file_path;
        } else { // default image
            return base_url().'assets/image/'.$file_path;
        }
    }
    function assets_shop($file_path) {
        return base_url().$file_path;
    }
    /* Return path to kcfinderfile */
    function assets_kcfinder($file_path) {
        if(base_url() == 'http://localhost/Wive/') { 
            return 'http://localhost'.$file_path;
        } else { // base path is root of server
            $base_url = substr_replace(base_url(), '', -1);
            return $base_url.$file_path;
        }
    }
?>
