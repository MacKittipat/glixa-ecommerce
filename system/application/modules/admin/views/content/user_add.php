<?php
    echo form_open('admin/user/add', array('id'=>'frm_register'));
    echo create_form_key();
?>
<div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'email'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_email" value="<?php echo set_value('txt_email'); ?>" />
            <?php echo form_error('txt_email'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'password'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="password" name="txt_password" value="<?php echo set_value('txt_password'); ?>" />
            <?php echo form_error('txt_password'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'cpassword'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="password" name="txt_cpassword" value="<?php echo set_value('txt_cpassword'); ?>" />
            <?php echo form_error('txt_cpassword'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'firstname'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_firstname" value="<?php echo set_value('txt_firstname'); ?>" />
            <?php echo form_error('txt_firstname'); ?>
        </div>
    </div>
    <div class="form_row">
        <div id="form_row_title">
            <b>
                <?php echo get_field_lang('wive_user', 'lastname'); ?>
            </b>
        </div>
        <div id="form_row_control">
            <input type="text" name="txt_lastname" value="<?php echo set_value('txt_lastname'); ?>" />
            <?php echo form_error('txt_lastname'); ?>
        </div>
    </div>
</div>
<div>
    <input type="submit" name="btn_register" id="btn_register" value="สมัครสมาชิก" />
</div>
<?php echo form_close(); ?>