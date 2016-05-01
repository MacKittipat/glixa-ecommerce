<?php
class User_profile_model extends Model  {
    public function __construct() {
        parent::Model();
    }
    /*
     * register new user
     * $data = array('fieldname'=>'values');
     */
    public function add_user_profile($data) {
        $this->db->insert('shop_user_profile', $data);
    }
    /*
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_user_profile($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_user() : select all row
                $query = $this->db->query("SELECT id,identity_number,address,tambon,amphoe,province,postalcode,tel_num,user_id FROM shop_user_profile WHERE {$option}");
                return $query->result_array();
            default : // get_user('id','1') : select one row
                $query = $this->db->query("SELECT id,identity_number,address,tambon,amphoe,province,postalcode,tel_num,user_id FROM shop_user_profile WHERE {$field}=? {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit user profile
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $data = array('fieldname'=>'values');
     */
    public function edit_user_profile($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_user_profile', $data);
    }
}
?>
