<div style="font-size: small;">
    <div>เรียน <?php echo $supplier['name']; ?></div>
    <div>
        สินค้าของท่านได้ถูกจำหน่ายดังนี้
    </div>
    <table border="1" style="border-collapse: collapse;">
        <tr>
            <th style="padding: 5px 5px 5px 5px;">
                ชื่อสินค้า
            </th>
            <th style="padding: 5px 5px 5px 5px;">
                จำนวน
            </th>
        </tr>
    <?php
        foreach($product as $p) {
    ?>
            <tr>
                <td style="padding: 5px 5px 5px 5px;">
                    <?php echo $p['name']; ?>
                </td>
                <td style="padding: 5px 5px 5px 5px;">
                    <?php echo $p['quantity']; ?>
                </td>
            </tr>
    <?php
        }
    ?>
    </table>
</div>