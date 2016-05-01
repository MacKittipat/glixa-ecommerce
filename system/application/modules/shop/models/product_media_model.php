<?php
class Product_media_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * add_product_media
     * $data = array('fieldname'=>'values');
     */
    public function add_product_media($data) {
        $this->db->insert('shop_product_media', $data);
    }
    /*
     * get_product_media
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_media($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_media() : select all row
                $query = $this->db->query("SELECT id,title,link,detail,approve,add_date,flag_del,user_id,user_name,product_id FROM shop_product_media WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_media('id','1') : select one row
                $query = $this->db->query("SELECT id,title,link,detail,approve,add_date,flag_del,user_id,user_name,product_id FROM shop_product_media WHERE {$field}=? AND flag_del=0 {$option}", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit_product_media
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_product_media($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_media', $data);
    }
}
?>
