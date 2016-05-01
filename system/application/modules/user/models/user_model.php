<?php
class User_model extends Model {
    public function __construct() {
        parent::Model();
    }
    /*
     * login
     * เช็คว่า login สำเร็จหรือไม่ ถ้าสำเร็จ return true
     */
    public function login_success($email, $password) {
        $query = $this->db->query('SELECT id FROM wive_user WHERE email=? AND password=? AND available=1 AND flag_del=0', array($email, md5($password)));
        if($query->num_rows()==1) {
            return true; // มี email / password นี้ใน DB จะ login สำเร็จ
        }
        return false;
    }

    public function username_login_success($username, $password) {
        $query = $this->db->query('SELECT id FROM wive_user WHERE username=? AND password=? AND available=1 AND flag_del=0', array($username, md5($password)));
        if($query->num_rows()==1) {
            return true; // มี email / password นี้ใน DB จะ login สำเร็จ
        }
        return false;
    }


    /*
     * register new user
     * $data = array('fieldname'=>'values');
     */
    public function register($data) {
        $data['password'] = md5($data['password']);
        $this->db->insert('wive_user', $data);
    }
    /*
     * get user profile
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $option = เงื่อนไขอื่นๆ เช่น ORDER BY
     */
    public function get_user($field='', $value='', $option='') {
        switch ($field) {
            case '' : // get_user() : select all row
                $query = $this->db->query("SELECT id,email,username,password,firstname,lastname,level,regis_date,available,flag_del FROM wive_user WHERE flag_del=0 {$option}");
                return $query->result_array();
            default : // get_user('id','1') : select one row
                $query = $this->db->query("SELECT id,email,username,password,firstname,lastname,level,regis_date,available,flag_del FROM wive_user WHERE {$field}=? AND flag_del=0 {$option} LIMIT 1", array($value));
                return $query->row_array();
        }
    }
    /*
     * edit user profile
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     * $data = array('fieldname'=>'values');
     */
    public function edit_user($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('wive_user', $data);
    }
    /*
     * del_user
     * $field = ชื่อ field เช่น email
     * $value = ค่าของ field เช่น mac@mac.com
     */
    public function del_user($field, $value) {
        $this->db->where($field, $value);
        $this->db->delete('wive_user');
    }
}
?>
