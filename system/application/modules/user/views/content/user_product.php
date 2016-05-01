<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
<?php
    row_user_product($product_data,$user_data['level']);
?>
</div>
<?php echo $pagination; ?>
<script type="text/javascript">
    function del_product(pid) {
        if(confirm('คุณต้อการลบสินค้านี้')) {
            window.location = "<?php echo base_url(); ?>user/del_product/"+pid;
        }        
    }
</script>