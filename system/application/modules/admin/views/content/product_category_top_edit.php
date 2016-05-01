<?php
    echo form_open(current_url());
    echo create_form_key();
?>
<div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('shop_product_category', 'category_code'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_category_code" value="<?php echo $product_cat_top['category_code']; ?>" />
            <?php echo form_error('txt_category_code'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('shop_product_category', 'name'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_name" value="<?php echo $product_cat_top['name']; ?>" />
            <?php echo form_error('txt_name'); ?>
        </div>
    </div>
</div>
<div>
    <input type="submit" name="btn_add_category" value="บันทึก" />
</div>
<?php echo form_close(); ?>
