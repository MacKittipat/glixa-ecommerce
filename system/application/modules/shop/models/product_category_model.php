<?php
class Product_category_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_product_category($data) {
        $this->db->insert('shop_product_category', $data);
    }
    public function add_product_category_top($data) {
        $this->db->insert('shop_product_category_top', $data);
    }
    /*
     * get_product_category
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_category($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_category() : select all row
                $query = $this->db->query("SELECT id,category_code,name,flag_del,product_category_id,product_category_top_id FROM shop_product_category WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_category('id','1') : select one row
                $query = $this->db->query("SELECT id,category_code,name,flag_del,product_category_id,product_category_top_id FROM shop_product_category WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    public function get_product_category_top($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_category() : select all row
                $query = $this->db->query("SELECT id,category_code,name,flag_del FROM shop_product_category_top WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_category('id','1') : select one row
                $query = $this->db->query("SELECT id,category_code,name,flag_del FROM shop_product_category_top WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit product category
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $data = array('fieldname'=>'values');
     */
    public function edit_product_category($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_category', $data);
    }
    public function edit_product_category_top($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_category_top', $data);
    }
}
?>
