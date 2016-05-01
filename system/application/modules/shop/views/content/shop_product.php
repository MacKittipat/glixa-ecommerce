<link rel="stylesheet" type="text/css" href="<?php echo assets_js('jquery-ui/css/ui-lightness/jquery-ui-1.8.4.custom.css'); ?>" />
<style type="text/css">
    .ui-widget { font-family: Tahoma; font-size: small; }
</style>
<script type="text/javascript" src="<?php echo assets_js('jquery-ui/js/jquery-ui-1.8.4.custom.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo assets_js('rating/jquery.rating.css'); ?>" />
<!-- Gallery -->
<link rel="stylesheet" type="text/css" href="<?php echo assets_template('estore/css/jquery.ad-gallery.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_template('estore/js/jquery.ad-gallery.js?rand=995'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_template('estore/js/thumbgallery.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('rating/jquery.MetaData.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('rating/jquery.rating.pack.js'); ?>"></script>
<!--
<script type="text/javascript" src="<?php echo assets_js('galleria/galleria.js'); ?>"></script>
-->
<script type="text/javascript">
    var base_urls = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        <?php
            if($this->input->post('tab')) {
                echo "var t = ".$this->input->post('tab').";";
            } else {
                echo "var t = 0";
            }
        ?>
        // == Tabs ==
        $("#tabs_product").tabs({selected: t});
        // == Rating ==
         $('.rating').rating();
    });
