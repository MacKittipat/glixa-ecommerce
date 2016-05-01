<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    echo form_open('user/register', array('id'=>'frm_register'));
    echo create_form_key();
?>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'email'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_email_register" id="txt_email_register" value="<?php echo set_value('txt_email_register'); ?>" class="txt" />
            <div>
                <?php echo form_error('txt_email_register'); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'password'); ?>
        </li>
        <li class="inputfield">
            <input type="password" name="txt_password_register" id="txt_password_register" class="txt" />
            <div>
                <?php echo form_error('txt_password_register'); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'cpassword'); ?>
        </li>
        <li class="inputfield">
            <input type="password" name="txt_cpassword_register" id="txt_cpassword_register" class="txt" />
            <div>
                <?php echo form_error('txt_cpassword_register'); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'username'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_username_register" id="txt_username_register" value="<?php echo set_value('txt_username_register'); ?>" class="txt" />
            <div><?php echo form_error('txt_username_register'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'firstname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_firstname_register" id="txt_firstname_register" value="<?php echo set_value('txt_firstname_register'); ?>" class="txt" />
            <div><?php echo form_error('txt_firstname_register'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <div><?php echo get_field_lang('wive_user', 'lastname'); ?></div>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_lastname_register" id="txt_lastname_register" value="<?php echo set_value('txt_lastname_register'); ?>" class="txt" />
            <?php echo form_error('txt_lastname_register'); ?>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <div style="padding-left: 18px;">
        <span style="color: #A2422C;">*</span> การคลิกปุ่มสมัครสมาชิกด้านล่างถือว่าท่านได้ทำการยอมรับ <?php echo anchor('term_of_service', 'เงื่อนไข ( Term Of Service )'); ?> ของ Glixa แล้ว
    </div>
</div>
<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>Register - สมัครสมาชิก</span></a>
<div class="form_row">
    <input type="submit" style="visibility: hidden;" name="btn_register" id="btn_register" value="สมัครสมาชิก" />
</div>
<?php echo form_close(); ?>