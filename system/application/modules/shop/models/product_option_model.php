<?php
class product_option_model extends Model {
    public function __construct() {
        parent::Model();
    }
    public function add_product_option($data) {
        $this->db->insert('shop_product_option', $data);
    }
    public function edit_product_option($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product_option', $data);
    }
    public function get_product_option($field='', $value='', $option='') {
        switch ($field) {
            case '' : 
                $query = $this->db->query("SELECT id,options,value,product_id FROM shop_product_option WHERE {$option}");
                return $query->result_array();
            default : 
                $query = $this->db->query("SELECT id,options,value,product_id FROM shop_product_option WHERE {$field}=? {$option}", array($value));
                return $query->row_array();
        }
    }
    public function del_product_option($field, $value) {
        $this->db->where($field, $value);
        $this->db->delete('shop_product_option');
    }
}
?>
