<h4>Category</h4>
<div class="glossymenu">
<?php
    $main_category_data = $this->product_category_model->get_product_category('','','AND product_category_id IS NULL ORDER BY name ASC');
    //echo $count_cate;
    foreach ($main_category_data as $row_main) {
        $count_cate = $this->db->query("SELECT shop_product.id FROM shop_product,shop_product_category
        WHERE shop_product.product_category_id=shop_product_category.id
        AND shop_product_category.product_category_id=? AND shop_product.flag_del=0", array($row_main['id']))->num_rows();
        if($count_cate!=0) {
?>
<a class="menuitem submenuheader" href="javascript:void(0);" ><?php echo $row_main['name'] ?> (<?php echo $count_cate; ?>)</a>
<div class="submenu">
    <ul>
        <?php
            $sub_category_data = $this->product_category_model->get_product_category('','',' AND product_category_id='.$row_main['id'].' ORDER BY (CASE name WHEN "อื่นๆ" THEN 9999 END),name ASC');
            foreach ($sub_category_data as $row_sub) {
                $count_sub_cate = $this->db->query("SELECT shop_product.id FROM shop_product
                WHERE shop_product.product_category_id=? AND shop_product.flag_del=0", array($row_sub['id']))->num_rows();
                if($count_sub_cate!=0) {
        ?>
        <li><?php echo anchor('shop/category/'.$row_sub['id'].'/'.$row_sub['name'], $row_sub['name'].' ('.$count_sub_cate.')'); ?> </li>
        <?php
                }
            }
        ?>
    </ul>
</div>
<?php
        }
    }
?>
</div>

