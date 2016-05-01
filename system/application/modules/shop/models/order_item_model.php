<?php
class Order_item_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_order_item($data) {
        $this->db->insert('shop_order_item', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_order_item($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,quantity,present_price,lot_id,tracking_code,remark,product_des,product_id,order_id FROM shop_order_item WHERE flag_del=0 {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,quantity,present_price,lot_id,tracking_code,remark,product_des,product_id,order_id FROM shop_order_item WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_order_item($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_order_item', $data);
    }
}
?>
