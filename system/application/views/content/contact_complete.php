<script src="<?php echo assets_template('estore/js/ddaccordion.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_template('estore/js/acordin.js'); ?>" type="text/javascript"></script>
<div class="left_colmn">
    <!-- Categories Section -->
    <div class="section">
        <?php $this->load->view('shop/include/browse_category'); ?>
    </div>
</div>
<div class="right_colmn">
    <h2 class="heading">
        <?php echo $page_title; ?>
    </h2>
    <?php echo form_open('contact'); ?>
    <div class="gre_sec">
        <h3><a href="<?php echo base_url();?>"><span style="color: #A2422C;"><b>Glixa</b></span></a>จะติดต่อท่านภายใน 24 ชั่วโมง</h3>
        <div style="padding-left: 20px;">
            ขอบพระคุณที่ท่านให้ความไว้วางใจ <a href="<?php echo base_url();?>"><span style="color: #A2422C;"><b>Glixa</b></span></a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
