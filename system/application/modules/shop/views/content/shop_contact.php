<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
    <?php
        if(isset($message)) {
            echo $message;
        }
    ?>
    <?php echo form_open(current_url()); ?>
    <div class="gre_sec">
        <h3>ติดต่อสอบถาม / สั่งซื้อ</h3>
        <?php
            if(is_user_login()==false) {
        ?>
        <ul class="forms">
            <li class="txt">
                อีเมล
            </li>
            <li class="inputfield">
                <input type="text" name="contact_email" class="txt" />
                <?php echo form_error('contact_email'); ?>
            </li>
        </ul>
        <div class="clear"></div>
        <?php
            } else {
                $login_info = get_login_info();
        ?>
        <input type="hidden" name="contact_email" value="<?php echo $login_info['email']; ?>" />
        <?php
            }
        ?>
        <ul class="forms">
            <li class="txt">
                สินค้า
            </li>
            <li class="inputfield">
                <select name="contact_product" style="width: 335px;">
                    <?php
                        foreach($product_data as $product) {
                    ?>
                    <option value="<?php echo $product['id']; ?>">
                        <?php echo $product['name']; ?>
                    </option>
                    <?php
                        }
                    ?>
                </select>
            </li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">
                จำนวน
            </li>
            <li class="inputfield">
                <input type="text" name="contact_qty" class="txt" />
                <?php echo form_error('contact_qty'); ?>
            </li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">
                หมายเหตุ
            </li>
            <li class="inputfield">
                <textarea name="contact_detail" class="txtx" style="width: 335px;height: 100px;"></textarea>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <a href="#" class="button right" onclick="javascript:$('form').submit();"><span>ส่ง</span></a>
    <?php echo form_close(); ?>
</div>