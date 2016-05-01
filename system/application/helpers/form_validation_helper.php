<?php
    /*
     * get_validation_config
     * เอาค่า config ที่ return คือ $config array ไป set ใน $this->form_validation->set_rules();
     * $table_field = array(array('prefix'=>'txt', 'table'=>'wive_user', 'field'=>'email'), ...)
     * $page = name of page เช่น register, edit_password
     */
    function get_validation_config($table_field, $page) {
        $CI =& get_instance();
        $CI->config->load('form_validation');
        foreach ($table_field as $value) { // $value = array('prefix', 'table', 'field')
            $table_config = $CI->config->item($value['table']); //
            if($page=='') {
                $config[] = array(
                    'field'=>$value['prefix'].'_'.$value['field'], // เช่น txt_email_register
                    'label'=>get_field_lang($value['table'], $value['field'], 'validate'),
                    'rules'=>$table_config[$value['field']]);
            } else {
                $config[] = array(
                    'field'=>$value['prefix'].'_'.$value['field'].'_'.$page, // เช่น txt_email_register
                    'label'=>get_field_lang($value['table'], $value['field'], 'validate'),
                    'rules'=>$table_config[$value['field']]);
            }
        }
        return $config;
    }
?>
