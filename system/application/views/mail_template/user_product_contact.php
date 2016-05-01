<div style="font-size: small;">
    <div>
        ติดต่อสั่งซื้อสินค้า <?php echo anchor('shop/product/'.$product['id'].'/'.$product['name'], $product['name']); ?>
    </div>
    <div>
        จำนวน <?php echo $qty; ?>
    </div>
    <div>
        รายละเอียด <?php echo $detail; ?>
    </div>
    <div>
        ติดต่อกลับที่ <?php echo $sender_mail; ?>
    </div>
</div>