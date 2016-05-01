<?php
class User_address_model  extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_user_address($data) {
        $this->db->insert('shop_user_address', $data);
    }
    /*
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_user_address($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_user() : select all row
                $query = $this->db->query("SELECT id,firstname,lastname,address,tambon,amphoe,province,postalcode,tel_num,fax_num,user_id FROM shop_user_address WHERE {$option}");
                return $query->result_array();
            default : // get_user('id','1') : select one row
                $query = $this->db->query("SELECT id,firstname,lastname,address,tambon,amphoe,province,postalcode,tel_num,fax_num,user_id FROM shop_user_address WHERE {$field}=? {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $data = array('fieldname'=>'values');
     */
    public function edit_user_address($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_user_address', $data);
    }
    /*
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $data = array('fieldname'=>'values');
     */
    public function del_user_address($field, $value) {
        $this->db->where($field, $value);
        $this->db->delete('shop_user_address');
    }

}
?>
