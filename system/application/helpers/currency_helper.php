<?php
    /*
     * $money = จำนวนเงิน
     * return x,xxx,xxx.xx
     */
    function currency($money) {
        return number_format((float)$money, 2, '.', ',');
    }
?>
