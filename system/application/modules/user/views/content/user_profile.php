<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<?php
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<?php 
    echo form_open('user/profile', array('id'=>'frm_profile'));
    echo create_form_key();
?>
<div class="gre_sec">
    <h3>ข้อมูลส่วนตัวของท่าน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'firstname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_firstname_edit_profile" id="txt_firstname_edit_profile"
               value="<?php echo $user_data['firstname']; ?>" class="txt" />
            <div>
                <?php echo form_error("txt_firstname_edit_profile"); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('wive_user', 'lastname'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_lastname_edit_profile" id="txt_lastname_edit_profile"
               value="<?php echo $user_data['lastname']; ?>" class="txt" />
            <div>
                <?php echo form_error("txt_lastname_edit_profile"); ?>
            </div>
        </li>
        <li class="req">(Required)</li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'identity_number'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_identity_number_edit_profile" id="txt_identity_number_edit_profile"
               value="<?php echo $user_profile_data['identity_number']; ?>" class="txt" />
            <div><?php echo form_error("txt_identity_number_edit_profile"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>

    <!--
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'address'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_address_edit_profile" id="txt_address_edit_profile"
               value="<?php echo $user_profile_data['address']; ?>" class="txt" />
            <?php echo form_error("txt_address_edit_profile"); ?>
        </li>
        
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'tambon'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_tambon_edit_profile" id="txt_tambon_edit_profile"
               value="<?php echo $user_profile_data['tambon']; ?>" class="txt" />
            <?php echo form_error("txt_tambon_edit_profile"); ?>
        </li>
        
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'amphoe'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_amphoe_edit_profile" id="txt_amphoe_edit_profile"
               value="<?php echo $user_profile_data['amphoe']; ?>" class="txt" />
            <?php echo form_error("txt_amphoe_edit_profile"); ?>
        </li>
        
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'province'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_province_edit_profile" id="txt_province_edit_profile"
               value="<?php echo $user_profile_data['province']; ?>" class="txt" />
            <?php echo form_error("txt_province_edit_profile"); ?>
        </li>
        
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'postalcode'); ?>
        </li>
        <li class="inputfield">
           <input type="text" name="txt_postalcode_edit_profile" id="txt_postalcode_edit_profile"
               value="<?php echo $user_profile_data['postalcode']; ?>" class="txt" />
            <?php echo form_error("txt_postalcode_edit_profile"); ?>
        </li>
        
    </ul>
    <div class="clear"></div>
    -->

    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_profile', 'tel_num'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_tel_num_edit_profile" id="txt_tel_num_edit_profile"
               value="<?php echo $user_profile_data['tel_num']; ?>" class="txt" />
            <div><?php echo form_error("txt_tel_num_edit_profile"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
</div>
<input type="hidden" name="btn_profile" value="profile" />
<a href="javascript:void(0);" class="button right" style="margin-top: -5px;" onclick="javascript:$('#frm_profile').submit();"><span>บันทึก</span></a>
<div class="form_row">
    <input type="submit" style="visibility: hidden" name="btn_edit_profile" id="btn_edit_profile" value="Save - บันทึก" />
</div>
<?php echo form_close(); ?>
<div class="clear"></div>

<?php echo form_open_multipart('user/profile', array('id'=>'frm_shop')) ?>
<div class="gre_sec">
    <h3>ข้อมูลร้านค้าของท่าน</h3>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'image'); ?>
        </li>
        <li class="inputfield">
            <div class="form_row">
                <?php
                    if(isset($user_shop_data['image']) && $user_shop_data['image']!='') {
                ?>
                <img src="<?php echo assets_shop($user_shop_data['image']); ?>" style="width: 100px;height: 100px;" />
                <input type="hidden" name="hid_shop_image" value="<?php echo $user_shop_data['image']; ?>" />
                <?php
                    }
                ?>
            </div>
            <input type="file" name="file_shop_image" />
            <?php
                if(isset($_SESSION['error'])) {
            ?>
            <div style="color: red;"><?php echo $_SESSION['error']; ?></div>
            <?php
                }
            ?>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'email'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_email" id="txt_email"
               value="<?php echo (isset($user_shop_data['email'])) ? $user_shop_data['email'] : ''; ?>" class="txt" />
            <div>
                <?php echo form_error("txt_email"); ?>
            </div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'tel_num'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_tel_num" id="txt_tel_num"
               value="<?php echo (isset($user_shop_data['tel_num'])) ? $user_shop_data['tel_num'] : ''; ?>" class="txt" />
            <div><?php echo form_error("txt_tel_num"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'user_address_id'); ?>
        </li>
        <li class="inputfield">
            <?php
                if(count($user_address_data)>0) {
            ?>
            <select name="ddl_address">
                <?php
                    foreach($user_address_data as $address) {
                ?>
                <option value="<?php echo $address['id']; ?>" <?php echo (isset($user_shop_data['user_address_id']) && $user_shop_data['user_address_id']==$address['id']) ? 'selected' : ''; ?>>
                <?php echo $address['address']; ?>
                <?php echo $address['tambon']; ?>
                <?php echo $address['amphoe']; ?>
                <?php echo $address['province']; ?>
                <?php echo $address['postalcode']; ?>
                </option>
                <?php
                    }
                ?>
            </select>

            <?php
                } 
            ?>
            <div>
                <?php  echo anchor('user/add_address', 'เพิ่มที่อยู่'); ?>
            </div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'facebook_id'); ?>
        </li>
        <li class="inputfield">
            <input type="text" name="txt_facebook_id" id="txt_facebook_id"
               value="<?php echo (isset($user_shop_data['facebook_id'])) ? $user_shop_data['facebook_id'] : ''; ?>" class="txt" />
            <div><?php echo form_error("txt_facebook_id"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'description'); ?>
        </li>
        <li class="inputfield">
            <textarea name="txt_description" id="txt_description" class="txtx" style="width: 335px;"><?php echo (isset($user_shop_data['description'])) ? $user_shop_data['description'] : ''; ?></textarea>
            <div><?php echo form_error("txt_description"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'promotion'); ?>
        </li>
        <li class="inputfield">
            <textarea name="txt_promotion" id="txt_promotion" class="txtx" style="width: 335px;"><?php echo (isset($user_shop_data['promotion'])) ? $user_shop_data['promotion'] : ''; ?></textarea>
            <div><?php echo form_error("txt_promotion"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
    <ul class="forms">
        <li class="txt">
            <?php echo get_field_lang('shop_user_shop', 'instruction'); ?>
        </li>
        <li class="inputfield">
            <textarea name="txt_instruction" id="txt_instruction" class="txtx" style="width: 335px;"><?php echo (isset($user_shop_data['instruction'])) ? $user_shop_data['instruction'] : ''; ?></textarea>
            <div><?php echo form_error("txt_instruction"); ?></div>
        </li>
    </ul>
    <div class="clear"></div>
</div>
<input type="hidden" name="btn_shop" value="shop" />
<input style="display: none;" type="submit" name="sub" value="aaa"/>
<a href="javascript:void(0);" class="button right" style="margin-top: -5px;" onclick="javascript:$('#frm_shop').submit();"><span>บันทึก</span></a>
<?php echo form_close(); ?>
<div class="clear"></div>


<div class="gre_sec" style="margin-top: 10px;">
    <h3 class="heading" style="margin-bottom: 0px;">
        ที่อยู่สำหรับซื้อสินค้า
    </h3>
    <?php
        foreach($user_address_data as $value) {
    ?>
    
    <div style="border: 1px solid #cccccc;padding: 5px 5px 5px 5px; margin-bottom: 5px;">
        <div class="form_row" style="background-color: #A2422C;padding: 3px 3px 3px 3px; color: white;">
            <b><?php echo $value['firstname']; ?></b>
            <b><?php echo $value['lastname']; ?></b>
        </div>
        <ul class="forms">
            <li class="txt">
                <?php echo get_field_lang('shop_user_address', 'address'); ?>
            </li>
            <li class="inputfield">
                <?php echo $value['address']; ?>
                <?php echo $value['tambon']; ?>
                <?php echo $value['amphoe']; ?>
                <?php echo $value['province']; ?>
                <?php echo $value['postalcode']; ?>
            </li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
            <li class="txt">
                <?php echo get_field_lang('shop_user_address', 'tel_num'); ?>
            </li>
            <li class="inputfield">
                <?php echo $value['tel_num']; ?>
            </li>

        </ul>
        <div class="clear"></div>
        <?php
            if($value['fax_num']!='' ) {
        ?>
            <ul class="forms">
                <li class="txt">
                    <?php echo get_field_lang('shop_user_address', 'fax_num'); ?>
                </li>
                <li class="inputfield">
                    <?php echo $value['fax_num']; ?>
                </li>

            </ul>
            <div class="clear"></div>
        <?php
            }
        ?>
        <div class="form_row">
           <span><?php echo anchor('user/edit_address/'.$value['id'], 'แก้ไข'); ?></span>
           |
           <span><a href="javascript:void(0);" onclick="del_address(<?php echo $value['id']; ?>);">ลบ</a></span>
        </div>
    </div>
    <?php
        }
    ?>
</div>



<script type="text/javascript">
    function del_address(id) {
        if(confirm("คุณแน่ใจว่าต้องการลบที่อยู่นี้")==true) {
            window.location = '<?php echo base_url(); ?>user/del_address/' + id;
        }
    }
</script>