<?php
class Product_qa_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * add_product_review
     * $data = array('fieldname'=>'values');
     */
    public function add_product_qa($data) {
        $this->db->insert('shop_product_qa', $data);
    }
    /*
     * get_product_qa
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_qa($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_qa() : select all row
                $query = $this->db->query("SELECT id,question,answer,score,approve,add_date,flag_del,user_id,user_name,product_id FROM shop_product_qa WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_qa('id','1') : select one row
                $query = $this->db->query("SELECT id,question,answer,score,approve,add_date,flag_del,user_id,user_name,product_id FROM shop_product_qa WHERE {$field}=? AND flag_del=0 {$option}", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit_product_qa
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_product_qa($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_qa', $data);
    }
}
?>
