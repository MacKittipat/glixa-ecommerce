<script type="text/javascript" src="<?php echo assets_js('ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('ckeditor/adapters/jquery.js'); ?>"></script>
<script type="text/javascript">
    var i=3;
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
<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    echo form_open_multipart('user/add_product');
    echo create_form_key();
?>
<?php
    if(isset($message)) {
        echo $message;
    }
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

                ?>
                <optgroup label="<?php echo $value['name']; ?>" style="font-family: Tahoma;">
                    <?php
                        foreach($p_product_category as $sub_cat) {
                    ?>
                    <option value="<?php echo $sub_cat['id']; ?>">
                        <?php echo $sub_cat['name']; ?>
                    </option>
                    <?php
                        }
                    ?>
                </optgroup>
                <!--<option value="<?php echo $value['id']; ?>" <?php echo set_select('ddl_product_category_id', $value['id']); ?>><?php echo $value['name'] ?></option>-->
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
                <option value="null">
                    == เลือกสภาพสินค้า ==
                </option>
                <option value="new">
                    สินค้าใหม่
                </option>
                <option value="used">
                    สินค้ามือสอง
                </option>
                <option value="pre">
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
            <input type="text" name="txt_name" value="<?php echo set_value('txt_name'); ?>" class="txt" maxlength="40" />
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
            <input type="text" name="txt_title" value="<?php echo set_value('txt_title'); ?>" class="txt" />
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'detail'); ?>
        </li>
        <li class="inputfield">
            <textarea class="cke" name="txt_detail"><?php echo set_value('txt_detail'); ?></textarea>
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'image'); ?>
        </li>
        <li class="inputfield">
            <input type="file" name="txt_image" id="txt_image" />
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
            <input type="text" name="txt_price" value="<?php echo set_value('txt_price'); ?>" class="txt" />
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
            <input type="text" name="txt_unit" value="<?php echo set_value('txt_unit'); ?>" class="txt" />
            <div><?php echo form_error('txt_unit'); ?></div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <!--
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'size'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_size" value="<?php echo set_value('txt_size'); ?>" class="txt" />
        </li>
    </ul>
    <div class="clear"></div> 
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product', 'color'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_color" value="<?php echo set_value('txt_color'); ?>" class="txt" />
        </li>
    </ul>
    -->
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_product_gallery', 'image'); ?>
            <a href="javascript:void(0);" onclick="add_image_gallery()">เพิ่มรูป</a>
        </li>
        <li class="inputfield">
            <div id="form_row_control" class="form_row_gallery">
                <div>
                    <input type="file" name="txt_gallery[]" />
                    <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
                </div>
                <div>
                    <input type="file" name="txt_gallery[]"  />
                    <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
                </div>
                <div>
                    <input type="file" name="txt_gallery[]"  />
                    <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
                </div>
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

</div>
<div class="form_row" style="display: none;">
    <input type="submit" name="btn_add_product" value="เพิ่มสินค้า" />
</div>
<a href="javascript:void(0);" class="button right" onclick="javascript:$('form').submit();"><span>เพิ่มสินค้า</span></a>
<?php echo form_close(); ?>