<?php
class MY_Form_validation extends CI_Form_validation {
    public $CI;
    public function __construct($rules = array()) {
        parent::CI_Form_validation($rules);
        $this->CI =& get_instance();
    }
    /*
     * have
     * เช็คว่ามี $str นี้ใน $field ของ table ใน DB หรือไม่ ถ้าไม่มี return false
     * ใช้ในกรณีเช่น login จะต้องเช็คว่ามี email นี้อยู่ใน table wive_user ใน DB จริง
     * $str = value
     * $field = table.column
     */
    function have($str, $field) {
        $this->CI->load->database();
        list($table, $column) = explode(".", $field);
        $query = $this->CI->db->query("SELECT id FROM {$table} WHERE {$column}=?", array($str));
        if($query->num_rows()==1) {
            return true; // มี
        }
        return false; // ไม่มีจะแสดง error
    }
    /*
     * unique
     * เช็คว่า $str ใน $field มีค่าซ้ำกับใน DB หรือไม่ ถ้าซ้ำ return false
     * ใช้ในกรณีสมัครสมาชิก จะเช็คว่า email มีใช้อยู่แล้วหรอืไม่
     * $str = value
     * $field = table.column
     */
    function unique($str, $field) {
        $this->CI->load->database();
        list($table, $column) = explode(".", $field);
        $query = $this->CI->db->query("SELECT id FROM {$table} WHERE {$column}=?", array($str));
        if($query->num_rows()==1) {
            return false; // มีจะแสดง error ว่าใช้ค่าซ้ำไม่ได้
        }
        return true; // ไม่มี
    }
    /*
     * eng_num
     * เช็คว่า $str เป็น eng และ num หรือไม่ if(preg_match("/^[a-zA-Z0-9]+$/",$str)==true) {
     * เพิ่ม _ ด้วย
     * $str = value
     */
    function eng_num($str) {
        if(preg_match("/^[a-zA-Z0-9_]+$/",$str)==true) {
            return true;
        }
        return false; // ไม่ใช่ eng และ num
    }

    function deny_username($str) {
        $this->CI->config->load('username');
        $deny_username = $this->CI->config->item('deny_username');
        if(in_array($str, $deny_username)) {
            return false; // $str เป็น username ต้องห้าม
        }
        return true;
    }

    /**
     * เช็คว่าไม่ใช่ value ที่กำหนด
     * $str = value
     * $field = value ที่ไม่ต้องการให้เหมือนกัน
     */
    function is_price_not_zero($str) {
        if($str!='0') {
            return true;
        }
        return false;
    }

    function is_id_number($str) {
        if (strlen($str) != 13)
            return false;
        for ($i = 0, $sum = 0; $i < 12; $i++)
            $sum += (int) ($str[$i]) * (13 - $i);
        if ((11 - ($sum % 11)) % 10 == (int) ($str[12]))
            return true;
        return false;
    }

    function char($str) {
        if(preg_match("/^[ก-ฮเa-zA-Z_]+$/", $str)==true) {
            return true;
        } else {
            return false;
        }
    }

}
?>
