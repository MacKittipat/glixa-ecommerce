<?php
class Product_review_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * get product review
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_review($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_review() : select all row
                $query = $this->db->query("SELECT id,title,detail,overall_rating,money_rating,expectation_rating,approve,add_date,user_id,user_name,product_id FROM shop_product_review WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_review('id','1') : select one row
                $query = $this->db->query("SELECT id,title,detail,overall_rating,money_rating,expectation_rating,approve,add_date,user_id,user_name,product_id  FROM shop_product_review WHERE {$field}=? AND flag_del=0 {$option}", array($value));
                return $query->row_array();
        }
    }
    /*
     * add_product
     * $data = array('fieldname'=>'values');
     */
    public function add_product_review($data) {
        $this->db->insert('shop_product_review', $data);
    }
    /*
     * edit_product_review
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_product_review($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_review', $data);
    }
}
?>
