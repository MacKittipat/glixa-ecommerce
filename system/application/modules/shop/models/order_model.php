<?php
class Order_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_order($data) {
        $this->db->insert('shop_order', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_order($field='', $value='', $option='') {
        switch ($field) {
            case '' : 
                $query = $this->db->query("SELECT id,order_date,payment_date,status,shipping_method,total_price,remark,flag_del,billing_address_id,shipping_address_id,user_id FROM shop_order WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : 
                $query = $this->db->query("SELECT id,order_date,payment_date,status,shipping_method,total_price,remark,flag_del,billing_address_id,shipping_address_id,user_id FROM shop_order WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_order($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_order', $data);
    }
}
?>
