<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $page_title; ?></title>
        <!-- Main CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo assets_css('main.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo assets_css('admin_main.css'); ?>" />
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo assets_js('jquery/jquery-1.4.2.min.js'); ?>"></script>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <div id="body">
            <?php
                $this->load->view('admin/include/header');
                $this->load->view('admin/include/content');
                $this->load->view('admin/include/footer');
            ?>
        </div>
    </body>
</html>
<?php
    $this->output->enable_profiler(TRUE);
?>