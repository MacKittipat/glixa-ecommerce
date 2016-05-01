<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    echo form_open('user/edit_password');
    echo create_form_key();
?>
<div class="form_row" style="margin-bottom: 5px;">
    <?php echo $message; ?>
</div>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_edit_password', 'old_password'); ?>
        </li>
        <li class="inputfield">
            <input type="password" name="txt_old_password" class="txt" />
            <div>
            <?php
                echo form_error('txt_old_password');
                if(isset($error_message)) {
                    echo '<label class="error">'.$error_message.'</label>';
                }
            ?>                
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_edit_password', 'new_password'); ?>
        </li>
        <li class="inputfield">
            <input type="password" name="txt_password" class="txt" />
            <div><?php echo form_error('txt_password'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_edit_password', 'confirm_new_password'); ?>
        </li>
        <li class="inputfield">
            <input type="password" name="txt_cpassword" class="txt" />
            <div><?php echo form_error('txt_cpassword'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>  
</div>

<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>แก้ไขรหัสผ่าน</span></a>
<div class="form_row">
    <input type="submit" style="visibility: hidden;" name="btn_edit_password" id="btn_edit_password" value="บันทึก" />
</div>
<?php echo form_close(); ?>