<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    echo form_open('user/lost_password');
    echo create_form_key();
?>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            อีเมลที่ใช้สมัครสมาชิก
        </li>
        <li class="inputfield">
            <input type="text" name="txt_email" value="" class="txt" />
            <div>
                <?php echo form_error('txt_email'); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
</div>
<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>Reset Password - ตั้งรหัสผ่านใหม่</span></a>
<input type="submit" style="visibility: hidden;" name="btn_submit" value="ส่ง" />
<?php echo form_close(); ?>