<?php echo $datatable_js; ?>
<script type="text/javascript">
    function delete_category(task, id) {
        $(".datatable #hid_task").val(task);
        $(".datatable #hid_id").val(id);
        $(".datatable #frm_datatable").submit();
    }
</script>
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
                <th style="width: 50px;">
                    ลบ
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($table_data as $row) {
        ?>
            <tr>
                <td><?php echo $row['category_code']; ?></td>
                <td><?php echo anchor('admin/product_category/edit/'.$row['id'] ,$row['name']); ?></td>
                <td>
                    <?php
                        $main_category = $this->product_category_model->get_product_category('id', $row['product_category_id']);
                        if(count($main_category)>=1) {
                            echo $main_category['name'];
                        }
                    ?>
                </td>
                <td>
                    <a href="javascript:delete_category('delete','<?php echo $row['id']; ?>');">ลบ</a>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <div id="pagination">
        <?php echo $pagination; ?>
    </div>
    <input type="hidden" id="hid_p" value="<?php if(is_numeric($this->uri->segment($this->uri->total_segments()))){ echo $this->uri->segment($this->uri->total_segments()); } ?>" />
    <input type="hidden" name="task" id="hid_task" value="" />
    <input type="hidden" name="edit_field" id="hid_field" value="" />
    <input type="hidden" name="edit_id" id="hid_id" value="" />
    <input type="hidden" name="edit_value" id="hid_value" value="" />
    <?php echo form_close(); ?>
</div>