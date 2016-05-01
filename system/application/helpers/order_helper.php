<?php
    function order_number($year,$month,$id) {

        $years = $year[2].$year[3]; // เอาปี 2 หลักท้าย
        $count_id = strlen((string)$id);
        $num_0 = 6-$count_id; // จำนวน 0 ที่ต้องมาต่อ id ให้ครบ 6 หลัก
        $str_0 = '';
        if($num_0 > 0) {
            for($i=1;$i<=$num_0;$i++) {
                $str_0 .= '0';
            }
        }
        $id = $str_0.$id;
        return $years.$month.$id;
    }
?>
