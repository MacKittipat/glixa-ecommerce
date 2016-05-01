<?php
class Order_item_option_model extends Model {
    public function __construct() {
        parent::Model();
    }
    public function add_order_item_option($data) {
        $this->db->insert('shop_order_item_option', $data);
    }
    public function edit_order_item_option($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_order_item_option', $data);
    }
    public function get_order_item_option($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,options,value,order_item_id FROM shop_order_item_option WHERE {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,options,value,order_item_id FROM shop_order_item_option WHERE {$field}=? {$option}", array($value));
                return $query->row_array();
        }
    }
    public function del_order_item_option($field, $value) {
        $this->db->where($field, $value);
        $this->db->delete('shop_order_item_option');
    }
}
?>
