<?php
class User_shop_model extends Model {
    public function __construct() {
        parent::Model();
    }
    public function add_user_shop($data) {
        $this->db->insert('shop_user_shop', $data);
    }
    public function edit_user_shop($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_user_shop', $data);
    }
    public function get_user_shop($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_user() : select all row
                $query = $this->db->query("SELECT id,image,email,tel_num,facebook_id,description,promotion,instruction,user_address_id,user_id FROM shop_user_shop WHERE {$option}");
                return $query->result_array();
            default : // get_user('id','1') : select one row
                $query = $this->db->query("SELECT id,image,email,tel_num,facebook_id,description,promotion,instruction,user_address_id,user_id FROM shop_user_shop WHERE {$field}=? {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
}
?>
