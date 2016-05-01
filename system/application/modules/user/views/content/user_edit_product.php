<script type="text/javascript" src="<?php echo assets_js('ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('ckeditor/adapters/jquery.js'); ?>"></script>
<script type="text/javascript">
    var i=<?php echo count($product_gallery_data); ?>;
    $(document).ready(function(){
        $(".cke").ckeditor({
            toolbar: [
                ['Source','-','NewPage','Preview'],
                ['Cut','Copy','Paste','PasteText','PasteFromWord'],
                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                '/',
                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                ['NumberedList','BulletedList','-','Outdent','Indent'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['Link','Unlink','Anchor'],
                '/',
                ['TextColor','BGColor'],
                ['Image','Format'],
            ],
            width: 500,
            forcePasteAsPlainText: true
        });
    });
    function add_image_gallery() {
        if(i<7) {
            $(".form_row_gallery").append("<div><input type='file' name='txt_gallery[]' /> <a href='javascript:void(0);' onclick='del_image_gallery(this)'>ลบ</a></div>");
            i++;
        }
    }
    function del_image_gallery(th) {
        i--;
        $(th).parent().remove();
    }
</script>
<?php 
    if(isset($message)) {
        echo $message;
    }
?>
<?php
    echo form_open_multipart('user/edit_product/'.$product_data['id']);
    echo create_form_key();
?>
<div class="gre_sec">
    <h3>
        กรอกข้อมูลสินค้าของท่าน
    </h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'product_category_id'); ?>
        </li>
        <li class="inputfield">
            <select name="ddl_product_category_id" style="width: 200px;">
                <?php
                    foreach($product_category_data as $value) {
                        $p_product_category = $this->product_category_model->get_product_category('','','AND product_category_id="'.$value['id'].'"');
                        
//if($product_data['product_category_id']==$value['id']) {
                ?>
                <optgroup label="<?php echo $value['name']; ?>" style="font-family: Tahoma;">
                    <?php
                        foreach($p_product_category as $sub_cat) {
                            if($product_data['product_category_id']==$sub_cat['id']) {
                    ?>
                    <option value="<?php echo $sub_cat['id']; ?>" selected>
                        <?php echo $sub_cat['name']; ?>
                    </option>
                    <?php
                            } else {
                    ?>
                    <option value="<?php echo $sub_cat['id']; ?>">
                        <?php echo $sub_cat['name']; ?>
                    </option>
                    <?php
                            }
                    ?>
                    <?php
                        }
                    ?>
                </optgroup>
                <?php
                        
                    }
                ?>
            </select>
        </li>
    </ul>
    <div class="clear"></div>

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'type'); ?>
        </li>
        <li class="inputfield">
            <select name="ddl_type">
                <option value="null"
                        <?php
                            if($product_data['type']=='') {
                                echo "selected";
                            }
                        ?>
                        >
                    == เลือกสภาพสินค้า ==
                </option>
                <option value="new"
                        <?php
                            if($product_data['type']=='new') {
                                echo "selected";
                            }
                        ?>
                        >
                    สินค้าใหม่
                </option>
                <option value="used"
                        <?php
                            if($product_data['type']=='used') {
                                echo "selected";
                            }
                        ?>
                        >
                    สินค้ามือสอง
                </option>
                <option value="pre"
                        <?php
                            if($product_data['type']=='pre') {
                                echo "selected";
                            }
                        ?>
                        >
                    สินค้า Pre-Order
                </option>
            </select>
        </li>
    </ul>
    <div class="clear"></div> 

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'name'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_name" class="txt" value="<?php echo $product_data['name']; ?>" />
            <div><?php echo form_error('txt_name'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'title'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_title" class="txt" value="<?php echo $product_data['title']; ?>" />
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'detail'); ?>
        </li>
        <li class="inputfield">
            <textarea class="cke" name="txt_detail"><?php echo $product_data['detail']; ?></textarea>
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'image'); ?>
        </li>
        <li class="inputfield">
            <div>
                <?php
                    if($product_data['image']!='') {
                ?>
                <img style="width: 70px;height: 70px;" src="<?php echo assets_product($product_data['image'], $product_data['owner_type']); ?>" alt="<?php echo $product_data['name']; ?>" />
                <?php
                    }
                ?>
            </div>
            <input type="file" name="txt_image" id="txt_image"/>
            <div class="msg_form_error">
             <?php
                if(isset($error_message)) {
                    echo $error_message;
                }
            ?>         
            </div>
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'price'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_price" class="txt" value="<?php echo $product_data['price']; ?>" />
            <div><?php echo form_error('txt_price'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'unit'); ?> <div>(เช่น ชิ้น, กล่อง)</div>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_unit" class="txt" value="<?php echo $product_data['unit']; ?>" />
            <div><?php echo form_error('txt_unit'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <!--
    <ul class="forms">
        <li class="txt">
            <?php //echo get_field_lang('shop_product', 'size'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_size" class="txt" value="<?php //echo $product_data['size']; ?>" />
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php //echo get_field_lang('shop_product', 'color'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_color" class="txt" value="<?php //echo $product_data['color']; ?>" />
        </li>
    </ul>
    <div class="clear"></div>
    -->
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product_gallery', 'image'); ?>
            <a href="javascript:void(0);" onclick="add_image_gallery()">เพิ่มรูป</a>
        </li>
        <li class="inputfield">
            <div id="form_row_control" class="form_row_gallery">
                <?php
                    foreach($product_gallery_data as $value) {
                ?>
                <div>
                    <div>
                        <img src="<?php echo assets_product($value['image'], $product_data['owner_type']); ?>" alt="<?php echo $product_data['name']; ?>" style="max-height: 150px; max-width: 250px;" />
                        <input type="hidden" name="hid_gallery_id[]" value="<?php echo $value['id']; ?>" />
                        <input type="hidden" name="hid_gallery_image[]" value="<?php echo $value['image']; ?>" />
                        <input type="hidden" name="hid_gallery_product_id[]" value="<?php echo $value['product_id']; ?>" />
                    </div>
                    <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="msg_form_error">
             <?php
                if(isset($error_message2)) {
                    foreach ($error_message2 as $e) {
                        echo $e;
                    }
                }
            ?>
            </div>
        </li>
    </ul>
    <div class="clear"></div> 
    <div class="form_row" style="display: none;">
        <input type="submit" name="btn_add_product" value="บันทึกสินค้า" />
    </div>
</div>
<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>บันทึกสินค้า</span></a>
<?php echo form_close(); ?>