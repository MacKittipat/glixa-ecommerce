<?php
class Product_gallery_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * add_product
     * $data = array('fieldname'=>'values');
     */
    public function add_product_gallery($data) {
        $this->db->insert('shop_product_gallery', $data);
    }
    /*
     * get product gallery
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_gallery($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product() : select all row
                $query = $this->db->query("SELECT id,image,product_id FROM shop_product_gallery WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product('id','1') : select one row
                $query = $this->db->query("SELECT id,image,product_id  FROM shop_product_gallery WHERE {$field}=? AND flag_del=0 {$option}", array($value));
                return $query->result_array();
        }
    }
    /*
     * delete gallery
     * $field = ชื่อ field 
     * $value = ค่าของ field
     */
    public function del_product_gallery($field, $value) {
        $this->db->where($field, $value);
        $this->db->delete('shop_product_gallery');
    }
}
?>
