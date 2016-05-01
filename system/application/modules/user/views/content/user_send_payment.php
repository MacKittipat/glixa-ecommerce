<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
    <?php
        if(isset($message)) {
            echo $message;
        }
        echo form_open('user/send_payment');
        echo create_form_key();
    ?>
<?php
    if($order_data!=null) {
?>
<div class="gre_sec">
    <h3>กรุณากรอกข้อมูลให้ครบถ้วน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'firstname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_firstname" class="txt" value="<?php echo $user_data['firstname']; ?>" disabled />
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'lastname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_lastname" class="txt" value="<?php echo $user_data['lastname']; ?>" disabled />
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'email'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_email" class="txt" value="<?php echo $user_data['email']; ?>" disabled />
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'tel_num'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_tel_num" class="txt" value="<?php echo $user_profile_data['tel_num']; ?>"
                   <?php
                        if($user_profile_data['tel_num']!='') {
                            echo 'disabled';
                        }
                   ?>
                   />
            <?php echo form_error('txt_tel_num'); ?>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            หมายเลขอ้างอิงการสั่งซื้อ
        </li>
        <li class="inputfield">
            <?php
                if($order_data!=null) {
            ?>
            <select name="ddl_order_id" style="width: 170px;">
            <?php
                foreach($order_data as $value) {
            ?>
                <option value="<?php echo $value['id']; ?>">
                    <?php echo order_number(get_year($value['order_date']), get_month($value['order_date']), $value['id']); ?>
                </option>
            <?php
                }
            ?>
            </select>
            <?php
                } else {
            ?>
            <select name="ddl_order_id" style="width: 170px;">
                <option value="0">ไม่มีหมายเลขการสั่งซื้อ</option>
            </select>
            <?php
                }
            ?>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_payment', 'money'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_money" class="txt" value="" />
            <div><?php echo form_error('txt_money'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_payment', 'payment_method'); ?>
        </li>
        <li class="inputfield">
            <select name="ddl_payment_method" style="width: 150px;">
                <option value="bank">
                    โอนผ่านธนาคาร
                </option>
                <option value="atm">
                    โอนจากตู้ ATM
                </option>
                <option value="online">
                    โอนผ่านออน์ไลน์
                </option>
            </select>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_payment', 'payment_date'); ?>
        </li>
        <li class="inputfield">
            <input type="text" class="txt" name="txt_payment_date" id="datepicker" value="" />
            <div><?php echo form_error('txt_payment_date'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_payment', 'detail'); ?>
        </li>
        <li class="inputfield">
            <textarea class="txtx" style="width: 335px;" name="txt_detail" cols="50" rows="4"></textarea>
        </li>
    </ul>
    <div class="clear"></div>
    <div class="form_row" style="display: none;">
        <input type="submit" name="btn_submit" value="แจ้งการชำระเงิน" />
    </div>
</div>
    <div>
        <a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>แจ้งการชำระเงิน</span></a>
    </div>
    <?php echo form_close(); ?>

<?php
    } else {
?>
    ยังไม่มีรายการสั่งซื้อ สนใจสินค้าของเราเลือก <?php echo anchor('shop/glixa_guarantee', 'Glixa Guarantee'); ?>
<?php
    }
?>

<link rel="stylesheet" href="<?php echo assets_js('datepicker/css/ui-lightness/jquery-ui-1.8.5.custom.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('datepicker/js/jquery-ui-1.8.5.custom.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datepicker').datepicker({
             dateFormat: 'yy-mm-dd'
        });
    });
</script>