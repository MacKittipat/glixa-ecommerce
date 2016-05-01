<!--
<link rel="stylesheet" type="text/css" href="<?php echo assets_js('sliding-cart/sliding-cart.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('sliding-cart/sliding-cart.js'); ?>"></script>
-->
<script src="<?php echo assets_template('estore/js/ddaccordion.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_template('estore/js/acordin.js'); ?>" type="text/javascript"></script>
<?php echo $page_breadcrumb; ?>
<div class="left_colmn">
    <?php
        if($this->router->fetch_method()=='user') {
            // ตรวจสอบว่า user มีสินค้าหรือไม่ ถ้าไม่มีจะ contact ไม่ได้
            $user_contact_data = $this->user_model->get_user('username',$user_data['username']);
            $user_product_data = $this->product_model->get_product('','','AND owner_id="'.$user_contact_data['id'].'" AND owner_type="c2c"');
            if(count($user_product_data)>0) {
    ?>
    <div class="section">
        <h4>CONTACT</h4>
        <div class="glossymenu">
            <div>
                <?php echo anchor('shop/contact/'.$user_data['username'], 'ติดต่อสั่งซื้อ', array('class'=>'menuitem')); ?>
            </div>
        </div>
    </div>
    <?php
            }
        }
    ?>
    <!-- Categories Section -->
    <div class="section">
        <?php $this->load->view('shop/include/browse_category'); ?>
    </div>
    <div class="section">
        <?php $this->load->view('shop/include/search_product'); ?>
    </div>
    <?php
        if($this->router->fetch_method()=='glixa_guarantee') {
    ?>
    <div class="section">
        <h4>HELP</h4>
        <div class="glossymenu">
            <div>
                <?php echo anchor('payment_detail', 'วิธีการชำระเงิน', array('class'=>'menuitem')); ?>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>
<div class="right_colmn">
    <?php $this->load->view($shop_content); ?>
</div>
<?php //$this->load->view('shop/include/sliding_cart'); ?>



