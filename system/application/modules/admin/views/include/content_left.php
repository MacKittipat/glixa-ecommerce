<?php
    $unapprove_review = count($this->product_review_model->get_product_review('','','AND approve=0'));
    $unapprove_media = count($this->product_media_model->get_product_media('','','AND approve=0'));
    $unapprove_qa = count($this->product_qa_model->get_product_qa('','','AND approve=0'));
?>
<div id="left_menu">
    <ul style="margin: 0px 0px 0px 18px;padding: 0;">
        <li>
            <?php echo anchor('admin', 'ผู้ดูแลระบบ'); ?>
        </li>
        <li>
            <?php echo anchor('admin/user', 'สมาชิก'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product_category_top', 'ประเภทสินค้าระดับบนสุด'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product_category', 'ประเภทสินค้า'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product', 'สินค้า'); ?>
        </li>
        <li>
            <?php echo anchor('admin/promotion', 'โปรโมชั่น'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product_review', 'รีวิวสินค้า ('.$unapprove_review.')'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product_media', 'วิดีโอสินค้า ('.$unapprove_media.')'); ?>
        </li>
        <li>
            <?php echo anchor('admin/product_qa', 'คำถามสินค้า ('.$unapprove_qa.')'); ?>
        </li>
        <li>
            <?php echo anchor('admin/order', 'รายการสั่งซื้อ'); ?>
        </li>
        <li>
            <?php echo anchor('admin/payment', 'แจ้งการชำระเงิน'); ?>
        </li>
        <li>
            <?php echo anchor('admin/supplier', 'ผู้ผลิตสินค้า'); ?>
        </li>
        <li>
            <?php echo anchor('admin/purchase', 'ใบสั่งของ'); ?>
        </li>
        <li>
            <?php echo anchor('admin/report/inventory_start_up', 'รายงาน inventory start up'); ?>
        </li>
    </ul>
</div>
