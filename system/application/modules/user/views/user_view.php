<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>
<?php echo $page_breadcrumb; ?>
<?php
    $css_class = '';
    if($this->router->fetch_method()!='login' && $this->router->fetch_method()!='register' && $this->router->fetch_method()!='lost_password') {
        $css_class = 'right_colmn';
?>
<div class="left_colmn">
    <div class="section">
        <h4>User Menu</h4>
        <div class="glossymenu">
            <div>
                <?php echo anchor('user/profile', 'ข้อมูลส่วนตัว', array('class'=>'menuitem submenuheader')); ?>
            </div>
           <div class="submenu">
                <ul>
                    <li><?php echo anchor('user/add_address', 'เพิ่มที่อยู่'); ?></li>
                </ul>
            </div>
            <div>
                <?php echo anchor('user/edit_password', 'เปลี่ยนรหัสผ่าน', array('class'=>'menuitem submenuheader')); ?>
            </div>
            <div>
                <?php echo anchor('user/product', 'จัดการสินค้า', array('class'=>'menuitem submenuheader')); ?>
            </div>
            <?php
                $login_info = get_login_info();
                $user_data = $this->user_model->get_user('email', $login_info['email']);
                if($user_data['level']!='supplier') {
            ?>
           <div class="submenu">
                <ul>
                    <li><?php echo anchor('user/add_product', 'เพิ่มสินค้า'); ?></li>
                </ul>
            </div>
            <?php
                }
            ?>
            <div>
                <?php
                    $login_info = get_login_info();
                    $user_data = $this->user_model->get_user('email', $login_info['email']);
                    // หาจำนวนสินค้าที่ยังไมได้ตอบคำถาม
                    $query = $this->db->query("SELECT shop_product_qa.question
                        FROM shop_product_qa,shop_product
                        WHERE shop_product.owner_id=? AND
                        shop_product.owner_type='c2c' AND
                        shop_product.id=shop_product_qa.product_id AND
                        (shop_product_qa.answer='' OR shop_product_qa.answer IS NULL )", array($user_data['id']));
                    $num_qa = $query->num_rows();
                ?>
                <?php echo anchor('user/product_question', 'ตอบคำถามสินค้า ('.$num_qa.')', array('class'=>'menuitem submenuheader')); ?>
            </div>
            <div>
                <?php echo anchor('user/order', 'จัดการรายการสั่งซื้อ', array('class'=>'menuitem submenuheader')); ?>
            </div>
            <div>
                <?php echo anchor('user/send_payment', 'แจ้งการชำระเงิน', array('class'=>'menuitem submenuheader')); ?>
            </div>
        </div>
    </div>
</div>
<?php
    } else {
?>
<div class="left_colmn">
    <script src="<?php echo assets_template('estore/js/ddaccordion.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo assets_template('estore/js/acordin.js'); ?>" type="text/javascript"></script>
    <div class="section">
        <?php $this->load->view('shop/include/browse_category'); ?>
    </div>
</div>

<?php
    }
?>

<div class="right_colmn">
<?php $this->load->view($user_content); ?>
</div>