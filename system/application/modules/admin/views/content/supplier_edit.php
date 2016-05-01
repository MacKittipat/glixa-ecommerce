<?php 
    echo form_open(current_url());
    echo create_form_key();
?>
<div style="overflow: hidden;">
    <div style="float: left;width: 300px;">
        <div class="form_row">
            <div id="form_row_title">
                <b>รหัสของผู้ใช้งานที่เป็น<?php echo get_field_lang('shop_supplier', 'user_id'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_user_id" value="<?php echo $supplier_data['user_id'] ?>" />
                <?php echo form_error('txt_user_id'); ?>
            </div>
            <div>

                <?php
              $user_data = $this->user_model->get_user('id', $supplier_data['user_id']);
                if($user_data!=null) {
                echo anchor('admin/user/profile/' . $user_data['id'], $user_data['firstname'] . ' ' . $user_data['lastname']);

                }
                  ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'name'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_name" value="<?php echo $supplier_data['name'] ?>" />
                <?php echo form_error('txt_name'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'contact_firstname'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_contact_firstname" value="<?php echo $supplier_data['contact_firstname'] ?>" />
                <?php echo form_error('txt_contact_firstname'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'contact_lastname'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_contact_lastname" value="<?php echo $supplier_data['contact_lastname'] ?>" />
                <?php echo form_error('txt_contact_lastname'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'address'); ?></b>
            </div>
            <div id="form_row_control">
                <textarea cols="30" rows="3" name="txt_address"><?php echo $supplier_data['address'] ?></textarea>
                <?php echo form_error('txt_address'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'tambon'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_tambon" value="<?php echo $supplier_data['tambon'] ?>" />
                <?php echo form_error('txt_tambon'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'amphoe'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_amphoe" value="<?php echo $supplier_data['amphoe'] ?>" />
                <?php echo form_error('txt_amphoe'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'province'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_province" value="<?php echo $supplier_data['province'] ?>" />
                <?php echo form_error('txt_province'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'postalcode'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_postalcode" value="<?php echo $supplier_data['postalcode'] ?>" />
                <?php echo form_error('txt_postalcode'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'phone_number1'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_phone_number1" value="<?php echo $supplier_data['phone_number1'] ?>" />
                <?php echo form_error('txt_phone_number1'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'phone_number2'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_phone_number2" value="<?php echo $supplier_data['phone_number2'] ?>" />
                <?php echo form_error('txt_phone_number2'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'fax_number1'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_fax_number1" value="<?php echo $supplier_data['fax_number1'] ?>" />
                <?php echo form_error('txt_fax_number1'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'fax_number2'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_fax_number2" value="<?php echo $supplier_data['fax_number2'] ?>" />
                <?php echo form_error('txt_fax_number2'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'email'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_email" value="<?php echo $supplier_data['email'] ?>" />
                <?php echo form_error('txt_email'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'website'); ?></b>
            </div>
            <div id="form_row_control">
                <input type="text" name="txt_website" value="<?php echo $supplier_data['website'] ?>" />
                <?php echo form_error('txt_website'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'detail'); ?></b>
            </div>
            <div id="form_row_control">
                <textarea cols="30" rows="3" name="txt_detail"><?php echo $supplier_data['detail'] ?></textarea>
                <?php echo form_error('txt_detail'); ?>
            </div>
        </div>
        <div class="form_row">
            <div id="form_row_title">
                <b><?php echo get_field_lang('shop_supplier', 'add_date'); ?></b>
            </div>
            <div id="form_row_control">
                <?php echo $supplier_data['add_date'] ?>
            </div>
        </div>
        <div>
            <input type="submit" name="btn_add_supplier" value="เพิ่มผู้ผลิดสินค้า" />
        </div>
    </div>
    <div style="float: left;width: 530px;">
        <div>
            <b>ยอดค้างชำระ</b>
        </div>
        <div>
            <?php
                foreach($year as $y) {
                    $query_month = $this->db->query("SELECT DISTINCT MONTH(deliver_date) AS month FROM shop_purchase_item WHERE deliver_date IS NOT NULL AND YEAR(deliver_date)=? ORDER BY MONTH(deliver_date) ASC", array($y['year']));
                    $month = $query_month->result_array();

            ?>
            <div>
                <b>==ปี <?php echo $y['year']; ?>==</b>
            </div>
            <?php
                    foreach($month as $m) {
            ?>
            <div>
                <b>เดือน <?php echo $m['month']; ?></b>
            </div>
            <div>
                <?php
                    // หาเงินที่ต้องจ่ายทั้งหมด X
                    $query_all_money = $this->db->query("SELECT shop_purchase.supplier_id, shop_purchase.supplier_name,
                        shop_purchase_item.product_id, shop_product.name, shop_purchase_item.quantity, shop_purchase_item.price,
                        shop_purchase_item.deliver_date, shop_purchase_item.payment_price, shop_purchase_item.payment_date
                        FROM shop_purchase, shop_purchase_item, shop_product
                        WHERE shop_purchase.supplier_id=?
                        AND MONTH(shop_purchase_item.deliver_date)=?
                        AND YEAR(shop_purchase_item.deliver_date)=?
                        AND shop_product.id=shop_purchase_item.id
                        AND shop_purchase_item.purchase_id=shop_purchase.id
                        AND shop_purchase.status != 'cancel'", array($this->uri->segment(4),$m['month'],$y['year']));
                    $all_money = $query_all_money->result_array();
                    $count_all_money = 0;
                    foreach ($all_money as $am) {
                        $count_all_money += (float)$am['quantity'] * (float)$am['price'];
                    }
                    echo 'เงินทั้งหมดที่ต้องจ่าย = '.$count_all_money.'<br />';
                    // หาเงินที่จ่ายไปแล้ว Y
                    $query_pay_money = $this->db->query("SELECT shop_purchase.supplier_id, shop_purchase.supplier_name,
                        shop_purchase_item.product_id, shop_product.name, shop_purchase_item.quantity, shop_purchase_item.price,
                        shop_purchase_item.deliver_date, shop_purchase_item.payment_price, shop_purchase_item.payment_date
                        FROM shop_purchase, shop_purchase_item, shop_product
                        WHERE shop_purchase.supplier_id=?
                        AND shop_purchase_item.payment_price IS NOT NULL
                        AND shop_purchase_item.payment_date IS NOT NULL
                        AND MONTH(shop_purchase_item.deliver_date)=?
                        AND YEAR(shop_purchase_item.deliver_date)=?
                        AND shop_product.id=shop_purchase_item.id
                        AND shop_purchase_item.purchase_id=shop_purchase.id
                        AND shop_purchase.status != 'cancel'", array($this->uri->segment(4),$m['month'],$y['year']));
                    $pay_money = $query_pay_money->result_array();
                    $count_pay_money = 0;
                    foreach ($pay_money as $pm) {
                        $count_pay_money += (float)$pm['payment_price'];
                    }
                    echo 'เงินที่จ่ายไปแล้ว = '.$count_pay_money .'<br />';
                    echo 'ยอดค้างชำระที่ต้องจ่าย = ' . ($count_all_money - $count_pay_money);
                ?>
            </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>

</div>

 

<?php echo form_close(); ?>