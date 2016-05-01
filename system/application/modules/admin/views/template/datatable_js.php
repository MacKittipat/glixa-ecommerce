<script type="text/javascript">
    var datatable_url = '<?php echo $datatable_url; ?>';
    // Submit : Search
    function datatable_submit() {
        var search_field = $(".datatable #ddl_search").val();
        var search_value = $(".datatable #txt_search").val();
        if(search_value!='') {
            window.location.href = datatable_url+"sf/"+search_field+"/sv/"+search_value;
        } else {
            window.location.href = datatable_url;
        }
        return false;
        $(".datable #frm_datatable").submit();
    }
    // Order
    function datatable_order(order, sort) {
        var search_field = $(".datatable #ddl_search").val();
        var search_value = $(".datatable #txt_search").val();
        var p = $(".datatable #hid_p").val();
        if(search_value!="") { // มีการ search แล้ว order
            if(p!="") { // ไม่ใช่ page แรก
                window.location.href = datatable_url+"of/"+order+"/ov/"+sort+"/sf/"+search_field+"/sv/"+search_value+"/p/"+p;
            } else { // page แรกจะไม่แสดง /p/
                window.location.href = datatable_url+"of/"+order+"/ov/"+sort+"/sf/"+search_field+"/sv/"+search_value;
            }
        } else { // order อย่างเดียว
            if(p!="") { // ไม่ใช่ page แรก
                window.location.href = datatable_url+"of/"+order+"/ov/"+sort+"/p/"+p;
            } else { // page แรกจะไม่แสดง /p/
                window.location.href = datatable_url+"of/"+order+"/ov/"+sort;
            }
        }
        return false;
        $(".datatable #frm_datatable").submit();
    }
    // delete row
    function datatable_delete(task) {
        $(".datatable #hid_task").val(task);
        $(".datatable #frm_datatable").submit();
    }
    // update row
    function datatable_edit(task, field, user_id, value) {
        $(".datatable #hid_task").val(task);
        $(".datatable #hid_field").val(field);
        $(".datatable #hid_id").val(user_id);
        $(".datatable #hid_value").val(value);
        $(".datatable #frm_datatable").submit();
    }
    // chkbox
    $(document).ready(function() {
        // chk delete
        $(".datatable #chk_all").change(function() {
            // check = true
            if($(".datatable #chk_all").attr('checked')==true) {
                $(".datatable .chk_row").attr('checked', true);
            } else {
                $(".datatable .chk_row").attr('checked', false);
            }
        });
    });
</script>