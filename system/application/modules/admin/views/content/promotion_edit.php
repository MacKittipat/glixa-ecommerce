<link rel="stylesheet" href="<?php echo assets_js('datepicker/css/ui-lightness/jquery-ui-1.8.5.custom.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('datepicker/js/jquery-ui-1.8.5.custom.min.js'); ?>"></script>
<?php echo form_open(current_url()); ?>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_promotion', 'name'); ?></b>
    </div>
    <div id="form_row_control">
        <input type="text" name="txt_name" value="<?php echo $promotion_data['name'] ?>" />
        <?php echo form_error('txt_name'); ?>
    </div>
</div>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_promotion', 'description'); ?></b>
    </div>
    <div id="form_row_control">
        <textarea name="txt_description"><?php echo $promotion_data['detail'] ?></textarea>
    </div>
</div>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_promotion', 'real_price'); ?></b>
    </div>
    <div id="form_row_control">
        <input type="text" name="txt_real_price" value="<?php echo $promotion_data['cost'] ?>" />
        <?php echo form_error('txt_real_price'); ?>
    </div>
</div>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_promotion', 'pro_price'); ?></b>
    </div>
    <div id="form_row_control">
        <input type="text" name="txt_pro_price" value="<?php echo $promotion_data['price'] ?>" />
        <?php echo form_error('txt_pro_price'); ?>
    </div>
</div>
<div class="form_row">
    <div id="form_row_title">
        <b><?php echo get_field_lang('shop_promotion', 'end_date'); ?></b>
    </div>
    <div id="form_row_control">
        <input type="text" id="txt_end_date" name="txt_end_date" value="<?php echo $promotion_data['end_date'] ?>" />
        <?php echo form_error('txt_end_date'); ?>
    </div>
</div>
<div class="form_row">
    <div id="form_row_title">
        <b>สินค้า (กรอก id ของสินค้าคั่นด้วย , เช่น 12,44,66)</b>
    </div>
    <div id="form_row_control">
        <input type="text" id="txt_end_date" name="txt_product" value="<?php echo $csv_product; ?>" />
        <?php echo form_error('txt_product'); ?>
    </div>
</div>
<div class="form_row">
    <input type="submit" name="btn_submit" value="เพิ่มโปรโมชั่น" />
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#txt_end_date').datepicker({
             dateFormat: 'yy-mm-dd'
        });
    });
</script>