<?php echo $datatable_js; ?>
<div>
    <?php
        echo anchor('admin/supplier/add', 'เพิ่มผู้ผลิต');
    ?>
</div>
<div class="datatable">
    <?php echo form_open($action_page, array('id'=>'frm_datatable', 'onsubmit'=>'return datatable_submit();')); ?>
    <div id="datatable_search">
        <select id="ddl_search">
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
        <input type="text" id="txt_search" name="txt_search" value="<?php echo $search_value; ?>" />
        <input type="submit" id="btn_search" value="Search" />
    </div>
    <table id="datatable_table" border="1">
        <thead>
            <tr id="datatable_table_header">
                <th style="width: 25px;">
                    <input type="checkbox" name="chk_all" id="chk_all" />
                </th>
                <?php
                    foreach ($tabel_field as $key => $value) {
                ?>
                <th style="width: <?php echo $value[1]; ?>px;">
                    <?php
                        $sort = 'desc';
                        if(isset($seg_url['of']) && $seg_url['ov']=='desc') {
                            $sort = 'asc';
                        } else {
                            $sort = 'desc';
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
                <td><?php echo anchor('admin/supplier/edit/'.$row['id'] ,$row['name']); ?></td>
                <td><?php echo $row['contact_firstname']; ?></td>
                <td><?php echo $row['contact_lastname']; ?></td>
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