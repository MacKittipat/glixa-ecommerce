<div>
    <h2 class="heading">ข้อมูลรายการสินค้า</h2>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'order_date'); ?></b>
        </div>
        <div id="form_row_control">
            <?php echo $order_data['order_date']; ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'status'); ?></b>
        </div>
        <div id="form_row_control">
        <?php
            if($order_data['status']=='wait') {
                echo 'รอชำระเงิน';
            } else if($order_data['status']=='paid') {
                echo 'ชำระเงินแล้ว';
            } else if($order_data['status']=='send') {
                echo 'ส่งของแล้ว';
            }
        ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_order', 'shipping_method'); ?></b>
        </div>
        <div id="form_row_control">
            <?php echo $order_data['shipping_method']; ?>
        </div>
    </div>
    <h2 class="heading">ข้อมูลสินค้า</h2>
    <table border="1" class="table">
        <thead>
            <tr>
                <th>
                    <?php echo get_field_lang('shop_order_item', 'product_id'); ?>
                </th>
                <th>
                    <?php echo get_field_lang('shop_product', 'quantity'); ?>
                </th>
                <th>
                    ราคา (บาท)
                </th>
            </tr>
        </thead>
        <tbody>
    <?php
        $total_price = 0;
        foreach($order_item_data as $order_item) {
            $product_data = $this->product_model->get_product('id',$order_item['product_id']);
    ?>
            <tr>
                <td>
                    <?php echo anchor('shop/product/'.$product_data['id'],$product_data['name']); ?>
                </td>
                <td>
                    <?php echo $order_item['quantity'].' '.$product_data['unit']; ?>
                </td>
                <td>
                    <?php echo currency((float)$product_data['price']*(float)$order_item['quantity']);  ?>
                </td>
            </tr>
    <?php
            $p = (float)$product_data['price']*(int)$order_item['quantity'];
            $total_price += $p;
        }
    ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    ค่าขนส่ง 
                </td>
                <td>
                    <?php
                        if($order_data['shipping_method']=='mail' && $total_price<100) {
                            echo currency(20);
                        } else if($order_data['shipping_method']=='ems' && $total_price<1000) {
                            echo currency(30);
                        } else {
                            echo currency(0);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>ราคารวม</b></td>
                <td>
                    <?php
                        echo currency($order_data['total_price']);
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>