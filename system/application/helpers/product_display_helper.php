<?php
    /*
     * Generate Product Row
     * return product row
     */
    function row_product($product_data) {
        echo '<div class="prod_listing"><ul>';
        for($i=0;$i<count($product_data);$i++) {
            echo '<li>';
            echo item_product($product_data[$i]);
            echo '</li>';
        }
        echo '</ul></div>';
    }
    function item_product($product_data) {
?>
    <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>">
        <img src="<?php
                        if($product_data['image']!='') {
                            echo assets_product($product_data['image'],$product_data['owner_type']);
                        } else {
                            echo base_url().'assets/image/product.png';
                        }
                    ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
    </a>
    <h2 class="title" style="margin-bottom: 3px;">
        <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>" class="a_title" style="font-size: smaller;">
            <?php echo $product_data['name']; ?>
        </a>
    </h2>
    <div class="price bold" style="margin-bottom: 3px;">
        ราคา <?php echo currency($product_data['price']); ?> บาท
    </div>
    <div style="margin-bottom: 3px;">
        <?php
            if($product_data['owner_type']!='c2c') {
        ?>
        <?php
            $CI =& get_instance();
            $product_option_data = $CI->product_option_model->get_product_option('','',' product_id="'.$product_data['id'].'"');
            if(count($product_option_data)>0) { // have option
        ?>
        <a href="javascript:void(0);" class="button quick_view" onclick="quick_view(<?php echo $product_data['id']; ?>);" ><span>Quick View</span></a>
            <div style="display: none;">
                <div id="quick_view<?php echo $product_data['id']; ?>" style="background-color: white;padding: 5px 5px 5px 5px;">
                    <div>
                        กรุณาเลือกลักษณะของสินค้าที่ต้องการ
                    </div>
                    <?php echo form_open('shop/shop/add_cart', array('id'=>'frm_buy_'.$product_data['id'])); ?>
                    <table style="margin-bottom: 5px;margin-top: 5px;">
                        <?php
                            foreach($product_option_data as $option) {
                        ?>
                            <tr>
                                <td style="min-width: 100px;">
                                    <b><?php echo $option['options']; ?></b>
                                </td>
                                <td>
                                    <select style="width: 150px;" name="ddl_option[]">
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
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                        </table>
                        <div>
                            <input type="hidden" name="hid_id" value="<?php echo $product_data['id']; ?>" />
                            <input type="hidden" name="hid_current_url" value="<?php echo current_url(); ?>" />
                            <a href="javascript:void(0);" class="button" onclick="javascript:$('#frm_buy_<?php echo $product_data['id']; ?>').submit();"><span>Buy Now</span></a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        <?php
            } else {
        ?>
        <?php echo form_open('shop/shop/add_cart', array('id'=>'frm_buy_'.$product_data['id'])); ?>
            <input type="hidden" name="hid_id" value="<?php echo $product_data['id']; ?>" />
            <input type="hidden" name="hid_current_url" value="<?php echo current_url(); ?>" />
            <a href="javascript:void(0);" class="button" onclick="javascript:$(this).parent('form').submit();"><span>Buy Now</span></a>
            <button style="display: none;" type="submit" type="submit" name="btn_add_cart" class="btn_add_cart" value="ใส่ตะกร้า" >
            </button>
        <?php echo form_close(); ?>
        <?php
            }
        ?>
        <?php
            } else {
                $CI =& get_instance();
                $CI->load->model('user_model');
                $user_data = $CI->user_model->get_user('id',$product_data['owner_id']);
                echo anchor($user_data['username'],$user_data['username']);
            }
        ?>
    </div>
<?php
    }
?>
<?php
    /*
     * Generate Product Row สำหรับ User เจ้าของสินค้า
     * return product row
     */
    function row_user_product($product_data, $user_level) {
        echo '<div class="prod_listing"><ul>';
        for($i=0;$i<count($product_data);$i++) {
            echo '<li style="height:230px;">';
            echo item_user_product($product_data[$i], $user_level);
            echo '</li>';
        }
        echo '</ul></div>';
    }
    function item_user_product($product_data, $user_level) {
?>
        <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>">
            <img src="<?php
                if($product_data['image']!='') {
                    echo assets_product($product_data['image'],$product_data['owner_type']);
                } else {
                    echo base_url().'assets/image/product.png';
                }
            ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
        </a>
        <h2 class="title" style="margin-bottom: 3px;">
            <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>" class="a_title" style="font-size: smaller;">
                <?php echo $product_data['name']; ?>
            </a>
        </h2>
        <div class="price bold" style="margin-bottom: 3px;">
            ราคา <?php echo currency($product_data['price']); ?> บาท
        </div>
        <div style="margin-bottom: 3px;">
        <?php
            if($user_level!='supplier') {
                echo anchor('user/edit_product/'.$product_data['id'], 'แก้ไข');
                echo " | ";
                echo "<a href='javascript:del_product(".$product_data['id'].");'>ลบ</a>";
            }
        ?>
        </div>
<?php
    }
?>














<?php
    /*
     * Generate Product Row
     * return product row
     */
    function _row_product($product_data) {
        echo '<div class="project-gallery"><ul>';
        // จำนวน item ที่จะแสดงในแต่ละ row
        $item_per_row = 3;
        $j = 0;
        for($i=0;$i<count($product_data);$i++) {
            if($j==2) {
                echo '<li class="last">';
            } else {
                echo '<li>';
            }
            echo item_product($product_data[$i]);
            echo '</li>';
            if($j==2) {
                $j = 0;
            } else {
                $j++;
            }
        }
        echo '</ul><div class="cl">&nbsp;</div></div>';
    }
    function _item_product($product_data) {
?>
        <div class="project-thumb" style="display: table-cell;vertical-align: middle;text-align: center;">
            <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>">
                <img src="<?php
                    if($product_data['image']!='') {
                        echo assets_product($product_data['image'],$product_data['owner_type']);
                    } else {
                        echo base_url().'assets/image/product.png';
                    }
                ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
            </a>
        </div>
        <div class="project-title">
            <h6>
                <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>" class="a_title">
                    <?php echo $product_data['name']; ?>
                </a>
            </h6>
            <p>
                ราคา <?php echo currency($product_data['price']); ?> บาท
            </p>
            <p>
                <?php
                    if($product_data['owner_type']!='c2c') {
                ?>
                <?php echo form_open('shop/shop/add_cart'); ?>
                <input type="hidden" name="hid_id" value="<?php echo $product_data['id']; ?>" />
                <input type="hidden" name="hid_current_url" value="<?php echo current_url(); ?>" />
                <input type="submit" name="btn_add_cart" value="ใส่ตะกร้า" />
                <?php echo form_close(); ?>
                <?php
                    } else {
                        $CI =& get_instance();
                        $CI->load->model('user_model');
                        $user_data = $CI->user_model->get_user('id',$product_data['owner_id']);
                        echo $user_data['firstname'].' '.$user_data['lastname'];
                    }
                ?>
            </p>
            <p>
                <?php echo anchor('shop/product/'.$product_data['id'].'/'.url_title($product_data['name']), 'ดูรายละเอียด'); ?>
            </p>
        </div>
<?php
    }
?>

<?php
    /*
     * Generate Product Row สำหรับ User เจ้าของสินค้า
     * return product row
     */
    function _row_user_product($product_data, $user_level) {
        echo '<div class="project-gallery"><ul>';
        // จำนวน item ที่จะแสดงในแต่ละ row
        $item_per_row = 3;
        $j = 0;
        for($i=0;$i<count($product_data);$i++) {
            if($j==2) {
                echo '<li class="last">';
            } else {
                echo '<li>';
            }
            echo item_user_product($product_data[$i], $user_level);
            echo '</li>';
            if($j==2) {
                $j = 0;
            } else {
                $j++;
            }
        }
        echo '</ul><div class="cl">&nbsp;</div></div>';
    }
    function _item_user_product($product_data, $user_level) {
?>
        <div class="project-thumb" style="display: table-cell;vertical-align: middle;text-align: center;">
            <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>">
                <img src="<?php
                    if($product_data['image']!='') {
                        echo assets_product($product_data['image'],$product_data['owner_type']);
                    } else {
                        echo base_url().'assets/image/product.png';
                    }
                ?>" alt="<?php echo $product_data['name']; ?>" class="img_product" />
            </a>
        </div>
        <div class="project-title">
            <h6>
                <a href="<?php echo base_url().'shop/product/'.$product_data['id'].'/'.url_title($product_data['name']); ?>" class="a_title">
                    <?php echo $product_data['name']; ?>
                </a>
            </h6>
            <p>
                ราคา <?php echo currency($product_data['price']); ?> บาท
            </p>
            <p>
                จำนวน 
                <?php
                    echo $product_data['quantity'].' ';
                    echo $product_data['unit'];
                ?>
            </p>
            <p>
            <?php
                if($user_level!='supplier') {
                    echo anchor('user/edit_product/'.$product_data['id'], 'แก้ไข');
                }
            ?>
            </p>
        </div>
<?php
    }
?>