<!-- Panel -->
<div id="toppanel" style="min-width: 940px;">
    <div id="panel">
        <div class="content clearfix" style="padding-top: 10px;padding-left: 50px;">
            <div class="left" style="width: 400px;">
                <h1>ยินดีต้อนรับสู่ <span style="color: #FF3333;">Glixa.com</span></h1>
                <div style="text-indent: 10px;">
                    แหล่งรวบรวมสินค้ามากมายหลายประเภทพร้อมให้ทุกท่านได้เลือกซื้อจับจองเป็นเจ้าของ แล้ววันนี้ขอให้สนุกกับการ shopping ครับ
                </div>
                <div>
                    <span style="color: #FF3333;">Glixa.com</span> ขอขอบพระคุณผู้มีอุปการะคุณทุกท่านเป็นอย่างสูง
                </div>
            </div>
            <div style="color: #cccccc;width: 500px;" class="left">
                <?php 
                    echo form_open('user/login');
                ?>
                <h1>ยินดีต้อนรับสมาชิก <span style="color: #FF3333;">Glixa</span></h1>
                <div class="form_row">
                    <div>
                        <b>อีเมลหรือชื่อร้านค้า</b> : <input type="text" name="txt_email_login" id="txt_email_login" style="width: 100px;border: 1px solid #cccccc;"/>
                        <b>รหัสผ่าน</b> : <input type="password" name="txt_password_login" id="txt_password_login" style="width: 100px;border: 1px solid #cccccc;"/>
                        
                    </div>
                </div>
                <div class="form_row">
                    <div>
                        <input type="checkbox" name="chk_remember_login" id="chk_remember_login" />
                        <label for="chk_remember_login">จดจำการเข้าสู่ระบบ</label>
                        |
                        <?php echo anchor('user/register', 'สมัครสมาชิก'); ?>
                        |
                        <?php echo anchor('user/lost_password', 'ลืมรหัสผ่าน'); ?>
                        &nbsp;&nbsp;&nbsp;
                        <input type="submit" name="btn_login" id="btn_login_h" value="เข้าสู่ระบบ" style="cursor: pointer;" />
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div> <!-- /login -->
    <!-- The tab on top -->
    <div class="tab">
        <ul class="login">
            <li class="left">&nbsp;</li>
            <?php
                if(is_user_login () == true) { // user login
                    $login_info = get_login_info();
                    $user_data = $this->user_model->get_user('email', $login_info['email']);
            ?>
            <li style="width: 180px;">
                <?php echo $user_data['firstname']." ".$user_data['lastname']; ?>
                |
                <?php echo anchor('user/profile', 'ข้อมูลส่วนตัว'); ?>
            </li>
            <li class="sep">|</li>
            <li id="toggle" style="width: 160px;">
                <?php echo anchor('user/logout', 'ออกจากระบบ', array('class'=>'close')); ?>
            </li>
            <?php
                } else { // user not login
            ?>
            <li id="toggle" style="width: 160px;">
                <a id="open" class="open" href="javascript:void(0);" style="width: 140px;">เข้าสู่ระบบ | สมัครสมาชิก</a>
                <a id="close" style="display: none;" class="close" href="javascript:void(0);" style="width: 140px;">ปิด</a>
            </li>
            <?php
                }
            ?>
            <li class="right">&nbsp;</li>
        </ul>
    </div> <!-- / top -->
</div> <!--panel -->