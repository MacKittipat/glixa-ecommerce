<?php
class Product_lot_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_product_lot($data) {
        $this->db->insert('shop_product_lot', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product_lot($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,product_id,quantity,price,flag_del,purchase_id FROM shop_product_lot WHERE flag_del=0 {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,product_id,quantity,price,flag_del,purchase_id FROM shop_product_lot WHERE {$field}=? AND  flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    public function edit_product_lot($where='',$data='') {
        if ($where != '') {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->update('shop_product_lot', $data);
    }
}
?>
