<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    if($this->cart->total()>0) {
?>
<div>
    <?php echo form_open('shop/update_cart', array('id'=>'frm_cart')); ?>
    <table class="table_data" border="1">
        <thead>
            <tr>
                <th style="width: 200px;">
                    ชื่อสินค้า
                </th>
                <th style="width: 120px;">
                    ราคาต่อ 1 หน่วย
                </th>
                <th style="width: 150px;">
                    จำนวน
                </th>
                <th style="width: 120px;">
                    ราคารวม (บาท)
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total_price = 0;
                foreach($cart_item as $item) {
            ?>
                <tr>
                    <td>
                        <div>
                            <?php echo anchor('shop/product/'.$item['id'].'/'.$item['name'], $item['name']); ?>
                        </div>
                        <?php
                            if(isset($item['options'])) {
                        ?>
                        <div>
                            <?php
                                foreach($item['options'] as $key => $value) {
                            ?>
                            <div>
                                <?php echo $key; ?> : <?php echo $value; ?>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php
                            }
                        ?>
                    </td>
                    <td>
                        <?php echo $item['price']; ?>
                    </td>
                    <td>
                        <input type="hidden" name="hid_pid[]" value="<?php echo $item['id']; ?>" />
                        <input type="hidden" name="hid_rowid[]" value="<?php echo $item['rowid']; ?>" />
                        <input type="text" class="txt" name="txt_quality[]" value="<?php echo $item['qty']; ?>" style="width: 100px;" />
                        <a href="javascript:void(0);" onclick="del_cart('<?php echo $item['rowid'] ?>');">
                            <img src="<?php echo assets_image('remove.png'); ?>" alt="ลบ" title="ลบ" />
                        </a>
                    </td>
                    <td>
                        <?php echo currency((float)$item['price']*(float)$item['qty']); ?>
                    </td>
                </tr>
            <?php
                    $total_price += (float)$item['price']*(float)$item['qty'];
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">ราคารวมทั้งหมด</td>
                <td>
                    <span style="font-weight: bolder;"><?php echo currency($total_price); ?></span>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="form_row" style="margin-top: 10px;">
        <a href='javascript:$("#frm_cart").submit();' class="button">
            <span>อัปเดท</span>
        </a>
        <?php echo anchor('shop/checkout', '<span>ชำระเงิน</span>', array('class'=>'button')); ?>
    </div>
    <?php echo form_close(); ?>
</div>
<?php
    } else {
?>
<div>
    <span style="font-weight: bolder;">
        ยังไม่มีสินค้าในตะกร้า คุณสามารถเลือกซื้อสินค้าของเราได้ <?php echo anchor('shop/glixa_guarantee', 'ที่นี่'); ?>
    </span>
</div>
<?php
    }
?>

<script type="text/javascript">
    function del_cart(id) {
        window.location = "<?php echo base_url().'shop/del_cart/'; ?>" + id;
    }
</script>