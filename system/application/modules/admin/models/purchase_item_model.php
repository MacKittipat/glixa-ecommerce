<?php
class Purchase_item_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_purchase_item($data) {
        $this->db->insert('shop_purchase_item', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_purchase_item($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,product_id,quantity,price,deliver_date,payment_price,payment_date,flag_del,purchase_id FROM shop_purchase_item WHERE flag_del=0 {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,product_id,quantity,price,deliver_date,payment_price,payment_date,flag_del,purchase_id FROM shop_purchase_item WHERE {$field}=? AND  flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }

    public function edit_purchase_item($where='',$data='') {
        if ($where != '') {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->update('shop_purchase_item', $data);
    }
}
?>
