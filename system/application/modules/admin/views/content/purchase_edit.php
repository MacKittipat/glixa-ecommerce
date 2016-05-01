<div>
    <?php echo form_open(current_url(), array('id'=>'frm_purchase')); ?>
    <div class="form_row">
        <div class="form_row_title">
            <b>
            <?php
                echo get_field_lang('shop_purchase', 'supplier_name');
            ?>
            </b>
        </div>
        <div class="form_row_control">
        <?php echo $purchase_data['supplier_name']; ?>
        </div>
    </div>
    <div class="form_row">
        <div class="form_row_title">
            <b>
            <?php
                echo get_field_lang('shop_purchase', 'status');
            ?>
            </b>
        </div>
        <div class="form_row_control">
                <?php
                    if($purchase_data['status'] == 'no_receive') {
                        echo "ยังไม่ได้รับสินค้า";
                    } else if ($purchase_data['status'] == 'partial_receive') {
                        echo "รับสินค้าบางส่วน";
                    } else if ($purchase_data['status'] == 'all_receive') {
                        echo "รับสินค้าหมดแล้ว";
                    } else if ($purchase_data['status'] == 'cancel') {
                        echo "ยกเลิก";
                    } else if ($purchase_data['status'] == 'close') {
                        echo "ปิดใบสั่งซื้อ";
                    }
                ?>
        </div>
    </div>
    <div class="datatable">
        <table id="datatable_table" border="1">
            <thead>
                <tr>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'product_id'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'quantity'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'price'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'deliver_date'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'payment_price'); ?>
                    </th>
                    <th>
                        <?php echo get_field_lang('shop_purchase_item', 'payment_date'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($purchase_item_data as $product) {
                    $product_data = $this->product_model->get_product('id', $product['product_id']);
                ?>
                <tr>
                    <td>
                        <?php echo $product_data['name']; ?>
                        <input type="hidden" name="hid_product[]" value="<?php echo $product_data['id']; ?>"   />
                    </td>
                    <td>
                        <input type="text" style="width: 100px;" name="txt_quantity[]" value="<?php echo $product['quantity']; ?>" <?php echo ($product['deliver_date']!='') ? 'readonly' : ''; ?> />
                    </td>
                    <td>
                        <input type="text" style="width: 100px;" name="txt_price[]" value="<?php echo currency($product['price']); ?>" <?php echo ($product['deliver_date']!='') ? 'readonly' : ''; ?> />
                    </td>
                    <td>
                        <input type="text" style="width: 100px;" name="txt_deliver_date[]" class="datepicker" value="<?php echo $product['deliver_date']; ?>" <?php echo ($product['deliver_date']!='') ? 'readonly' : ''; ?> />
                    </td>
                    <td>
                        <input type="text" style="width: 100px;" name="txt_payment_price[]" value="<?php echo ($product['payment_price']!='') ? currency($product['payment_price']) : ''; ?>" />
                    </td>
                    <td>
                        <input type="text" style="width: 100px;" name="txt_payment_date[]" class="datepicker" value="<?php echo $product['payment_date']; ?>" />
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if($purchase_data['status']!='cancel' && $purchase_data['status']!='close') {
    ?>
    <div class="form_row">
        <input type="hidden" name="hid_action" id="hid_action" value="" />
        <input type="button" name="btn_submit" id="btn_submit" onclick="submits('submit');"  value="บันทึก" />
        <input type="button" name="btn_cancel" id="btn_cancel" onclick="submits('cancel');" value="ยกเลิกใบสั่งซื้อ" />
        <input type="button" name="btn_close" id="btn_close" onclick="submits('close');" value="ปิดใบสั่งซื้อ" />
    </div>
    <?php
        }
    ?>
    <?php echo form_close(); ?>
</div>
<link rel="stylesheet" href="<?php echo assets_js('datepicker/css/ui-lightness/jquery-ui-1.8.5.custom.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('datepicker/js/jquery-ui-1.8.5.custom.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
             dateFormat: 'yy-mm-dd'
        });
    });
    function submits(action) {
        $("#hid_action").val(action);
        $("#frm_purchase").submit();
    }
</script>