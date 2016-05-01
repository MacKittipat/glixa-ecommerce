<div>
    <?php echo form_open(current_url()); ?>
    <select name="ddl_supplier">
        <?php
            foreach($supplier_data as $supplier) {
        ?>
        <option>
            <?php echo $supplier['name']; ?>
        </option>
        <?php
            }
        ?>
    </select>
     สินค้า
     <input type="text" name="txt_product" />
     <input type="submit" name="btn_submit" value="Report" />
    <?php echo form_close(); ?>
</div>