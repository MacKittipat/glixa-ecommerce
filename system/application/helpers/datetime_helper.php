<?php
    function pretty_date($date) {
        return $date;
    }
    function get_year($datetime) {
        return date('Y',strtotime($datetime));
    }
    function get_month($datetime) {
        return date('m',strtotime($datetime));
    }
    function get_day($datetime) {
        return date('d',strtotime($datetime));
    }
?>
