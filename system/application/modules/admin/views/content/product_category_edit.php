<?php
    echo form_open(current_url());
    echo create_form_key();
?>
<div>
    <div>
        <b>
            <?php echo get_field_lang('shop_product_category', 'category_code'); ?>
        </b>
    </div>
    <div>
        <input type="text" name="txt_category_code" value="<?php echo $product_category_data['category_code'] ?>" />
        <?php echo form_error("txt_category_code"); ?>
    </div>
</div>
<div>
    <div>
        <b>
            <?php echo get_field_lang('shop_product_category', 'name'); ?>
        </b>
    </div>
    <div>
        <input type="text" name="txt_name" value="<?php echo $product_category_data['name'] ?>" />
        <?php echo form_error("txt_name"); ?>
    </div>
</div>
<?php
    if($product_category_data['product_category_id']!='') {
?>
<div>
    <div>
        <b>
            <?php echo get_field_lang('shop_product_category', 'product_category_id'); ?>
        </b>
    </div>
    <div>
        <select name="ddl_product_categoty_id">
        <?php
            $parent_category_data = $this->product_category_model->get_product_category('id', $product_category_data['product_category_id']);
            foreach ($parent_category_all_data as $key => $value) {
                $selected = '';
                if($value['id']==$parent_category_data['id']) {
                    $selected = 'selected';
                }
        ?>
            <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?> >
                <?php echo $value['name']; ?>
            </option>
        <?php
            }
        ?>        
        </select>
    </div>

</div>
<?php
    } else {
?>
    <div>
        <div>
            <b>ประเภทสินค้าระดับนสุด</b>
        </div>
        <div>
            <select name="ddl_product_categoty_top_id">
                <option value="0">
                    == เลือก ประเภทสินค้าระดับบนสุด ==
                </option>
            <?php
                foreach($top_category as $top_cate) {
            ?>
                <option value="<?php echo $top_cate['id']; ?>" <?php echo ($product_category_data['product_category_top_id']==$top_cate['id']) ? 'selected' : ''; ?>>
                    <?php echo $top_cate['name']; ?>
                </option>
            <?php
                }
            ?>
            </select>
        </div>
    </div>
<?php
    }
?>
<div>
    <input type="submit" name="btn_edit_category" id="btn_edit_category" value="บันทึก" />
</div>
<?php echo form_close(); ?>    