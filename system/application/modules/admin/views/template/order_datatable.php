<?php echo $datatable_js; ?>
<script type="text/javascript">
    function change_search(field) {
        if(field=="available") {
            $(".datatable #search_control").html("<select name='txt_search' id='txt_search'><option value='1'>true</option><option value='0'>false</option></select>");
        } else {
            $(".datatable #search_control").html('<input type="text" id="txt_search" name="txt_search" value="" />');
        }
    }
</script>
<div class="datatable">
    <?php echo form_open($action_page, array('id'=>'frm_datatable', 'onsubmit'=>'return datatable_submit();')); ?>
    <div id="datatable_search">
        <select id="ddl_search" onchange="change_search(this.value);">
            <?php
                foreach ($search_field as $key => $value) {
                $seg_url = $this->uri->uri_to_assoc($num_uri_to_assoc);
                $selected = '';
                $search_value = '';
                if(isset($seg_url['sf'])) { // มีก่าร serach
                    if($seg_url['sf']==$key) {
                        $selected = 'selected';
                    }
                    $search_value = $seg_url['sv']; // set search value ให้มีค่าเดิมคือให้ txt มีค่าเดิม
                }
            ?>
            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
            <?php
                }
            ?>
        </select>
        <span id="search_control">
            <?php
                if(isset($seg_url['sf']) && ($seg_url['sf']=='available')) {
            ?>
                <select name='txt_search' id='txt_search'>
                    <option value='1' <?php if($search_value=='1'){ echo 'selected'; } ?>>true</option>
                    <option value='0' <?php if($search_value=='0'){ echo 'selected'; } ?>>false</option>
                </select>
            <?php
                } else {
            ?>
                <input type="text" id="txt_search" name="txt_search" value="<?php echo $search_value; ?>" />
            <?php
                }
            ?>
        </span>
        <input type="submit" id="btn_search" value="Search" />
    </div>
    <table id="datatable_table" border="1">
        <thead>
            <tr id="datatable_table_header">
                <th style="width: 25px;">
                    <input type="checkbox" name="chk_all" id="chk_all" />
                </th>
                <th style="width: 200px;">
                    รหัสรายการสั่งซื้อ
                </th>
                <?php
                    foreach ($tabel_field as $key => $value) {
                ?>
                <th style="width: <?php echo $value[1]; ?>px;">
                    <?php
                        $sort = 'asc';
                        if(isset($seg_url['of']) && $seg_url['ov']=='asc') {
                            $sort = 'desc';
                        } else {
                            $sort = 'asc';
                        }
                    ?>
                    <a href="javascript:datatable_order('<?php echo $key; ?>','<?php echo $sort; ?>');"><?php echo $value[0]; ?></a>
                </th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($table_data as $row) {
        ?>
            <tr>
                <td><input type="checkbox" name="chk_row[]" class="chk_row" value="<?php echo $row['id']; ?>" /></td>
                <td>
                    <?php
                        echo anchor('admin/order/edit/'.$row['id'], order_number(get_year($row['order_date']), get_month($row['order_date']), $row['id'])); 
                    ?>
                </td>
                <td><?php echo $row['order_date']; ?></td>
                <td>
                <?php
                    if($row['status']=='wait') {
                        echo 'รอชำระเงิน';
                    } else if($row['status']=='paid') {
                        echo 'ชำระเงินแล้ว';
                    } else if($row['status']=='partial_send') {
                        echo 'ส่งของบางส่วนแล้ว';
                    } else if($row['status']=='send') {
                        echo 'ส่งของแล้ว';
                    }
                ?>
                </td>
                <td><?php echo $row['shipping_method']; ?></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <div id="pagination">
        <?php echo $pagination; ?>
    </div>
    <div>
        <input type="button" name="btn_del" id="btn_del" value="Delete" onclick="datatable_delete('delete');" />
    </div>
    <input type="hidden" id="hid_p" value="<?php if(is_numeric($this->uri->segment($this->uri->total_segments()))){ echo $this->uri->segment($this->uri->total_segments()); } ?>" />
    <input type="hidden" name="task" id="hid_task" value="" />
    <input type="hidden" name="edit_field" id="hid_field" value="" />
    <input type="hidden" name="edit_id" id="hid_id" value="" />
    <input type="hidden" name="edit_value" id="hid_value" value="" />
    <?php echo form_close(); ?>
</div>
