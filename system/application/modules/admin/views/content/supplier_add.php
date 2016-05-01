<?php
    echo form_open('admin/supplier/add');
    echo create_form_key();
?>
<div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'name'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_name" value="<?php echo set_value('txt_name'); ?>" />
            <?php echo form_error('txt_name'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'contact_firstname'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_contact_firstname" value="<?php echo set_value('txt_contact_firstname'); ?>" />
            <?php echo form_error('txt_contact_firstname'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'contact_lastname'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_contact_lastname" value="<?php echo set_value('txt_contact_lastname'); ?>" />
            <?php echo form_error('txt_contact_lastname'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'address'); ?></b>
        </div>
        <div id="form_row_control">
            <textarea cols="30" rows="3" name="txt_address"><?php echo set_value('txt_address'); ?></textarea>
            <?php echo form_error('txt_address'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'tambon'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_tambon" value="<?php echo set_value('txt_tambon'); ?>" />
            <?php echo form_error('txt_tambon'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'amphoe'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_amphoe" value="<?php echo set_value('txt_amphoe'); ?>" />
            <?php echo form_error('txt_amphoe'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'province'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_province" value="<?php echo set_value('txt_province'); ?>" />
            <?php echo form_error('txt_province'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'postalcode'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_postalcode" value="<?php echo set_value('txt_postalcode'); ?>" />
            <?php echo form_error('txt_postalcode'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'phone_number1'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_phone_number1" value="<?php echo set_value('txt_phone_number1'); ?>" />
            <?php echo form_error('txt_phone_number1'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'phone_number2'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_phone_number2" value="<?php echo set_value('txt_phone_number2'); ?>" />
            <?php echo form_error('txt_phone_number2'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'fax_number1'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_fax_number1" value="<?php echo set_value('txt_fax_number1'); ?>" />
            <?php echo form_error('txt_fax_number1'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'fax_number2'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_fax_number2" value="<?php echo set_value('txt_fax_number2'); ?>" />
            <?php echo form_error('txt_fax_number2'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'email'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_email" value="<?php echo set_value('txt_email'); ?>" />
            <?php echo form_error('txt_email'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'website'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_website" value="<?php echo set_value('txt_website'); ?>" />
            <?php echo form_error('txt_website'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_supplier', 'detail'); ?></b>
        </div>
        <div id="form_row_control">
            <textarea cols="30" rows="3" name="txt_detail"><?php echo set_value('txt_detail'); ?></textarea>
            <?php echo form_error('txt_detail'); ?>
        </div>
    </div>
</div>
<div>
    <input type="submit" name="btn_add_supplier" value="เพิ่มผู้ผลิดสินค้า" />
</div>
<?php echo form_close(); ?>