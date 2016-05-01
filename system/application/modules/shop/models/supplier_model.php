<?php
class Supplier_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * add_supplier
     * $data = array('fieldname'=>'values');
     */
    public function add_supplier($data) {
        $this->db->insert('shop_supplier', $data);
    }
    /*
     * get_supplier
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_supplier($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product_category() : select all row
                $query = $this->db->query("SELECT id,name,contact_firstname,contact_lastname,address,tambon,amphoe,province,postalcode,phone_number1,phone_number2,fax_number1,fax_number2,email,website,detail,add_date,user_id FROM shop_supplier WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product_category('id','1') : select one row
                $query = $this->db->query("SELECT id,name,contact_firstname,contact_lastname,address,tambon,amphoe,province,postalcode,phone_number1,phone_number2,fax_number1,fax_number2,email,website,detail,add_date,user_id FROM shop_supplier WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit supplier
     * $field = ชื่อ field 
     * $value = ค่าของ field
     * $data = array('fieldname'=>'values');
     */
    public function edit_supplier($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_supplier', $data);
    }
}
?>
