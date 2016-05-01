<div class="cart-panel">
    <?php
        if(is_user_login()==true) {
            $total_item = 0;
            $total_price = 0;
            foreach ($this->cart->contents() as $item) {
                $total_item += (float)$item['qty'];
                $total_price += (float)$item['price']*(float)$item['qty'];
            }
    ?>
    <h3>สินค้าทั้งหมด <?php echo $total_item; ?> ชิ้น</h3>
    <div>
        <table>
            <tr>
                <th style="width: 250px;text-align: left;">
                    ชื่อสินค้า
                </th>
                <th style="width: 150px;text-align: left;">
                    จำนวน
                </th>
                <th style="width: 150px;text-align: left;">
                    ราคา (บาท)
                </th>
            </tr>
            <?php
                foreach ($this->cart->contents() as $item) {
            ?>
            <tr>
                <td>
                    <?php echo anchor('shop/product/'.$item['id'].'/'.$item['name'], $item['name']); ?>
                </td>
                <td>
                    <?php echo $item['qty']; ?>
                </td>
                <td>
                    <?php echo currency((float)$item['price']*(float)$item['qty']); ?>
                </td>
            </tr>
            <?php
                }
            ?>
            <tr>
                <td><b>รวม</b></td>
                <td></td>
                <td>
                    <h3>
                        <?php echo currency($total_price); ?>
                    </h3>
                </td>
            </tr>
        </table>
        <div>
            <?php echo anchor('shop/cart', 'แสดงตะกร้าสินค้า'); ?>
        </div>
    </div>
    <?php
        } else {
    ?>
    กรุณา <?php echo anchor('user/login', 'เข้าสู่ระบบ') ?> หรือ <?php echo anchor('user/register', 'สมัครสมาชิก') ?>
    <?php
        }
    ?>
</div>
<a class="cart-trigger" href="javascript:void(0);">ตะกร้าสินค้า</a>