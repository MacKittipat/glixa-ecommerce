<h2 class="heading"><?php echo $page_title; ?></h2>
<div>
    <?php
        if(isset($keyword)) {
    ?>
    ผลลัพท์การค้นหา <span style="font-size: 25px;"><q><?php echo $keyword; ?></q></span>
    <?php
        }
    ?>
</div>
<div>
    <?php
        if(isset($product_data)) {
            echo row_product($product_data);
        } else {
            
        }
    ?>
</div>
<?php
    if(isset($pagination)) {
        echo $pagination;
    } else {
        redirect('shop/cart');
    }
?>