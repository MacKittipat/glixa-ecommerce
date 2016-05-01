<?php
class Purchase_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * $data = array('fieldname'=>'values');
     */
    public function add_purchase($data) {
        $this->db->insert('shop_purchase', $data);
    }
    /*
     * $field = ชื่อ field เช่น id
     * $value = ค่าของ field เช่น 1
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_purchase($field='', $value='', $option='') {
        switch ($field) {
            case '' :
                $query = $this->db->query("SELECT id,purchase_date,status,create_date,supplier_name,supplier_contact_firstname,
                        supplier_contact_lastname,supplier_address,supplier_tambon,supplier_amphoe,supplier_province,
                        supplier_postalcode,supplier_phone_number1,supplier_phone_number2,supplier_fax_number1,supplier_fax_number2,
                        supplier_email,supplier_website,supplier_detail,user_id,flag_del FROM shop_purchase WHERE flag_del=0 {$option}");
                return $query->result_array();
            default :
                $query = $this->db->query("SELECT id,purchase_date,status,create_date,supplier_name,supplier_contact_firstname,
                        supplier_contact_lastname,supplier_address,supplier_tambon,supplier_amphoe,supplier_province,
                        supplier_postalcode,supplier_phone_number1,supplier_phone_number2,supplier_fax_number1,supplier_fax_number2,
                        supplier_email,supplier_website,supplier_detail,user_id,flag_del FROM shop_purchase WHERE {$field}=? AND  flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    public function edit_purchase($where='',$data='') {
        if ($where != '') {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->update('shop_purchase', $data);
    }
}
?>
