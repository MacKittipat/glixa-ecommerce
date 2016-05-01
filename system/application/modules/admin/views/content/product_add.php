<!--
<script type="text/javascript" src="<?php echo assets_js('ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('ckfinder/ckfinder.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('ckeditor/adapters/jquery.js'); ?>"></script>
-->
<script type="text/javascript">
//    $(document).ready(function(){
//        $(".cke").ckeditor({
//            filebrowserBrowseUrl : base_url + 'assets/js/kcfinder/browse.php?type=files',
//            filebrowserImageBrowseUrl : base_url + 'assets/js/kcfinder/browse.php?type=images',
//            filebrowserFlashBrowseUrl : base_url + 'assets/js/kcfinder/browse.php?type=flash',
//            filebrowserUploadUrl : base_url + 'assets/js/kcfinder/upload.php?type=files',
//            filebrowserImageUploadUrl : base_url + 'assets/js/kcfinder/upload.php?type=images',
//            filebrowserFlashUploadUrl : base_url + 'assets/js/kcfinder/upload.php?type=flash'
//        });
//    });
//    function openKCFinder(field) {
//        window.KCFinder = {
//            callBack: function(url) {
//                window.KCFinder = null;
//                field.value = url;
//            }
//        };
//        window.open('<?php echo base_url(); ?>assets/js/kcfinder/browse.php?type=images&dir=files/public', 'kcfinder_textbox',
//            'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
//            'resizable=1, scrollbars=0, width=800, height=600'
//        );
//    }
    function add_image_gallery() {
        $(".form_row_gallery").append("<div><input type='text' name='txt_gallery[]' onclick='openKCFinder(this)' value='คลิก' /> <a href='javascript:void(0);' onclick='del_image_gallery(this)'>ลบ</a></div>");
    }
    function del_image_gallery(th) {
        $(th).parent().remove();
    }
    function del_option(th) {
        $(th).parent().remove();
    }
    function add_option() {
        $(".product_option_control").append('<div class="product_option">Option <input type="text" name="txt_option[]" style="width: 100px;" /> Value <input type="text" name="txt_value[]" style="width: 100px;" /> <a href="javascript:void(0);" onclick="del_option(this);">ลบ</a></div>');
    }
</script>


<!-- jQuery UI -->
<link rel="stylesheet" type="text/css" href="<?php echo assets_js('elfinder/js/ui-themes/base/ui.all.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo assets_js('elfinder/css/elfinder.css'); ?>" />
<link rel="stylesheet" href="<?php echo assets_js('elrte/css/elrte.full.css'); ?>" type="text/css" />
<script src="<?php echo assets_js('elfinder/js/jquery-1.4.1.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_js('elfinder/js/jquery-ui-1.7.2.custom.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_js('elfinder/js/elfinder.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo assets_js('elrte/js/elrte.min.js'); ?>" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var opts = {
                cssClass : 'el-rte',
                // lang     : 'ru',
                height   : 200,
                toolbar  : 'complete',
                cssfiles : ['<?php echo assets_js('elrte/css/elrte-inner.css'); ?>'],
                fmOpen : function(callback) {
                    $('<div id="myelfinder" />').elfinder({
                        url : '<?php echo assets_js('elfinder/connectors/php/connector.php'); ?>',
                        dialog : { width : 900, modal : true, title : 'File Browse' }, // open in dialog window
                        closeOnEditorCallback : true, // close after file select
                        editorCallback : callback     // pass callback to file manager
                    })
                },
                contextmenu : {
                    // Commands that can be executed for current directory
                    cwd : ['reload', 'delim', 'mkdir', 'mkfile', 'upload', 'delim', 'paste', 'delim', 'info'],
                    // Commands for only one selected file
                    file : ['select', 'open', 'delim', 'copy', 'cut', 'rm', 'delim', 'duplicate', 'rename'],
                    // Coommands for group of selected files
                    group : ['copy', 'cut', 'rm', 'delim', 'archive', 'extract', 'delim', 'info']
                }
        }
        $('.cke').elrte(opts);
    });

    function openKCFinder(field) {
        var opts = {
            url : '<?php echo assets_js('elfinder/connectors/php/connector.php'); ?>',
            editorCallback : function(url) { field.value = url },
            closeOnEditorCallback : true,
            dialog : { title : 'File Browse', height: 500, width:700},
            contextmenu : {
                // Commands that can be executed for current directory
                cwd : ['reload', 'delim', 'mkdir', 'mkfile', 'upload', 'delim', 'paste', 'delim', 'info'],
                // Commands for only one selected file
                file : ['select', 'open', 'delim', 'copy', 'cut', 'rm', 'delim', 'duplicate', 'rename'],
                // Coommands for group of selected files
                group : ['copy', 'cut', 'rm', 'delim', 'archive', 'extract', 'delim', 'info']
            }
        };
        $('<div id="myelfinder" />').elfinder(opts);
    }

</script>
<div id="elfinder"></div>
<?php
    echo form_open('admin/product/add');
    echo create_form_key();
