<?php

class Order_item_lot_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_order_item_lot($data) {
        $this->db->insert('shop_order_item_lot', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_order_item_lot($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,shipment_cost,deliver_date,deliver_price,tracking_code,order_item_id,product_lot_id FROM shop_order_item_lot WHERE {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,shipment_cost,deliver_date,deliver_price,tracking_code,order_item_id,product_lot_id FROM shop_order_item_lot WHERE {$field}=? {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * $field = ชื่อ field
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_order_item_lot($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_order_item_lot', $data);
    }
}
?>
