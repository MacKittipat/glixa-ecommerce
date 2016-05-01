<?php
    /*
     * get_field_lang
     * load language from thai/table_field_lang.php
     * $table = table name
     * $field = field in table
     * $type = validate
     */
     function get_field_lang($table, $field, $type='') {
//         $CI =& get_instance();
//         $CI->lang->load('table_field');
//         $tables = $CI->lang->line($table);
//         return $tables[$field];
         $CI =& get_instance();
         $CI->lang->load('table_field');
         $tha = $CI->lang->line($table);
         $eng = $CI->lang->line($table.'_en');
         if($type=='validate') {
             if($eng[$field]=='') {
                return $tha[$field];
             } else {
                 return $eng[$field].' / '.$tha[$field];
             }
         } else {
             if($eng[$field]=='') {
                 return $tha[$field];
             } else {
                 return $eng[$field].'<br />'.$tha[$field];
             }
             
         }
         
     }


?>