?>
<div>
    <!--
    <div class="form_row">
        <div id="form_row_title">
            <?php echo get_field_lang('shop_product', 'product_code'); ?>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_product_code" />
        </div>
    </div>
    -->
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'owner_id'); ?></b>
        </div>
        <div id="form_row_control">
            <select name="ddl_supplier_id">
                <?php
                    foreach($supplier_data as $value) {
                ?>
                <option value="<?php echo $value['id']; ?>" <?php echo set_select('ddl_supplier_id', $value['id']); ?>><?php echo $value['name'] ?></option>
                <?php
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'product_category_id'); ?></b>
        </div>
        <div id="form_row_control">
            <select name="ddl_product_category_id">
                <?php
                    foreach($product_category_data as $value) {

                    $sub_product_category_data = $this->product_category_model->get_product_category('','','AND product_category_id="'.$value['id'].'"');
                ?>
                <optgroup label="<?php echo $value['name']; ?>" style="font-family: Tahoma;">
                <?php
                    foreach($sub_product_category_data as $sub_cat) {
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
    </div>
    <!--
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'owner_type'); ?></b>
        </div>
        <div id="form_row_control">
            <select name="ddl_owner_type">
                <option value="b2c">
                    b2c
                </option>
                <option value="silver">
                    silver
                </option>
            </select>
        </div>
    </div>
    -->
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'options'); ?></b>
        </div>
        <div id="form_row_control">
            <select name="ddl_options">
                <option value="normal" <?php echo set_select('ddl_options', 'normal'); ?>>==เลือก<?php echo get_field_lang('shop_product', 'options'); ?>==</option>
                <option value="Promotion" <?php echo set_select('ddl_options', 'Promotion'); ?>>Promotion</option>
                <option value="Hot" <?php echo set_select('ddl_options', 'Hot'); ?>>Hot</option>
            </select>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'type'); ?></b>
        </div>
        <div id="form_row_control">
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
        </div>
    </div>

    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'name'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_name" value="<?php echo set_value('txt_name'); ?>" />
            <?php echo form_error('txt_name'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'title'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_title" value="<?php echo set_value('txt_title'); ?>" />
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'detail'); ?></b>
        </div>
        <div id="form_row_control">
            <textarea class="cke" name="txt_detail"><?php echo set_value('txt_detail'); ?></textarea>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'image'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_image" onclick="openKCFinder(this)" id="txt_image" value="คลิก" />
        </div>
    </div>
    <!--
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'cost'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_cost" value="<?php echo set_value('txt_cost'); ?>" />
            <?php echo form_error('txt_cost'); ?>
        </div>
    </div>
    -->
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'price'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_price" value="<?php echo set_value('txt_price'); ?>" />
            <?php echo form_error('txt_price'); ?>
        </div>
    </div>
    <!--
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'quantity'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_quantity" value="<?php echo set_value('txt_quantity'); ?>" />
            <?php echo form_error('txt_quantity'); ?>
        </div>
    </div>
    -->
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'unit'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_unit" value="<?php echo set_value('txt_unit'); ?>" />
            <?php echo form_error('txt_unit'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'full_price'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_full_price" value="<?php echo set_value('txt_full_price'); ?>" />
            <?php echo form_error('txt_full_price'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'weight'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_weight" value="<?php echo set_value('txt_weight'); ?>" />
            <?php echo form_error('txt_weight'); ?>
        </div>
    </div>

    <!--
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'size'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_size" value="<?php echo set_value('txt_size'); ?>" />
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product', 'color'); ?></b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_color" value="<?php echo set_value('txt_color'); ?>" />
        </div>
    </div>
    -->
    <div>
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product_gallery', 'image'); ?></b>
            <a href="javascript:void(0);" onclick="add_image_gallery()">เพิ่มรูป</a>
        </div>
        <div id="form_row_control" class="form_row_gallery">
            <div>
                <input type="text" name="txt_gallery[]" onclick="openKCFinder(this)" value="คลิก" />
                <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
            </div>
            <div>
                <input type="text" name="txt_gallery[]" onclick="openKCFinder(this)" value="คลิก" />
                <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
            </div>
            <div>
                <input type="text" name="txt_gallery[]" onclick="openKCFinder(this)" value="คลิก" />
                <a href="javascript:void(0);" onclick="del_image_gallery(this)">ลบ</a>
            </div>
        </div>
    </div>
    <div>
        <div id="form_row_title">
            <b><?php echo get_field_lang('shop_product_option', 'options'); ?></b>
            <a href="javascript:void(0);" onclick="add_option();">
                เพิ่ม
            </a>
        </div>
        <div id="form_row_control" class="product_option_control">
            <div class="product_option">
                Option <input type="text" name="txt_option[]" style="width: 100px;" />
                Value <input type="text" name="txt_value[]" style="width: 100px;" />
                <a href="javascript:void(0);" onclick="del_option(this);">ลบ</a>
            </div>
        </div>
    </div>
</div>
<div>
    <input type="submit" name="btn_add_product" value="เพิ่มสินค้า" />
</div>
<?php echo form_close(); ?>