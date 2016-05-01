<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    if($owner_type=='c2c') { // c2c
?>
<div>
    <table border="1" class="table">
        <thead>
            <tr>
                <th>
                    รหัสรายการสั่งซื้อ
                </th>
                <th>
                    <?php echo get_field_lang('shop_order', 'order_date'); ?>
                </th>
                <th>
                    <?php echo get_field_lang('shop_order', 'status'); ?>
                </th>
                <th>
                    ราคารวม (บาท)
                </th>
                <th>
                    ยกเลิกการสั่งซื้อ
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($order_data as $order) {
                    $total_price = 0;
                    $order_item_data = $this->order_item_model->get_order_item('','', 'AND order_id="'.$order['id'].'"');
//                    foreach($order_item_data as $order_item) {
//                        $product_data = $this->product_model->get_product('id',$order_item['product_id']);
//                        $p = (float)$product_data['price']*(int)$order_item['quantity'];
//                        $total_price += $p;
//                    }
            ?>
            <tr>
                <td>
                    <?php echo anchor('user/view_order/'.$order['id'] ,order_number(get_year($order['order_date']), get_month($order['order_date']), $order['id'])); ?>
                </td>
                <td>
                    <?php echo $order['order_date']; ?>
                </td>
                <td>
                <?php
                    if($order['status']=='wait') {
                        echo 'รอชำระเงิน';
                    } else if($order['status']=='paid') {
                        echo 'ชำระเงินแล้ว';
                    } else if($order['status']=='send') {
                        echo 'ส่งของแล้ว';
                    }
                ?>
                </td>
                <td>
                    <?php
                    echo currency($order['total_price']);
                    //echo currency($total_price); ?>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="del_order(<?php echo $order['id']; ?>);">
                        ยกเลิก
                    </a>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<?php
    } else { // b2c
?>
<div>
    <table border="1" class="table">
        <thead>
            <tr>
                <th>
                    <?php echo get_field_lang('shop_order', 'order_date'); ?>
                </th>
                <th>
                    <?php echo get_field_lang('shop_product', 'name'); ?>
                </th>
                <th>
                    <?php echo get_field_lang('shop_order', 'status'); ?>
                </th>
                <th>
                    <?php echo get_field_lang('shop_order_item', 'quantity'); ?>
                </th>
                <th>
                    รวม
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            
                foreach($order_data as $value) {
                    $product_data = $this->product_model->get_product('id',$value['product_id']);
                    $order_data = $this->order_model->get_order('id',$value['order_id']);
                    $order_item_data = $this->order_item_model->get_order_item('id', $value['id']);
                    if($order_data!=null && $order_item_data!=null) {
            ?>
            <tr>
                <td>
                    <?php echo $order_data['order_date']; ?>
                </td>
                <td>
                    <?php echo anchor('shop/product/'.$product_data['id'].'/'.$product_data['name'],$product_data['name']); ?>
                </td>
                <td>
                    <?php
                        if($order_data['status']=='wait') {
                            echo 'รอชำระเงิน';
                        } else if($order_data['status']=='paid') {
                            echo 'ชำระเงินแล้ว';
                        } else {
                            echo 'ส่งของแล้ว';
                        }
                    ?>
                </td>
                <td>
                    <?php echo $order_item_data['quantity'].' '.$product_data['unit']; ?>
                </td>
                <td>
                    <?php echo currency((float)$order_item_data['quantity']*(float)$product_data['cost']); ?>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>

</div>
<?php
    }
?>
<?php echo $pagination; ?>
<script type="text/javascript">
    function del_order(id) {
        if(confirm("คุณต้องการลบรายการสินค้านี้ใช่หรือไม่")==true) {
            window.location = "<?php echo base_url() ?>user/del_order/"+id;
        }
    }
</script>
