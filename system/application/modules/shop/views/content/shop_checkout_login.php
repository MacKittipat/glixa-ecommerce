<script type="text/javascript" src="<?php echo assets_js('currency/jquery.formatCurrency-1.4.0.pack.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_js('currency/i18n/jquery.formatCurrency.all.js'); ?>"></script>
<h2 class="heading"><?php echo $page_title; ?></h2>
<div>
    <div id="according_checkout">
        <!-- Billing -->
        <div id="billing">
            <div id="billing_title" class="title">
                <b>Billing Details</b>
                <span>
                    <a id="billing_modify" style="display: none;" href="javascript:void(0);" onclick="modify(this.id)">Modify</a>
                </span>
            </div>
            <div id="billing_content" class="content">
                <div id="billing_content1">
                    <?php
                        $rad_billing2 = '';
                        if(count($user_address_data)>0) {
                    ?>
                    <div>
                        <input type="radio" name="rad_billing" id="rad_billing1" checked />
                        <label for="rad_billing1">I want to use an existing billing address</label>
                    </div>
                    <div id="billing_sub_content1">
                        <div>
                            <select id="ddl_billing1" style="width: 600px;padding: 3px 3px 3px 3px;" size="5">
                            <?php
                                $i = 1;
                                foreach($user_address_data as $address) {
                            ?>
                                <option <?php if($i==1){ echo 'selected'; }  ?> value="<?php echo $address['id']; ?>" >
                                    <?php
                                        echo $address['firstname'].' '.$address['lastname'].', '.$address['address'].', '.$address['tambon'].' '.$address['amphoe'].', '.$address['province'].', '.$address['postalcode'];
                                        $i++;
                                    ?>
                                </option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                        <div>
                            <input type="checkbox" id="chk_billing1" checked />
                            <label for="chk_billing1">I also want to ship to this address</label>
                        </div>
                        <div>
                            <input type="button" id="btn_billing1" value="Bill & Ship to this Address" />
                        </div>
                    </div>
                    <?php
                        } else {
                            $rad_billing2 ='checked';
                        }
                    ?>
                </div>
                <div id="billing_content2">
                    <div>
                        <input type="radio" name="rad_billing" id="rad_billing2" <?php echo $rad_billing2; ?> />
                        <label for="rad_billing2">I want to use a new billing address</label>
                    </div>
                    <div id="billing_sub_content2"
                         <?php
                            if(count($user_address_data)>0) {
                                echo 'style="display: none;"';
                            }
                         ?>
                         >
                        <?php
                            echo form_open('shop/checkout', array('id'=>'frm_billing2'));
                        ?>
                        <div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'firstname'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_firstname" id="txt_firstname" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'lastname'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_lastname" id="txt_lastname" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'address'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_address" id="txt_address" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'tambon'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_tambon" id="txt_tambon" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'amphoe'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_amphoe" id="txt_amphoe" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'province'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_province" id="txt_province" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'postalcode'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_postalcode" id="txt_postalcode" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'tel_num'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_tel_num" id="txt_tel_num" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'fax_num'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_fax_num" id="txt_fax_num" />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" id="chk_billing2" checked />
                                    <label for="chk_billing2">I also want to ship to this address</label>
                                </div>
                                <div>
                                    <input type="submit" id="btn_billing2" value="Bill & Ship to this Address" />
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- End Billing -->
        <!-- Shipping -->
        <div id="shipping">
            <div id="shipping_title" class="title">
                <b>Shipping Details</b>
                <span>
                    <a id="shipping_modify" style="display: none;" href="javascript:void(0);" onclick="modify(this.id)">Modify</a>
                </span>
            </div>
            <div id="shipping_content" class="content" style="display: none;">
                <div id="shipping_content1">
                    <?php
                        $rad_shipping2 = '';
                        if(count($user_address_data)>0) {
                    ?>
                    <div>
                        <input type="radio" name="rad_shipping" id="rad_shipping1" checked />
                        <label for="rad_shipping1">I want to use an existing shipping address</label>
                    </div>
                    <div id="shipping_sub_content1">
                        <div>
                            <select id="ddl_shipping1" style="width: 600px;padding: 3px 3px 3px 3px;" size="5">
                            <?php
                                $i = 1;
                                foreach($user_address_data as $address) {
                            ?>
                                <option <?php if($i==1){ echo 'selected'; }  ?> value="<?php echo $address['id']; ?>" >
                                    <?php
                                        echo $address['firstname'].' '.$address['lastname'].', '.$address['address'].', '.$address['tambon'].' '.$address['amphoe'].', '.$address['province'].', '.$address['postalcode'];
                                        $i++;
                                    ?>
                                </option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                        <div>
                            <input type="button" id="btn_shipping1" value="Ship to this Address" />
                        </div>
                    </div>
                    <?php
                        } else {
                            $rad_shipping2 ='checked';
                        }
                    ?>
                </div>
                <div id="shipping_content2">
                    <div>
                        <input type="radio" name="rad_shipping" id="rad_shipping2" <?php echo $rad_shipping2; ?> />
                        <label for="rad_shipping2">I want to use a new shipping address</label>
                    </div>
                    <div id="shipping_sub_content2"
                         <?php
                            if(count($user_address_data)>0) {
                                echo 'style="display: none;"';
                            }
                         ?>
                         >
                        <div>
                            <?php
                                echo form_open('shop/checkout', array('id'=>'frm_shipping2'));
                            ?>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'firstname'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_firstname" id="txt_firstname" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'lastname'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_lastname" id="txt_lastname" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'address'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_address" id="txt_address" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'tambon'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_tambon" id="txt_tambon" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'amphoe'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_amphoe" id="txt_amphoe" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'province'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_province" id="txt_province" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'postalcode'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_postalcode" id="txt_postalcode" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'tel_num'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_tel_num" id="txt_tel_num" />
                                </div>
                            </div>
                            <div class="form_row">
                                <div id="form_row_title">
                                    <b><?php echo get_field_lang('shop_user_address', 'fax_num'); ?></b>
                                </div>
                                <div id="form_row_control">
                                    <input type="text" name="txt_fax_num" id="txt_fax_num" />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="submit" id="btn_shipping2" value="Ship to this Address" />
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Shipping -->
        <!-- Shipping Method -->
        <div id="shipping_method">
            <div id="shipping_medthod" class="title">
                <b>Shipping Method</b>
                <span>
                    <a id="shipping_method_modify" style="display: none;" href="javascript:void(0);" onclick="modify(this.id)">Modify</a>
                </span>
            </div>
            <div id="shipping_method_content" class="content" style="display: none;">
                <div>
                    <div>
                        <input type="radio" name="rad_shipping_method" id="rad_shipping_method1" checked />
                        <label for="rad_shipping_method1">ไปรษณ๊ย์</label>
                    </div>
                    <div>
                        <input type="radio" name="rad_shipping_method" id="rad_shipping_method2" />
                        <label for="rad_shipping_method2">ด่วน</label>
                    </div>
                </div>
                <div>
                    <input type="button" id="btn_shipping_method" value="Continue" />
                </div>
            </div>
        </div>
        <!-- End Shipping Method -->
        
        <!-- Payment Method -->
        <div id="payment_method">
            <div id="payment_method" class="title">
                <b>Payment Method</b>
                <span>
                    <a id="payment_method_modify" style="display: none;" href="javascript:void(0);" onclick="modify(this.id)">Modify</a>
                </span>
            </div>
            <div id="payment_method_content" class="content" style="display: none;">
                <div>
                    <b>ชำระเงินกับ</b>
                </div>
                <div>
                    <input type="radio" id="rad_payment_glixa" name="rad_payment_detail" value="glixa" checked />
                    <label for="rad_payment_glixa">Glixa</label>
                    <!--
                    <input type="radio" id="rad_payment_paypal" name="rad_payment_detail" value="paypal" />
                    <label for="rad_payment_paypal">Paypal</label>
                    -->
                </div>
                <div>
                    <input type="button" id="btn_payment_method" value="Continue" />
                </div>
            </div>
       </div>
        <!-- End Payment Method -->
        
        <!-- Payment -->
        <div id="payment">
            <div id="payment" class="title">
                <b>Payment</b>
            </div>
            <div id="payment_content" class="content" style="display: none;">
                <div>
                    <table class="table_data" border="1">
                        <thead>
                            <tr>
                                <th style="width: 200px;">
                                    ชื่อสินค้า
                                </th>
                                <th style="width: 120px;">
                                    ราคาต่อ 1 หน่วย
                                </th>
                                <th style="width: 150px;">
                                    จำนวน
                                </th>
                                <th style="width: 120px;">
                                    ราคารวม (บาท)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <b style="font-size: 18px;">
                                        Gold
                                    </b>
                                </td>
                            </tr>
                            <?php

                                $count_deliver = 0;
                                $total_p = array();
                                $total_deliver_price = 0;
                                $cart_product = array();
                                $a_owner_types = array();
                                $total_price = 0;
                                $gold_total_p = 0;
                                foreach($this->cart->contents() as $item) {
                                    $product_data = $this->product_model->get_product('id',$item['id']);
                                    $supplier_data = $this->supplier_model->get_supplier('id',$product_data['owner_id']);
                                    if($product_data['owner_type']=='b2c') { // b2c 
                                        $a_owner_types['b2c'][] = $product_data;
                            ?>
                            <tr>
                                <td>
                                    <?php echo anchor('shop/product/'.$product_data['id'].'/'.$product_data['name'], $product_data['name']); ?>
                                    <!--
                                    -
                                    <?php echo $supplier_data['name']; ?>
                                    -->
                                </td>
                                <td>
                                    <?php echo  "฿".$item['price']; ?>
                                </td>
                                <td>
                                    <?php echo $item['qty']; ?>
                                </td>
                                <td>
                                    <?php echo "฿".currency((float)$item['price']*(float)$item['qty']); ?>
                                </td>
                            </tr>
                            <?php
                                        $total_price += (float)$item['price']*(float)$item['qty'];
                                        $gold_total_p += (float)$item['price']*(float)$item['qty'];

                                    }
                                    
                                }
                                $total_p[] = $gold_total_p;
                            ?>
                                <tr>
                                    <td colspan="3">
                                        <span id="shipping_name_<?php echo $count_deliver; ?>">
                                            ค่าขนส่ง  - Gold
                                        </span>
                                    </td>
                                    <td>
                                        <span id="shipping_price_<?php echo $count_deliver; ?>"></span>
                                    </td>
                                </tr>
                            <?php
                            $silver_total_p = 0;
                                $supp = array();
                                foreach($this->cart->contents() as $item) {
                                    $product_data = $this->product_model->get_product('id',$item['id']);
                                    $supplier_data = $this->supplier_model->get_supplier('id',$product_data['owner_id']);
                                    if($product_data['owner_type']=='silver') { // silver
                                        $supp[] = $supplier_data['name'];
                                    }
                                }
                                $supp = array_unique($supp);
                                foreach($supp as $value) {
                                    foreach($this->cart->contents() as $item) {
                                        $product_data = $this->product_model->get_product('id',$item['id']);
                                        $supplier_data = $this->supplier_model->get_supplier('id',$product_data['owner_id']);
                                        if($supplier_data['name']==$value && $product_data['owner_type']=='silver') {
                                            $cart_product[$value][] = $item;
                                        }
                                    }
                                }
                                //echo "<pre>";
                                //print_r($cart_product);
                                foreach($cart_product as $key => $item) {
                                    $silver_total_p = 0;
                                    $product_data = $this->product_model->get_product('id',$item[0]['id']);
                            ?>
                            <tr>
                                <td colspan="4">
                                    <b style="font-size: 18px;">
                                        Silver
                                    </b>
                                    -
                                    <?php echo $key; ?>
                                </td>
                            </tr>
                                <?php
                                    foreach($item as $p) {
                                    
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                            $product_data = $this->product_model->get_product('id',$p['id']);
                                            echo anchor('shop/product/'.$product_data['id'].'/'.$product_data['name'], $product_data['name']);
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo  "฿".$p['price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $p['qty']; ?>
                                    </td>
                                    <td>
                                        <?php echo "฿".currency((float)$p['price']*(float)$p['qty']); ?>
                                    </td>
                                </tr>
                                <?php
                                        $total_price += (float)$p['price']*(float)$p['qty'];
                                        $silver_total_p += (float)$p['price']*(float)$p['qty'];
                                    }
                                    $total_p[] = $silver_total_p; // เก็บ total prrice ของแต่ละ gold หรือ silver เพื่อมาคำนวน devlier price ของแต่ละอัน
                                    $count_deliver++;
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <span id="shipping_name_<?php echo $count_deliver; ?>">
                                            ค่าขนส่ง - <?php echo $key; ?>
                                        </span>
                                        
                                    </td>
                                    <td>
                                        <span id="shipping_price_<?php echo $count_deliver; ?>"></span>
                                    </td>
                                </tr>
                            <?php
                                }
                                //echo "<pre>";
                                //print_r($total_p);
                            ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">ราคารวมทั้งหมด</td>
                                <td>
                                    <span id="new_total_price" style="font-weight: bolder;"><?php echo ($total_price); ?></span>
                                    <input type="hidden" id="total_price" value="<?php echo $total_price; ?>" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div style="margin-top: 10px;overflow: hidden;">
                    <div>
                        <input type="button" name="btn_submit_checkout" id="btn_submit_checkout" value="Checkout" />
                    </div>
                    
                    <div>
                        <?php
                            echo form_open('shop/checkout',array('id'=>'frm_payment_glixa'));
                        ?>
                        <!--
                        <input type="button" name="btn_submit_checkout" id="btn_submit_checkout" value="Checkout" />
                        -->
                        <?php echo form_close(); ?>
                    </div>
                    <?php //echo $this->paypal_lib->paypal_form(); ?>
                    <div>
<!--
                        <form id="_frm_payment_paypal" action="<?php echo $this->config->item('paypal_url'); ?>" method="post">
                        <!--<form id="frm_payment_paypal" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="image_url" value="<?php echo assets_image('logo.png') ?>">
                            <input type="hidden" name="cmd" value="_cart">
                            <input type="hidden" name="upload" value="1">
                            <input type="hidden" name="charset" value="utf-8">
                            <input type="hidden" name="business" value="<?php echo $this->config->item('paypal_email'); ?>">
                            <input type="hidden" name="currency_code" value="THB">
                            <input type="hidden" name="return" value="<?php echo site_url('shop/checkout_summary'); ?>" />
                            <input type="hidden" name="cancel_return" value="<?php echo site_url('shop/checkout'); ?>" />
                            <input type="hidden" name="notify_url" value="http://127.0.0.1/Wive/shop/ipn" />
                            <?php
                                $index = 1;
                                foreach($this->cart->contents() as $item) {
                                    $prod = $this->product_model->get_product('id', $item['id']);
                            ?>
                            <?php
                                $opt = '';
                                if(isset($item['options'])) {
                                    $opt .= '(';
                                    foreach($item['options'] as $key => $val) {
                                        $opt .= $key.':'.$val.',';
                                    }
                                    $opt = substr($opt, 0, -1);
                                    $opt .= ')';
                                }
                            ?>
                            <input type="hidden" name="item_name_<?php echo $index; ?>" value="<?php echo $item['name'] . $opt; ?>">
                            <input type="hidden" name="quantity_<?php echo $index; ?>" value="<?php echo $item['qty']; ?>">
                            <input type="hidden" name="amount_<?php echo $index; ?>" value="<?php echo $item['price']; ?>">
                            <?php
                                    $index++;
                                }
                            ?>
                            <input type="hidden" name="item_name_<?php echo $index; ?>" value="ค่าขนส่ง">
                            <input type="hidden" name="quantity_<?php echo $index; ?>" value="1">
                            <input type="hidden" id="paypal_shipping" name="amount_<?php echo $index; ?>" value="">
                            <!--
                            <input type="submit" value="Checkout at PayPal">
                        </form>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo assets_js('jquery_validation/jquery.validate.js'); ?>"></script>
<script type="text/javascript">
    function modify(th) {
        $("#according_checkout .content").hide();
        $("#"+th).parent().parent().next().show();
    }
    $(document).ready(function() {
        $("#frm_billing2").validate({
            rules:{
                txt_firstname: {
                    required:true
                },
                txt_lastname: {
                    required:true
                },
                txt_address: {
                    required:true
                },
                txt_tambon: {
                    required:true
                },
                txt_amphoe: {
                    required:true
                },
                txt_province: {
                    required:true
                },
                txt_postalcode: {
                    required:true,
                    number:true
                },
                txt_tel_num: {
                    required:true,
                    number:true
                },
                txt_fax_num: {
                    number:true
                }
            }, submitHandler:function() {
                if($("#billing #btn_billing2").val()=="Bill to this address") { // go Shipping
                    // *** Click Bill to this address หลังจากเพิ่มที่อยู่ใหม่ของ Billing
                    $.post("<?php echo base_url(); ?>shop/checkout_billing" ,{
                        'ajax':'true',
                        'step':'billing2',
                        'goto':'shipping',
                        'firstname':$("#billing #txt_firstname").val(),
                        'lastname':$("#billing #txt_lastname").val(),
                        'address':$("#billing #txt_address").val(),
                        'tambon':$("#billing #txt_tambon").val(),
                        'amphoe':$("#billing #txt_amphoe").val(),
                        'province':$("#billing #txt_province").val(),
                        'postalcode':$("#billing #txt_postalcode").val(),
                        'tel_num':$("#billing #txt_tel_num").val(),
                        'fax_num':$("#billing #txt_fax_num").val()
                    }, function(data) {
                        $("#billing #billing_content").hide();
                        $("#shipping #shipping_content").show();
                        // show modify
                        $("#billing #billing_modify").show();
                    });
                } else { // go Shipping Method
                    // *** Click Bill & Shipping to this address หลังจากเพิ่มที่อยู่ใหม่ของ Billing
                    $.post("<?php echo base_url(); ?>shop/checkout_billing" ,{
                        'ajax':'true',
                        'step':'billing2',
                        'goto':'shipping_method',
                        'firstname':$("#billing #txt_firstname").val(),
                        'lastname':$("#billing #txt_lastname").val(),
                        'address':$("#billing #txt_address").val(),
                        'tambon':$("#billing #txt_tambon").val(),
                        'amphoe':$("#billing #txt_amphoe").val(),
                        'province':$("#billing #txt_province").val(),
                        'postalcode':$("#billing #txt_postalcode").val(),
                        'tel_num':$("#billing #txt_tel_num").val(),
                        'fax_num':$("#billing #txt_fax_num").val()
                    }, function(data) {
                        $("#billing #billing_content").hide();
                        $("#shipping_method #shipping_method_content").show();
                        // show modify
                        $("#billing #billing_modify").show();
                        $("#shipping #shipping_modify").show();
                    });
                }
            }
        });
        $("#frm_shipping2").validate({
            rules:{
                txt_firstname: {
                    required:true
                },
                txt_lastname: {
                    required:true
                },
                txt_address: {
                    required:true
                },
                txt_tambon: {
                    required:true
                },
                txt_amphoe: {
                    required:true
                },
                txt_province: {
                    required:true
                },
                txt_postalcode: {
                    required:true,
                    number:true
                },
                txt_tel_num: {
                    required:true,
                    number:true
                },
                txt_fax_num: {
                    number:true
                }
            }, submitHandler: function() {
                $.post("<?php echo base_url(); ?>shop/checkout_shipping", {
                    'ajax':'true',
                    'step':'shipping2',
                    'goto':'shipping_method',
                    'firstname':$("#shipping #txt_firstname").val(),
                    'lastname':$("#shipping #txt_lastname").val(),
                    'address':$("#shipping #txt_address").val(),
                    'tambon':$("#shipping #txt_tambon").val(),
                    'amphoe':$("#shipping #txt_amphoe").val(),
                    'province':$("#shipping #txt_province").val(),
                    'postalcode':$("#shipping #txt_postalcode").val(),
                    'tel_num':$("#shipping #txt_tel_num").val(),
                    'fax_num':$("#shipping #txt_fax_num").val()
                }, function(data) {

                    $("#shipping #shipping_content").hide();
                    $("#shipping_method #shipping_method_content").show();
                    // show modify
                    $("#billing #billing_modify").show();
                    $("#shipping #shipping_modify").show();
                });
            }
        });
        // Billing
        $("#billing #rad_billing1").change(function(){
            if($(this).is(":checked")==true) {
                $("#billing #billing_sub_content2").hide();
                $("#billing #billing_sub_content1").show();
            }
        });
        $("#billing #rad_billing2").change(function(){
            if($(this).is(":checked")==true) {
                $("#billing #billing_sub_content1").hide();
                $("#billing #billing_sub_content2").show();
            }
        });
        $("#billing #chk_billing1").change(function() {
            if($(this).is(":checked")==true) {
                $("#billing #btn_billing1").val('Bill & Ship to this address');
            } else {
                $("#billing #btn_billing1").val('Bill to this address');
            }
        });
        $("#billing #chk_billing2").change(function() {
            if($(this).is(":checked")==true) {
                $("#billing #btn_billing2").val('Bill & Ship to this address');
            } else {
                $("#billing #btn_billing2").val('Bill to this address');
            }
        });
        $("#billing #btn_billing1").click(function() { // I want to use an existing billing address
            if($(this).val()=="Bill to this address") { // go Shipping
                // *** Click Bill to this address หลังจากเลือกที่อยู่ของ Billing
                $.post("<?php echo base_url(); ?>shop/checkout_billing" ,{
                    'ajax':'true',
                    'step':'billing1',
                    'goto':'shipping',
                    'value':$("#billing #ddl_billing1").val()
                }, function(data) {
                    $("#billing #billing_content").hide();
                    $("#shipping #shipping_content").show();
                    // show modify
                    $("#billing #billing_modify").show();
                });
            } else { // go Shipping Method
                // *** Click Bill & Shipping to this address หลังจากเลือกที่อยู่ของ Billing
                $.post("<?php echo base_url(); ?>shop/checkout_billing" ,{
                    'ajax':'true',
                    'step':'billing1',
                    'goto':'shipping_method',
                    'value':$("#billing #ddl_billing1").val()
                }, function(data) {
                    $("#billing #billing_content").hide();
                    $("#shipping_method #shipping_method_content").show();
                    // show modify
                    $("#billing #billing_modify").show();
                    $("#shipping #shipping_modify").show();
                });
            }
        });
        // Shipping
        $("#shipping #rad_shipping1").change(function(){
            if($(this).is(":checked")==true) {
                $("#shipping #shipping_sub_content2").hide();
                $("#shipping #shipping_sub_content1").show();
            }
        });
        $("#shipping #rad_shipping2").change(function(){
            if($(this).is(":checked")==true) {
                $("#shipping #shipping_sub_content1").hide();
                $("#shipping #shipping_sub_content2").show();
            }
        });
        $("#shipping #btn_shipping1").click(function() { // I want to use an existing shipping address
            $.post("<?php echo base_url(); ?>shop/checkout_shipping", {
                'ajax':'true',
                'step':'shipping1',
                'goto':'shipping_method',
                'value':$("#shipping #ddl_shipping1").val()
            }, function(data) {

                $("#shipping #shipping_content").hide();
                $("#shipping_method #shipping_method_content").show();
                // show modify
                $("#billing #billing_modify").show();
                $("#shipping #shipping_modify").show();
            });
        });
        // Shipping Method
        $("#shipping_method #btn_shipping_method").click(function() {
            var value = '';
            if($("#shipping_method #rad_shipping_method1").is(":checked")) {
                value = 'mail';
            } else {
                value = 'ems';
            }
            $.post("<?php echo base_url(); ?>shop/checkout_shipping_method", {
                'ajax':'true',
                'value':value
            }, function(data) {
                $("#shipping_method #shipping_method_content").hide();
                $("#payment_method #payment_method_content").show();

                //$("#payment #payment_content").show();
      
                // show modify
                $("#billing #billing_modify").show();
                $("#shipping #shipping_modify").show();
                $("#shipping_method #shipping_method_modify").show();

                // Sum price
                var total_price = parseFloat($("#total_price").val());

                var shipping_price = 0;
                var dp = 0;
                if(value=='mail') { // Mail
                    <?php
                        for($i=0;$i<count($total_p);$i++) {
                            if($total_p[$i]<=$this->config->item('min_price')) {
                    ?>
                    //var dp = <?php //echo $this->config->item('deliver_price'); ?>;
                    var tp = total_price;
                    $("#shipping_price_<?php echo $i; ?>").html('<?php echo "฿".$this->config->item('deliver_price'); ?>');
                    //$("#new_total_price").html(tp+dp);
                    
                    <?php
                            } else {  
                    ?>
                    $("#shipping_price_<?php echo $i; ?>").html("฿0");
                    <?php
                            }
                        }
                    ?>
                    for(var i=0;i<=<?php echo $count_deliver; ?>;i++) {
                        dp+= parseFloat($("#shipping_price_"+i).html().substr(1));
                    }
                                        
                    $("#new_total_price").html(tp+dp);
                } else { // Ems
                    $.post("<?php echo site_url("shop/calculate_ems"); ?>", function(data) {
                        var p = $.trim(data).split(",");
                        var dp = 0;
                        for(var i=0;i<p.length-1;i++) {
                            $("#shipping_price_"+i).html("฿"+p[i]);
                            dp+=parseFloat(p[i]);
                        }
                        $("#new_total_price").html(total_price+dp);
                        $('#new_total_price').formatCurrency({ region: 'th-TH' });
                    });
                }



//                if(value=='mail' && total_price><?php echo $this->config->item('min_price'); ?>) {
//                    shipping_price = 0;
//                } else if(value=='mail' && total_price<=<?php echo $this->config->item('min_price'); ?>) {
//                    shipping_price = <?php echo $this->config->item('deliver_price'); ?>;
//                } else if(value=='ems' && total_price>1000) {
//                    shipping_price = 0;
//                } else if(value=='ems' && total_price<=1000) {
//                    shipping_price = 30;
//                }

//                $("#shipping_price").html(shipping_price)
//                // set new total price
//                $("#new_total_price").html(total_price+shipping_price);
//                //$('#new_total_price').formatCurrency({ region: 'th-TH' });

                // *** $("#shipping_price").html(shipping_price)
                // set paypal shipping
                $("#paypal_shipping").val(shipping_price);
                // set new total price
                //$("#new_total_price").html(total_price+shipping_price);
                $('#new_total_price').formatCurrency({ region: 'th-TH' });
                $('#shipping_price').formatCurrency({ region: 'th-TH' });
                
                // hid สำหรับ submit เมื่อ checkout
                $('#sum_total_price').val(total_price+shipping_price);

            });
        });
        // Payment Method
        $("#payment_method #btn_payment_method").click(function() {
            $("#payment_method #payment_method_content").hide();
            $("#payment #payment_content").show();
            // show modify payment_method_modify
            $("#billing #billing_modify").show();
            $("#shipping #shipping_modify").show();
            $("#shipping_method #shipping_method_modify").show();
            $("#payment_method #payment_method_modify").show();
            
        });
        // Payment
        $("#payment #btn_submit_checkout").click(function() {
            if($("#rad_payment_glixa").is(":checked")) { // GLIXA
                var datas = "";
                for(var i=0;i<=<?php echo $count_deliver; ?>;i++) {
                    datas += $("#shipping_name_"+i).html() + ":" + $("#shipping_price_"+i).html() + ",";
                }
                $.post("<?php echo base_url(); ?>shop/checkout_payment", {datas:$.trim(datas)},function(data) {
                    window.location = "<?php echo base_url().'shop/checkout_summary' ?>";
                });
            } else if($("#rad_payment_paypal").is(":checked")) { // PAYPAL
                $("#frm_payment_paypal").submit();
            }
        });
    });
</script>