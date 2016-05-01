<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    if(isset($message)) {
        echo $message;
    }
?>
<?php
    echo form_open('user/login');
?>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'username_or_email'); ?> 
        </li>
        <li class="inputfield">
            <input type="text" name="txt_email_login" id="txt_email_login" class="txt" />
            <div><?php echo form_error('txt_email_login'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'password'); ?> 
        </li>
        <li class="inputfield">
            <input type="password" name="txt_password_login" id="txt_password_login" class="txt" />
            <div>
                <?php echo form_error('txt_password_login'); ?>
                <?php echo $msg_login_error; ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'remember'); ?>
        </li>
        <li class="radiobutton">
            <input type="checkbox" name="chk_remember_login" id="chk_remember_login" />
        </li>
    </ul>
    <div class="clear"></div>
</div>
<div class="left">
    <?php echo anchor('user/register', 'สมัครสมาชิก'); ?> | <?php echo anchor('user/lost_password', 'ลืมรหัสผ่าน'); ?>
</div>
<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>Login - เข้าสู่ระบบ</span></a>
<input type="submit" style="visibility: hidden;" name="btn_login" id="btn_login" value="เข้าสู่ระบบ" />
<?php echo form_close(); ?>