<?php
class Product_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * add_product
     * $data = array('fieldname'=>'values');
     */
    public function add_product($data) {
        $this->db->insert('shop_product', $data);
    }
    /*
     * get product
     * $field = ชื่อ field 
     * $value = ค่าของ field
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_product($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_product() : select all row
                $query = $this->db->query("SELECT id,product_code,name,title,detail,image,cost,price,quantity,unit,full_price,weight,size,color,type,type2,options,add_date,available,end_date,owner_id,owner_type,product_category_id FROM shop_product WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_product('id','1') : select one row
                $query = $this->db->query("SELECT id,product_code,name,title,detail,image,cost,price,quantity,unit,full_price,weight,size,color,type,type2,options,add_date,available,end_date,owner_id,owner_type,product_category_id FROM shop_product WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit product
     * $field = ชื่อ field 
     * $value = ค่าของ field 
     * $data = array('fieldname'=>'values');
     */
    public function edit_product($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('shop_product', $data);
    }
}
?>
