<!-- Header Start -->
<div id="header">
    <!-- Logo Start -->
    <div class="logo">
        <!--<a href="index.html">&nbsp;<span class="dis_none">Estore 3</span></a>-->
        <a href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_image('logo.png'); ?>" alt="Glixa" />
        </a>
    </div>
    <!-- Logo End -->
    <!-- Cart and Top Navigation Section Start -->
    <div class="cart_topnavi">
        <!-- Cart Tab Start -->
        <div class="cart_tab">
            <div class="left_curv">&nbsp;</div>
            <div class="center_curv">
                <ul>
                    <li class="bag bold">
                        <?php echo anchor('shop/cart', 'Shopping Cart'); ?>
                    </li>
                    <li class="items">
                        <?php echo anchor('shop/cart', $this->cart->total_items().' items'); ?>
                    </li>
                    <li class="price">
                        <?php echo anchor('shop/cart', currency($this->cart->total()).' Bath'); ?>
                    </li>
                </ul>
            </div>
            <div class="right_curv">&nbsp;</div>
        </div>
        <div class="clear"></div>
        <!-- Cart Tab End -->
        <div class="topnavi">
            <ul>
                <li>
                        <?php
                            if(is_user_login ()) {
                                $login_info = get_login_info();
                                $user_data = $this->user_model->get_user('email', $login_info['email']);
                                //echo anchor($user_data['username'], 'My Shop');
                        ?>
                    <a href="<?php echo base_url().$user_data['username'] ?>">
                        <img  src="<?php echo assets_image('icon_shop.png'); ?>" />
                        My Shop
                    </a>
                        <?php
                            }
                         ?>
                </li>
                <li style="">
                    <a href="http://www.facebook.com/pages/Glixa/156896694346240">
                        <img  src="<?php echo assets_image('icon_facebook.png'); ?>" />
                        Facebook
                    </a>
                </li>
                <li style="">
                    <a href="http://www.twitter.com">
                        <img src="<?php echo assets_image('icon_twitter.png'); ?>" />
                        Twitter
                    </a>
                </li>
                <li style="" class="last">
                    <a href="http://www.youtube.com">
                        <img src="<?php echo assets_image('icon_youtube.png'); ?>"/>
                        Youtube
                    </a>
                </li>
                <!--
                <li><?php echo anchor('shop/cart', 'My Cart'); ?></li>
                <li class="last"><?php echo anchor('shop/checkout', 'Checkout'); ?></li>
                -->
            </ul>
        </div>
        <!-- Cart Tab End -->
    </div>
    <!-- Cart and Top Navigation Section Start -->
</div>  
<!-- Header End -->
<!-- Navi Start -->
<div id="navi">
    <!-- Navigation Start -->
    <div class="navigation">
        <div id="smoothmenu1" class="ddsmoothmenu">
            <ul>
                <li class="icon">
                    <a href="<?php echo base_url(); ?>">&nbsp;<span class="dis_none">Home</span></a>
                </li>
                <!--
                <li>
                    <?php echo anchor('shop', 'SHOP'); ?>
                </li>
                -->
                <li>
                    <?php echo anchor('shop/glixa_guarantee', 'GLIXA GUARANTEE'); ?>
                </li>
                <li>
                    <?php echo anchor('shop/shopping', 'SHOPPING'); ?>
                </li>
                <li>
                    <?php echo anchor('shop/promotion', 'PROMOTION'); ?>
                </li>
                <li>
                    <?php echo anchor('contact', 'CONTACT US'); ?>
                </li>
                <?php
                    $login_info = get_login_info();
                    if($login_info['level']=='admin' || $login_info['level']=='super_admin') {
                ?>
                <li><?php echo anchor('admin', 'ADMIN'); ?></li>
                <?php
                    }
                ?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <!-- Navigation End -->
    <!-- Flags and currencies Start -->
    <div class="flags_currencies">
        <ul>
            <li>
            </li>
        </ul>
    </div>
    <!-- Flags and currencies End -->
</div>
<!-- Navi End -->