<div>
    <h2 class="heading">
        <a href="<?php echo base_url().'shop/product/'.$promotion_data['id'].'/'.url_title($promotion_data['name']); ?>" class="a_title">
            <?php echo $promotion_data['name']; ?>
        </a>
    </h2>
    <div class="prod_detail">
        <div style="margin-bottom: 20px;">
            <ul style="overflow: hidden;list-style: none;margin-bottom: 10px;">
                <li style="float: left;width: 120px;">
                    <?php echo get_field_lang('shop_promotion', 'real_price'); ?>
                </li>
                <li style="float: left;">
                    <span style="text-decoration: line-through;">
                        <?php echo $promotion_data['cost']; ?>
                    </span>
                </li>
            </ul>
            <ul style="overflow: hidden;list-style: none;">
                <li style="float: left;width: 120px;">
                    <?php echo get_field_lang('shop_promotion', 'pro_price'); ?>
                </li>
                <li style="float: left;">
                    <b style="color: red;"><?php echo $promotion_data['price']; ?></b>
                </li>
            </ul>
        </div>
        <h2 style="margin-bottom: 10px;">สินค้า</h2>
        <?php
            foreach($promotion_item_data as $p) {
                $product = $this->product_model->get_product('id',$p['product_id']);
        ?>
        <div style="margin-bottom: 10px;">
            <div>
                <img src="<?php echo assets_product($product['image'], $product['owner_type']);?>" alt="" class="image0" style="width: 50px;" />
            </div>
            <div>
                <?php echo anchor('shop/product/'.$product['id'].'/'. $product['name'],  $product['name']); ?>
                ราคา
                <?php echo $product['price']; ?> บาท
            </div>
        </div>
        <?php
            }
        ?>
    </div>
    <?php echo form_open('shop/shop/add_cart'); ?>
        <?php
            if($product_data['owner_type']!='c2c') {
        ?>
        <input type="hidden" name="hid_id" value="<?php echo $product_data['id']; ?>" />
        <input type="hidden" name="hid_current_url" value="<?php echo current_url(); ?>" />
        <!--
        <input type="submit" name="btn_add_cart" class="button" value="ใส่ตะกร้า" />
        -->
        <a href="#" class="button" onclick="javascript:$(this).parent('form').submit();"><span>Buy Now</span></a>
        <button style="display: none;" type="submit" type="submit" name="btn_add_cart" class="btn_add_cart" value="ใส่ตะกร้า" ></button>
        <?php
            }
        ?>
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