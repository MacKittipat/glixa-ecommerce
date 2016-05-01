<?php
    echo form_open(current_url());
    echo create_form_key();
?>
<div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'firstname'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_firstname" value="<?php echo $user_data['firstname']; ?>" />
            <?php echo form_error("txt_firstname"); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'lastname'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_lastname" value="<?php echo $user_data['lastname']; ?>" />
            <?php echo form_error("txt_lastname"); ?>
        </div>
    </div>

    <?php
        if($user_data['level']=='supplier' ) {
    ?>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('shop_supplier', 'user_id'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <?php
                if($supplier_data!=null) {
                    echo anchor('admin/supplier/edit/'.$supplier_data['id'], $supplier_data['name']);
                } else {
                    echo 'ยังไม่ได้กำหนดผู้ผลิตสินค้าให้ผู้ใช้คนนี้';
                }
            ?>
        </div>
    </div>
    <?php
        }
    ?>

    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'regis_date'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <?php echo pretty_date($user_data['regis_date']); ?>
        </div>
    </div>
</div>
<div>
    <input type="submit" name="btn_edit_profile" id="btn_edit_profile" value="บันทึก" />
</div>
<?php echo form_close(); ?>