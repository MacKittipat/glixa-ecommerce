<?php
class Payment_model extends Model {
    public function __construct() {
        parent::Model();
    }
   /*
     * $data = array('fieldname'=>'values');
     */
    public function add_payment($data) {
        $this->db->insert('shop_payment', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_payment($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,money,payment_method,payment_date,detail,user_id,order_id FROM shop_payment WHERE {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,money,payment_method,payment_date,detail,user_id,order_id FROM shop_payment WHERE {$field}=? {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_payment($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_payment', $data);
    }
}
?>
