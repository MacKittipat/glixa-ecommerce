<link rel="stylesheet" href="<?php echo assets_js('colorbox/colorbox.css'); ?>" />
<script type="text/javascript" src="<?php echo assets_js('colorbox/jquery.colorbox-min.js'); ?>"></script>
<script type="text/javascript">
    function quick_view(photo_id) {
        $(".quick_view").colorbox({
            width:"50%",
            inline:true,
            href:"#quick_view"+photo_id,
            open:true,
            opacity:0.4
        });
    }
</script>
<h2 class="heading">
    <?php echo $page_title; ?>
</h2>
<div>
    <?php echo row_product($product_data); ?>
</div>
<?php echo $pagination; ?>