<h4>Search</h4>
<div id="search">
    <?php
        echo form_open('shop/search', array('id'=>'frm_search_product','method'=>'get'));
        $category_data = $this->product_category_model->get_product_category('', '', 'AND product_category_id IS NULL');
    ?>
    <div class="form_row">
        <select name="c" id="ddl_category">

            <option value="all">
                ทุกประเภท
            </option>
            <?php
                foreach($category_data as $value) {
                    $sub_category_data = $this->product_category_model->get_product_category('','','AND product_category_id="'.$value['id'].'"');
            ?>
            <optgroup label="<?php echo $value['name']; ?>" style="font-family: Tahoma;">
                <?php
                    foreach($sub_category_data as $sub_cat) {
                ?>
                <option value="<?php echo $sub_cat['id']; ?>">
                    <?php echo $sub_cat['name']; ?>
                </option>
                <?php
                    }
                ?>
            </optgroup>
            <?php
                }
            ?>
        </select>
    </div>
    <div class="form_row">
        <div>
            <b>ราคา</b>
        </div>
        <input type="text" class="txtx" name="s" id="txt_price_start" style="width: 88px;" /> -
        <input type="text" class="txtx" name="e" id="txt_price_end" style="width: 88px;" />
    </div>
    <div class="form_row">
        <div>
            <b>คีย์เวิร์ด</b>
        </div>
        <input type="text" class="txtx" name="q" id="txt_search" style="width: 195px;" />
    </div>
    <div class="form_row">
        <select name="g" id="ddl_guarantee">
            <option value="all">ทั่งหมด</option>
            <option value="guarantee">Glixa Guarantee</option>
            <option value="shopping">Third Party</option>
        </select>
    </div>
    <div class="form_row">
        
        <input type="submit" name="search" value="ค้นหา" />
        <!--
        <a onclick="javascript:$(this).parent().parent('#frm_search_product').submit();" class="button" href="#">
            <span>ค้นหา</span>
        </a>
        -->
    </div>
    <?php echo form_close(); ?>
</div>