</script>
<div>
    <h2 class="heading">
        <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>" class="a_title">
            <?php echo $product_data['name']; ?> 
        </a>
        <span style="font-size: small;color: #999999;">
            <?php
                if($product_data['title']!='') {
                    echo ' - '. $product_data['title'];
                }
            ?>
        </span>
    </h2>
    <!-- Product Detail Section -->
    <div class="prod_detail">
        <div class="detail">
            <div>
                    <?php
                        if($product_data['owner_type']!='c2c') {

                    ?>
                    จำนวน 
                    <?php
                        if((int)$product_qty>0) {
                            echo 'In Stock';
                        } else {
                            echo 'Out of Stock';
                        }
                    ?>
                    <?php
                        }
                    ?>
            </div>
            <div class="prod_info">
                <?php
                    $owner_username;
                    if($product_data['owner_type']=='c2c') {
                        $user_data = $this->user_model->get_user('id',$product_data['owner_id']);
                        $owner_username = $user_data['username'];
                        echo '<ul><li>Seller</li><li>'.anchor($user_data['username'], $user_data['username']).'</li></ul>';
                    }
                ?>
                <?php
                    if($product_data['type']!='') {

                ?>
                <ul>
                    <li>สภาพ</li>
                    <li><?php
                        if($product_data['type']=='new') {
                            echo 'สินค้าใหม่';
                        } else if($product_data['type']=='used') {
                            echo 'สินค้ามือสอง';
                        } else if($product_data['type']=='pre') {
                            echo 'สินค้า Pre-Order';
                        }
                    ?></li>
                </ul>
                <?php
                    }
                ?>
                <?php
                    if($product_data['owner_type']!='c2c' && ($product_data['full_price']!='' && (int)$product_data['full_price']!=0)) {
                ?>
                <ul>
                    <li>ราคาเต็ม</li>
                    <li><strike><?php echo currency($product_data['full_price']); ?></strike> บาท</li>
                </ul>
                <?php
                    }
                ?>
                <ul>
                    <li>ราคา</li>
                    <li><b style="color: red;"><?php echo currency($product_data['price']); ?></b> บาท</li>
                </ul>
                <?php
                    if($product_data['owner_type']!='c2c' && ($product_data['weight']!='' && (int)$product_data['weight']!=0)) {
                ?>
                <ul>
                    <li>น้ำหนัก</li>
                    <li><?php echo currency($product_data['weight']); ?> กรัม</li>
                </ul>
                <?php
                    }
                ?>

                <?php echo form_open('shop/shop/add_cart'); ?>
                <?php
                    foreach($option_data as $option) {
                ?>
                <ul>
                    <li>
                        <?php echo $option['options']; ?>
                    </li>
                    <li>
                        <select name="ddl_option[]">
                            <?php
                                $val = explode(',', $option['value']);
                                foreach($val as $v) {
                            ?>
                            <option value="<?php echo $option['options']; ?>,<?php echo trim($v); ?>">
                                <?php echo trim($v); ?>
                            </option>
                            <?php
                                }
                            ?>
                        </select>
                    </li>
                </ul>
                <?php
                    }
                ?>
                <!-- Buy Now -->
                <ul>
                    <li>
                    <?php
                        if($product_data['owner_type']!='c2c') {
                    ?>
                    
                    <input type="hidden" name="hid_id" value="<?php echo $product_data['id']; ?>" />
                    <input type="hidden" name="hid_current_url" value="<?php echo current_url(); ?>" />
                    <!--
                    <input type="submit" name="btn_add_cart" class="button" value="ใส่ตะกร้า" />
                    -->
                    <a href="#" class="button" onclick="javascript:$(this).parent().parent().parent('form').submit();"><span>Buy Now</span></a>
                    <button style="display: none;" type="submit" type="submit" name="btn_add_cart" class="btn_add_cart" value="ใส่ตะกร้า" ></button>
                    
                    <?php
                        }
                    ?>
                    </li>
                </ul>
                <?php echo form_close(); ?>
            </div>
            <div style="margin-top: 5px;">
                <div style="margin-bottom: 5px;">
                    <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                    <fb:like action="recommend" href="<?php echo current_url(); ?>"></fb:like>
                </div>
                <div>
                    <a name="fb_share" share_url="<?php echo current_url(); ?>"></a>
                    <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"
                            type="text/javascript">
                    </script>
                </div>
            </div>
            <div style="margin-top: 5px;">
                <?php
                    if($product_data['owner_type']!='c2c') { // ไม่ใช่ c2c
                ?>
                <img src="<?php echo assets_image('glixa_guaruntee.png'); ?>" alt="Guarantee by Glixa" />
                <?php
                    }
                ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php
        if($product_data['image']!='' && $product_gallery_data!=null) { // show gallery
    ?>
        <!-- Thumbnails -->
        <div class="thumbs">
            <div id="gallery" class="ad-gallery">
                <div class="ad-image-wrapper">
                </div>
                <div class="ad-nav">
                    <div class="ad-thumbs">
                        <ul class="ad-thumb-list">
                            <?php
                                if($product_gallery_data!=null) {
                                    foreach ($product_gallery_data as $row) {
                            ?>
                            <li>
                                <a href="<?php echo assets_product($row['image'], $product_data['owner_type']); ?>">
                                    <img src="<?php echo assets_product($row['image'], $product_data['owner_type']);?>" alt="" class="image0" style="width: 50px;" />
                                </a>
                            </li>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    <?php
        } else if($product_data['image']!='' && $product_gallery_data==null) { // show photo
     ?>
    <div class="form_row">
        <img src="<?php echo assets_product($product_data['image'], $product_data['owner_type']); ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
    </div>
    <?php
        } else if($product_data['image']=='' && $product_gallery_data!=null) { // show gallery
    ?>
        <!-- Thumbnails -->
        <div class="thumbs">
            <div id="gallery" class="ad-gallery">
                <div class="ad-image-wrapper">
                </div>
                <div class="ad-nav">
                    <div class="ad-thumbs">
                        <ul class="ad-thumb-list">
                            <?php
                                if($product_gallery_data!=null) {
                                    foreach ($product_gallery_data as $row) {
                            ?>
                            <li>
                                <a href="<?php echo assets_product($row['image'], $product_data['owner_type']); ?>">
                                    <img src="<?php echo assets_product($row['image'], $product_data['owner_type']);?>" alt="" class="image0" style="width: 50px;" />
                                </a>
                            </li>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    <?php
        } else  if($product_data['image']=='' && $product_gallery_data==null) { // show default photo
    ?>
    <div class="form_row">
        <img src="<?php echo base_url().'assets/image/product.png'; ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
    </div>
    <?php
        }
    ?>
    </div>
    <div class="clear"></div>
    <!-- Product Listing Section -->
    <div class="form_row">
        <?php
//            // Success Message, Error Message
//            echo $tab_message;
//            echo validation_errors('<div class="msg_form_error">', '</div>');
        ?>
    </div>
    <div class="form_row" id="tabs_info">
       <!-- TAB -->
        <div id="tabs_product" style="width: 700px;margin-top: 8px;">
            <ul>
                <li><a href="#tabs_detail">รายละเอียดสินค้า</a></li>
                <li><a href="#tabs_score">รีวิวสินค้า</a></li>
                <?php
                    if(is_user_login()) {
                ?>
                <li><a href="#tabs_review">เขียนรีวิว</a></li>
                <?php
                    }
                ?>
                <!--<li><a href="#tabs_media">วิดีโอและลิงค์</a></li>-->
                <li><a href="#tabs_qa">คำถามและคำตอบ</a></li>
                <?php
                    if($product_data['owner_type']=='c2c') {
                ?>
                <li><a href="#tabs_contact">ติดต่อสั่งซื้อ</a></li>
                <?php
                    }
                ?>
            </ul>
            <div id="tabs_detail">
                <div>
                    <?php echo $product_data['detail']; ?>
                </div>
            </div>
            <div id="tabs_score">
                <div>
                    <?php
                        foreach($review_data as $review) {
                            $user_data = $this->user_model->get_user('id', $review['user_id']);
                    ?>
                    <div class="form_row" style="margin-bottom: 5px;border-bottom: 1px solid #A2422C;">
                        <div class="form_row_title">
                            <b><?php echo $review['title']; ?></b>
                        </div>
                        <div class="form_row_control">
                            <div>
                                <div>
                                    <b>Overall Rating</b>
                                </div>
                                <div style="overflow: hidden;display: block;">
                                    <?php
                                        for($i=1;$i<=5;$i++) {
                                            $ch = '';
                                            if($i==(int)$review['overall_rating']) {
                                                $ch='checked="checked"';
                                            }
                                            echo '<input name="star1'.$review['id'].'" type="radio" class="star" disabled="disabled" '.$ch.' />';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <b>Value for Money</b>
                                </div>
                                <div style="overflow: hidden;display: block;">
                                    <?php
                                        for($i=1;$i<=5;$i++) {
                                            $ch = '';
                                            if($i==(int)$review['money_rating']) {
                                                $ch='checked="checked"';
                                            }
                                            echo '<input name="star2'.$review['id'].'" type="radio" class="star" disabled="disabled" '.$ch.' />';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <b>Met my expectations</b>
                                </div>
                                <div style="overflow: hidden;display: block;">
                                    <?php
                                        for($i=1;$i<=5;$i++) {
                                            $ch = '';
                                            if($i==(int)$review['expectation_rating']) {
                                                $ch='checked="checked"';
                                            }
                                            echo '<input name="star3'.$review['id'].'" type="radio" class="star" disabled="disabled" '.$ch.' />';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div style="margin-top: 5px;margin-bottom: 5px;">
                                <?php echo nl2br($review['detail']); ?>
                            </div>
                            <div>
                                <b>รีวิวโดย <?php echo $review['user_name']; ?></b>
                                เมื่อ <?php echo $review['add_date']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <?php
                if(is_user_login()) {
            ?>
            <div id="tabs_review">
                <div>
                    <?php
                        echo form_open('shop/product/'.$product_data['id']);
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'overall_rating'); ?></b>
                        </div>
                        <div id="form_row_control" style="overflow: hidden;">
                            <input class="rating" type="radio" name="chk_overall_rating" value="1"/>
                            <input class="rating" type="radio" name="chk_overall_rating" value="2"/>
                            <input class="rating" type="radio" name="chk_overall_rating" value="3"/>
                            <input class="rating" type="radio" name="chk_overall_rating" value="4"/>
                            <input class="rating" type="radio" name="chk_overall_rating" value="5"/>
                        </div>
                        <div>
                            <?php echo form_error('chk_overall_rating'); ?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'money_rating'); ?></b>
                        </div>
                        <div id="form_row_control" style="overflow: hidden;">
                            <input class="rating" type="radio" name="chk_money_rating" value="1"/>
                            <input class="rating" type="radio" name="chk_money_rating" value="2"/>
                            <input class="rating" type="radio" name="chk_money_rating" value="3"/>
                            <input class="rating" type="radio" name="chk_money_rating" value="4"/>
                            <input class="rating" type="radio" name="chk_money_rating" value="5"/>
                        </div>
                        <div>
                            <?php echo form_error('chk_money_rating'); ?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'expectation_rating'); ?></b>
                        </div>
                        <div id="form_row_control" style="overflow: hidden;">
                            <input class="rating" type="radio" name="chk_expectation_rating" value="1"/>
                            <input class="rating" type="radio" name="chk_expectation_rating" value="2"/>
                            <input class="rating" type="radio" name="chk_expectation_rating" value="3"/>
                            <input class="rating" type="radio" name="chk_expectation_rating" value="4"/>
                            <input class="rating" type="radio" name="chk_expectation_rating" value="5"/>
                        </div>
                        <div>
                            <?php echo form_error('chk_expectation_rating'); ?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'title'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="text" class="txtx" name="txt_title" />
                            <div>
                                <?php echo form_error('txt_title'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'detail'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <textarea name="txt_detail" class="txtx" style="height: 100px;width: 400px;"></textarea>
                            <div>
                                <?php echo form_error('txt_detail'); ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tab" value="2" />
                    <?php
                        if(is_user_login()==true) {
                    ?>
                    <input type="hidden" name="txt_user_id" value="<?php echo $user_datas['id']; ?>" />
                    <input type="hidden" name="txt_user_name_review" value="<?php echo $user_datas['firstname'].' '.$user_datas['lastname']; ?>" />
                    <?php
                        } else {
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'user_name'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="hidden" name="txt_user_id" value="0" />
                            <input type="text" class="txtx" name="txt_user_name_review" />
                            <div>
                                <?php echo form_error('txt_user_name_review'); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="hid_task" value="review" />
                    <input type="hidden" name="hid_product_id" value="<?php echo $product_data['id']; ?>" />
                    <div>
                        <input type="submit" name="btn_add_review" value="ส่งรีวิว" />
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php
                }
            ?>

            <!--
            <div id="tabs_media">
                <div>
                    <?php
                        echo form_open('shop/product/'.$product_data['id']);
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_media', 'title'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="text" class="txt" name="txt_title_media" />
                            <?php echo form_error('txt_title_media'); ?>
                        </div>
                    </div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_media', 'link'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="text" class="txt" name="txt_link" />
                            <?php echo form_error('txt_link'); ?>
                        </div>
                    </div>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_media', 'detail'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <textarea name="txt_detail_media" class="txt" style="height: 100px;width: 400px;"></textarea>
                            <?php echo form_error('txt_detail_media'); ?>
                        </div>
                    </div>
                    <input type="hidden" name="tab" value="3" />
                    <?php
                        if(is_user_login()==true) {
                    ?>
                    <input type="hidden" name="txt_user_id" value="<?php echo $user_datas['id']; ?>" />
                    <input type="hidden" name="txt_user_name_media" value="<?php echo $user_datas['firstname'].' '.$user_datas['lastname']; ?>" />
                    <?php
                        } else {
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'user_name'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="hidden" name="txt_user_id" value="0" />
                            <input type="text" class="txt" name="txt_user_name_media" />
                            <?php echo form_error('txt_user_name_media'); ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="hid_task" value="media" />
                    <input type="hidden" name="hid_product_id" value="<?php echo $product_data['id']; ?>" />
                    <div>
                        <input type="submit" name="btn_add_media" value="ส่งลิงค์" />
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            -->
            <div id="tabs_qa">
                <div style="margin-bottom: 5px;border-bottom: 1px solid #A2422C;">
                    <?php
                        echo form_open('shop/product/'.$product_data['id']);
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_qa', 'question'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <textarea name="txt_question" class="txtx" style="height: 100px;width: 400px;"></textarea>
                            <div>
                                <?php echo form_error('txt_question'); ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tab" value="3" />
                    <?php
                        if(is_user_login()==true) {
                    ?>
                    <input type="hidden" name="txt_user_id" value="<?php echo $user_datas['id']; ?>" />
                    <input type="hidden" name="txt_user_name_qa" value="<?php echo $user_datas['firstname'].' '.$user_datas['lastname']; ?>" />
                    <?php
                        } else {
                    ?>
                    <div class="form_row">
                        <div id="form_row_title">
                            <b><?php echo get_field_lang('shop_product_review', 'user_name'); ?></b>
                        </div>
                        <div id="form_row_control">
                            <input type="hidden" name="txt_user_id" value="0" />
                            <input type="text" class="txtx" name="txt_user_name_qa" />
                            <div>
                                <?php echo form_error('txt_user_name_qa'); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="hid_task" value="qa" />
                    <input type="hidden" name="hid_product_id" value="<?php echo $product_data['id']; ?>" />
                    <div class="form_row">
                        <input type="submit" name="btn_add_qa" value="ส่งคำถาม" />
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div>
                    <?php
                        foreach($qa_data as $qa) {
                            $user_data = $this->user_model->get_user('id', $qa['user_id']);
                    ?>
                    <div class="form_row">
                        <div class="form_row_title">
                            <b><?php echo $qa['user_name']; ?> :</b>
                            <?php echo $qa['question']; ?>
                        </div>
                        <div class="form_row_control">
                            <b><?php echo $owner_username; ?> :</b>
                            <?php echo ($qa['answer']=='') ? '-' : $qa['answer']; ?>
                        </div>
                        <!--
                        <div>
                            ถามโดย <?php echo $qa['user_name']; ?>
                            เมื่อ <?php echo $qa['add_date']; ?>
                        </div>
                        -->
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
                <?php
                    if($product_data['owner_type']=='c2c') {
                ?>
            <div id="tabs_contact">
                <div style="overflow: hidden;">
                    <div style="float: left;">
                        <?php echo form_open('shop/product/'.$product_data['id']); ?>
                            <?php
                                if(is_user_login()) {
                                    $login_info = get_login_info();
                            ?>
                            <input type="hidden" name="contact_email" value="<?php echo $login_info['email']; ?>" />
                            <?php
                                } else {
                            ?>
                            <div class="form_row">
                                <div class="form_row_title">
                                    <b>อีเมล</b>
                                </div>
                                <div class="form_row_control">
                                    <input type="text" name="contact_email" class="txtx" />
                                    <div>
                                        <?php echo form_error('contact_email'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="form_row">
                                <div class="form_row_title">
                                    <b>จำนวน</b>
                                </div>
                                <div class="form_row_control">
                                    <input type="text" name="contact_qty" class="txtx" />
                                    <div>
                                        <?php echo form_error('contact_qty'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="form_row_title">
                                    <b>ข้อความถึงผู้ขาย</b>
                                </div>
                                <div class="form_row_control">
                                    <textarea name="contact_detail" class="txtx" style="width: 400px;height: 100px;" rows="5" cols="50" ></textarea>
                                </div>
                            </div>
                            <div class="form_row">
                                <input type="submit" name="contact_submit" value="สั่งซื้อ" />
                            </div>
                            <input type="hidden" name="hid_task" value="contact" />
                            <input type="hidden" name="tab" value="4" />
                            <?php echo form_close(); ?>
                    </div>
                    <div style="float: left;margin-left: 10px;">
                        <?php
                            
                            $user_shop_data = $this->user_shop_model->get_user_shop('user_id', $product_data['owner_id']);
                            
                        ?>
                        <div class="form_row">
                            <b><?php echo get_field_lang('shop_user_shop', 'instruction'); ?></b>
                        </div>
                        <div class="form_row">
                            <?php
                                if(isset($user_shop_data['instruction']) && $user_shop_data['instruction']!='') {
                                    echo nl2br($user_shop_data['instruction']);
                                } else {
                                    echo '-';
                                }
                                
                            ?>
                        </div>

                    </div>
                </div>
            </div>
                <?php
                    }
                ?>
        </div>
    </div>
</div>