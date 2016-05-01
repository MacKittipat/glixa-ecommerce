<h2 class="heading">
    ข้อมูลร้านค้าของ <?php echo $username; ?>
</h2>
<div>

    <div style="overflow: hidden;">
        <div style="float: left;margin-right: 10px;">
            <?php
                if(isset($user_shop_data['image']) && $user_shop_data['image']!='') {
           ?>
            <img src="<?php echo assets_shop($user_shop_data['image']); ?>" alt="<?php echo $username; ?>" style="width: 100px;height: 100px;" />
            <?php
                } else {
            ?>
            <img src="<?php echo assets_image('product.png'); ?>" alt="<?php echo $username; ?>" style="width: 100px;height: 100px;" />
            <?php
                }
            ?>
        </div>
        <div style="float: left;">
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b><?php echo get_field_lang('shop_user_shop', 'description'); ?></b>
                </div>
                <div style="float: left;">
                    <?php echo (isset($user_shop_data['description']) && $user_shop_data['description']!='') ? $user_shop_data['description'] : '-'; ?>
                </div>
            </div>
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b><?php echo get_field_lang('shop_user_shop', 'email'); ?></b>
                </div>
                <div style="float: left;">
                    <?php echo (isset($user_shop_data['email']) && $user_shop_data['email']!='') ? $user_shop_data['email'] : '-'; ?>
                </div>
            </div>
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b><?php echo get_field_lang('shop_user_shop', 'tel_num'); ?></b>
                </div>
                <div style="float: left;">
                    <?php echo (isset($user_shop_data['tel_num']) && $user_shop_data['tel_num']!='') ? $user_shop_data['tel_num'] : '-'; ?>
                </div>
            </div>
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b><?php echo get_field_lang('shop_user_shop', 'user_address_id'); ?></b>
                </div>
                <div style="float: left;">
                    <?php
                        if(isset($user_shop_data['user_address_id'])) {
                            $user_add_data = $this->user_address_model->get_user_address('id',$user_shop_data['user_address_id']);
                            echo ($user_shop_data['user_address_id']!='') ? $user_add_data['address'].' '. $user_add_data['tambon'].' '.$user_add_data['amphoe'].' '.$user_add_data['province'].' '.$user_add_data['postalcode'] : '-';
                        } else {
                            echo '-';
                        }
                    ?>
                </div>
            </div>
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b>Facebook Page<br>เฟซบุ๊คเพจ</b>
                </div>
                <div style="float: left;">
                    <?php echo (isset($user_shop_data['facebook_id']) && $user_shop_data['facebook_id']!='') ? anchor('http://www.facebook.com/profile.php?id='.$user_shop_data['facebook_id'],'Facebook Page') : '-'; ?>
                </div>
            </div>
            <div style="overflow: hidden;margin-bottom: 3px;">
                <div style="float: left;width: 150px;">
                    <b><?php echo get_field_lang('shop_user_shop', 'instruction'); ?></b>
                </div>
                <div style="float: left;">
                    <?php echo (isset($user_shop_data['instruction']) && $user_shop_data['instruction']!='') ? nl2br($user_shop_data['instruction']) : '-'; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<h2 class="heading">
    สินค้าของ <?php echo $username; ?>
</h2>
<div>
    <?php row_product($product_data); ?>
</div>
<?php echo $pagination; ?>