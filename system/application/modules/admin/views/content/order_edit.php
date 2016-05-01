<div>
    <h2>
        ข้อมูลรายการสั่งซื้อ
    </h2>
    <div class="form_row">
        <div id="form_row_title">
            <b>หมายเลข Order</b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo order_number(get_year($order_data['order_date']), get_month($order_data['order_date']), $order_data['id']); ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'order_date'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $order_data['order_date']; ?>
            </div>
        </div>
    </div>
    <!--
    <div class="form_row">
        <div id="form_row_title">
           <b><?php echo get_field_lang('shop_order', 'payment_date'); ?> แก้เป็นวันที่ส่งของ</b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo form_open(current_url()); ?>
                <input type="text" id="datepicker" name="txt_payment_date" value="<?php echo $order_data['payment_date']; ?>" />
                <input type="submit" name="btn_submit_payment_date" value="Save" />
                <input type="hidden" name="hid_field" value="payment_date" />
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    -->
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'status'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo form_open(current_url(), array('id'=>'frm_edit_status')); ?>
                <input type="hidden" name="hid_field" value="status"  />
                <select name="ddl_status" id="ddl_status" <?php echo ($order_data['status']!='wait') ? 'disabled' : ''; ?>>
                    <?php
                        if($order_data['status']=='wait') {
                    ?>
                    <option value="wait">รอชำระเงิน</option>
                    <option value="paid">ชำระเงินแล้ว</option>
                    <?php
                        } else {
                    ?>
                    <option value="paid" <?php echo ($order_data['status']=='paid') ? "selected" : ""; ?>>ชำระเงินแล้ว</option>
                    <option value="partial_send" <?php echo ($order_data['status']=='partial_send') ? "selected" : ""; ?>>ส่งของบางส่วนแล้ว</option>
                    <option value="send" <?php echo ($order_data['status']=='send') ? "selected" : ""; ?>>ส่งของแล้ว</option>
                    <?php
                        }
                    ?>
                </select>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'shipping_method'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $order_data['shipping_method']; ?>
            </div>
        </div>
    </div>
    <h2>
        ข้อมูลสินค้า
    </h2>
    <?php echo form_open(current_url()); ?>
    <input type="hidden" name="hid_field" value="lot" />
    <div style="width: 835px;overflow: auto;">
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>
                        <?php echo get_field_lang('shop_product', 'name'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_product', 'quantity'); ?>
                    </th>
                    <th>
                        รวมราคา (บาท)
                    </th>
                    <?php
                        if($order_data['status']!='wait') {
                    ?>
                    <th>
                        Lot
                    </th>
                    <!--
                    <th>
                        Tracking Code
                    </th>
                    -->
                    <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
            <?php
                $total_price = 0;
                foreach($order_item_data as $item) {
                    $product_data = $this->product_model->get_product('id', $item['product_id']);
            ?>
                <tr>
                    <td style="vertical-align: top;">
                        <?php echo anchor('admin/product/edit/'.$product_data['id'], $product_data['name']); ?>
                    </td>
                    <td style="vertical-align: top;">
                        <input type="hidden" name="hid_order_item_qty[]" value="<?php echo $item['quantity']; ?>" />
                        <?php echo $item['quantity'].' '.$product_data['unit']; ?>
                    </td>
                    <td style="vertical-align: top;">
                        <?php
                            $p = (float)$item['quantity']*(float)$product_data['price'];
                            $total_price += (float)$item['quantity']*(float)$product_data['price'];
                            echo currency($p);
                        ?>
                    </td>
                    <?php
                        if($order_data['status']!='wait') {
                            // เลือก lot อันที่มีจำนวนมากกว่าหรือเท่ากับจำนวนสินค้าที่ขาย
                            $lot_data = $this->product_lot_model->get_product_lot('','','AND product_id="'.$product_data['id'].'" AND quantity>="'.$item['quantity'].'"');
                    ?>
                    <td>
                        <div class="lot" >
                            <div>
                                <div>
                                    <input type="hidden" name="hid_order_item_id[]" value="<?php echo $item['id']; ?>" />
                                    <select name="ddl_lot[]" class="form_row">
                                        <option value="false">
                                            == เลือก lot ==
                                        </option>
                                        <?php
                                            foreach($lot_data as $lot) {
                                        ?>
                                        <option value="<?php echo $lot['id']; ?>" <?php echo ($item['lot_id']==$lot['id']) ? "selected" : ''; ?>>
                                            <?php echo $item['lot_id'].'lot id '.$lot['id'].' จำนวน '.$lot['quantity']; ?>
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <div>
                                        Code <input type="text" name="txt_code[]" value="<?php echo ($item['tracking_code']!='' ? $item['tracking_code'] : ''); ?>" />
                                    </div>
                                    <div>
                                        Remark <input type="text" name="txt_remark[]" value="<?php echo ($item['remark']!='' ? $item['remark'] : ''); ?>" />
                                    </div>
                                </div>
                                <!--
                                <table border="0" style="border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            จำนวน
                                        </td>
                                        <td>
                                            <input type="text" name="txt_qty[]" style="width: 120px;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Code
                                        </td>
                                        <td>
                                            <input type="text" name="txt_trac[]" style="width: 120px;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            วันที่ส่ง
                                        </td>
                                        <td>
                                            <input type="text" name="txt_deliver[]" class="datetime" style="width: 120px;" />
                                        </td>
                                    </tr>
                                </table>
                                <div>
                                    <a href="javascript:void(0);" class="del_lot_panel" onclick="$(this).parent().parent().parent().remove();">ลบ</a>
                                </div>
                                -->
                            </div>
                        </div>
                        <!--
                        <a href="javascript:void(0);" class="btn_add_lot">
                            เพิ่ม
                        </a>
                        -->
                    </td>
                    <!--
                    <td>
                        <input type="text" name="txt_tracking_code[]" value="<?php echo $item['tracking_code']; ?>" />
                    </td>
                    -->
                    <?php
                        }
                    ?>
                </tr>
            <?php
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">ราคาทั้งหมด</td>
                    <td colspan="<?php echo ($order_data['status']!='wait') ? '2' : '1'; ?>"><?php echo currency($total_price); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <input type="submit" name="btn_submit_lot" value="บันทึก" />
    <?php echo form_close(); ?>
    <h2>ข้อมูลผู้สั่งซื้อ</h2>
    <?php
        $user_data = $this->user_model->get_user('id', $order_data['user_id']);
    ?>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('wive_user', 'firstname').'-'.get_field_lang('wive_user', 'lastname'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo anchor('admin/user/profile/'.$user_data['id'], $user_data['firstname'].' '.$user_data['lastname']); ?>
            </div>
        </div>
    </div>
    <h2>ข้อมูลผู้ชำระเงิน</h2>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'firstname').'-'.get_field_lang('wive_user', 'lastname'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $billing_data['firstname'].' ',$billing_data['lastname']; ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'address'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php 
                    echo $billing_data['address'].' ';
                    echo $billing_data['tambon'].' ';
                    echo $billing_data['amphoe'].' ';
                    echo $billing_data['province'].' ';
                    echo $billing_data['postalcode'].' ';
                ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'tel_num'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $billing_data['tel_num']; ?>
            </div>
        </div>
    </div>
    <?php
        if($billing_data['fax_num']!='') {
    ?>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'fax_num'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $billing_data['fax_num']; ?>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
    <h2>ข้อมูลผู้รับสินค้า</h2>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'firstname').'-'.get_field_lang('wive_user', 'lastname'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $shipping_data['firstname'].' ',$shipping_data['lastname']; ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'address'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php
                    echo $shipping_data['address'].' ';
                    echo $shipping_data['tambon'].' ';
                    echo $shipping_data['amphoe'].' ';
                    echo $shipping_data['province'].' ';
                    echo $shipping_data['postalcode'].' ';
                ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'tel_num'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $shipping_data['tel_num']; ?>
            </div>
        </div>
    </div>
    <?php
        if($billing_data['fax_num']!='') {
    ?>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_user_address', 'fax_num'); ?></b>
        </div>
        <div id="form_row_control">
            <div>
                <?php echo $shipping_data['fax_num']; ?>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<link rel="stylesheet" href="<?php echo assets_js('datepicker/css/ui-lightness/jquery-ui-1.8.5.custom.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('datepicker/js/jquery-ui-1.8.5.custom.min.js'); ?>"></script>
<script type="text/javascript">
    var lot_panel = $(".lot").html();
    $(document).ready(function() {
        $('.datetime').datepicker({
             dateFormat: 'yy-mm-dd'
        });
        $("#ddl_status").change(function() {
            $("#frm_edit_status").submit();
        });
    });
    $(".btn_add_lot").click(function() {
        //alert($(this).prev().clone().html());
        $(this).before($(this).prev(".lot").clone());
        $(".datetime").datepicker({
             dateFormat: 'yy-mm-dd'
        });
    });
</script>