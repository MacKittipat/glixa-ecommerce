<?php
    /*
     * config validation rule ของ field ใน table
     * $config['table']['field'] = 'validation_rule';
     */
    //$config['wive_user']['email'] = 'trim|valid_email|unique[wive_user.email]';
    $config['wive_user']['password'] = 'trim|required';
    //$config['wive_user']['cpassword'] = 'trim|required|';
    $config['wive_user']['firstname'] = 'trim|required';
    $config['wive_user']['lastname'] = 'trim|required';
    
    $config['shop_user_profile']['identity_number'] = 'trim|numeric|min_length[13]|max_length[13]|is_id_number';
    $config['shop_user_profile']['address'] = 'trim';
    $config['shop_user_profile']['tambon'] = 'trim';
    $config['shop_user_profile']['amphoe'] = 'trim';
    $config['shop_user_profile']['province'] = 'trim';
    $config['shop_user_profile']['postalcode'] = 'trim|numeric';
    $config['shop_user_profile']['tel_num'] = 'trim|numeric';

    $config['shop_user_shop']['email'] = 'trim|valid_email';
    $config['shop_user_shop']['tel_num'] = 'trim|numeric';
    $config['shop_user_shop']['facebook_id'] = 'trim|numeric';
    $config['shop_user_shop']['description'] = 'trim';
    $config['shop_user_shop']['promotion'] = 'trim';
    $config['shop_user_shop']['instruction'] = 'trim';
    
    $config['shop_user_address']['firstname'] = 'trim|required';
    $config['shop_user_address']['lastname'] = 'trim|required';
    $config['shop_user_address']['address'] = 'trim|required';
    $config['shop_user_address']['tambon'] = 'trim|required';
    $config['shop_user_address']['amphoe'] = 'trim|required';
    $config['shop_user_address']['province'] = 'trim|required';
    $config['shop_user_address']['postalcode'] = 'trim|numeric|required';
    $config['shop_user_address']['tel_num'] = 'trim|numeric';
    $config['shop_user_address']['fax_num'] = 'trim|numeric';

    $config['shop_product_category']['category_code'] = 'trim|required';
    $config['shop_product_category']['name'] = 'trim|required';
    $config['shop_product_category']['product_category_id'] = '';
    
    $config['shop_product']['product_code'] = '';
    $config['shop_product']['name'] = 'trim|required';
    $config['shop_product']['title'] = '';
    $config['shop_product']['detail'] = '';
    $config['shop_product']['image'] = '';
    $config['shop_product']['cost'] = 'trim|required|numeric';
    $config['shop_product']['price'] = 'trim|required|numeric|is_price_not_zero';
    $config['shop_product']['quantity'] = 'trim|required|numeric';
    $config['shop_product']['unit'] = 'trim|required|char';
    $config['shop_product']['full_price'] = 'trim|numeric';
    $config['shop_product']['weight'] = 'trim|numeric';
    $config['shop_product']['size'] = '';
    $config['shop_product']['color'] = '';
    $config['shop_product']['options'] = '';
    $config['shop_product']['owner_id'] = '';
    $config['shop_product']['product_category_id'] = '';

    $config['shop_supplier']['name'] = 'trim|required';
    $config['shop_supplier']['contact_firstname'] = '';
    $config['shop_supplier']['contact_lastname'] = '';
    $config['shop_supplier']['address'] = 'trim|required';
    $config['shop_supplier']['tambon'] = 'trim|required';
    $config['shop_supplier']['amphoe'] = 'trim|required';
    $config['shop_supplier']['province'] = 'trim|required';
    $config['shop_supplier']['postalcode'] = 'trim|required|numeric';
    $config['shop_supplier']['phone_number1'] = 'trim|numeric';
    $config['shop_supplier']['phone_number2'] = 'trim|numeric';
    $config['shop_supplier']['fax_number1'] = 'trim|numeric';
    $config['shop_supplier']['fax_number2'] = 'trim|numeric';
    $config['shop_supplier']['email'] = '';
    $config['shop_supplier']['website'] = '';
    $config['shop_supplier']['detail'] = '';

    $config['shop_product_review']['title'] = 'trim|required';
    $config['shop_product_review']['detail'] = 'trim|required';
    $config['shop_product_review']['user_name'] = 'trim|required';
    $config['shop_product_review']['overall_rating'] = 'required';
    $config['shop_product_review']['money_rating'] = 'required';
    $config['shop_product_review']['expectation_rating'] = 'required';

    $config['shop_product_qa']['question'] = 'trim|required';
    $config['shop_product_qa']['user_name'] = 'trim|required';

    $config['shop_product_media']['title'] = 'trim|required';
    $config['shop_product_media']['link'] = 'trim|required';
    $config['shop_product_qa']['user_name'] = 'trim|required';

    $config['shop_payment']['money'] = 'trim|required|numeric';
    $config['shop_payment']['payment_date'] = 'trim|required';
?>
