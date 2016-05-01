<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<?php
    echo form_open('user/edit_address/'.$this->uri->segment(3));
    echo create_form_key();
?>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'firstname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_firstname" value="<?php echo $user_address_data['firstname']; ?>" />
            <div><?php echo form_error('txt_firstname'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'lastname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_lastname" value="<?php echo $user_address_data['lastname']; ?>" />
            <div><?php echo form_error('txt_lastname'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'address'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_address" value="<?php echo $user_address_data['address']; ?>" />
            <div><?php echo form_error('txt_address'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'tambon'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_tambon" value="<?php echo $user_address_data['tambon']; ?>" />
            <div><?php echo form_error('txt_tambon'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'amphoe'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_amphoe" value="<?php echo $user_address_data['amphoe']; ?>" />
            <div><?php echo form_error('txt_amphoe'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'province'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_province" value="<?php echo $user_address_data['province']; ?>" />
            <div><?php echo form_error('txt_province'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'postalcode'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_postalcode" value="<?php echo $user_address_data['postalcode']; ?>" />
            <div><?php echo form_error('txt_postalcode'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'tel_num'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_tel_num" value="<?php echo $user_address_data['tel_num']; ?>" />
            <div><?php echo form_error('txt_tel_num'); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_address', 'fax_num'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_fax_num" value="<?php echo $user_address_data['fax_num']; ?>" />
            <div><?php echo form_error('txt_fax_num'); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
</div>
<a href="javascript:void(0);" class="button right" style="margin-top: -5px;" onclick="javascript:$('form').submit();"><span>บันทึก</span></a>
    <div class="form_row" style="display: none;">
        <input type="submit" name="btn_submit" value="บันทึก" />
    </div>
<?php echo form_close(); ?>
