<div id="content">
    <div id="content_main">
        <div id="content_left">
            <?php $this->load->view('admin/include/content_left'); ?>
        </div>
        <div id="content_center">
            <div id="breadcrumb"><?php echo $page_breadcrumb; ?></div>
            <div>
                <?php $this->load->view($page_content); ?>
            </div>
        </div>
    </div>
</div>