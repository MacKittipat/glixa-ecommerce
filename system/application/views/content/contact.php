<script src="<?php echo assets_template('estore/js/ddaccordion.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_template('estore/js/acordin.js'); ?>" type="text/javascript"></script>
<div class="left_colmn">
    <!-- Categories Section -->
    <div class="section">
        <?php $this->load->view('shop/include/browse_category'); ?>
    </div>
</div>
<div class="right_colmn">
    <h2 class="heading">
        <?php echo $page_title; ?>
    </h2>
    <?php echo form_open('contact'); ?>
    <div class="gre_sec">
        <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
        <ul class="forms">
            <li class="txt">Name - ชื่อ</li>
            <li class="inputfield">
                <input type="text" name="txt_name" class="bar" value="<?php echo set_value('txt_name'); ?>" />
                <div><?php echo form_error('txt_name'); ?></div>
            </li>
            <li class="req">(Required)</li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">E-mail - อีเมล</li>
            <li class="inputfield">
                <input type="text" name="txt_mail" class="txt" value="<?php echo set_value('txt_mail'); ?>"  />
                <div><?php echo form_error('txt_mail'); ?></div>
            </li>
            <li class="req">(Required)</li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">Tel. - เบอร์โทร</li>
            <li class="inputfield">
                <input type="text" name="txt_tel_num" class="txt" value="<?php echo set_value('txt_tel_num'); ?>" />
                <div><?php echo form_error('txt_tel_num'); ?></div>
            </li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">Subject - หัวข้อ</li>
            <li class="inputfield">
                <input type="text" name="txt_subject" class="txt" value="<?php echo set_value('txt_subject'); ?>" />
                <div><?php echo form_error('txt_subject'); ?></div>
            </li>
            <li class="req">(Required)</li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">Detail - รายละเอียด</li>
            <li class="inputfield">
                <textarea name="txt_detail" cols="55" rows="5" class="txtx" style="width: 340px;"><?php echo set_value('txt_detail'); ?></textarea>
                <div><?php echo form_error('txt_detail'); ?></div >
            </li>
            <li class="req">(Required)</li>
        </ul>
        <div class="clear"></div>    
    </div>
    <a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>ส่งข้อมูล</span></a>
    
    <input type="hidden" name="btn_submit" value="ส่ง" />
    <input type="submit" style="visibility: hidden" name="btn_submit" value="ส่ง" />
    
    <?php echo form_close(); ?>
</div>
