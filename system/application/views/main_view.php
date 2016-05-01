<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
        <?php
            if($page_title=="Glixa") {
                echo $page_title;
            } else {
                echo "Glixa | ".$page_title;
            }
        ?>
        </title>
        <!-- Open Graph -->
        <meta property="og:title" content="<?php
            if($this->router->fetch_class()=='shop' && $this->router->fetch_method()=='product') {
                if($product_data['owner_type']=='c2c') {
                    echo $page_title.' @Glixa';
                } else {
                    echo $page_title.' @Glixa Guarantee';
                }
            } else {
                echo "Glixa";
            }
        ?>"/>
        <meta property="og:type" content="company"/>
        <meta property="og:url" content="<?php
            if($this->router->fetch_class()=='shop' && $this->router->fetch_method()=='product') {
                echo current_url();
            } else {
                echo base_url();
            }
        ?>"/>
        <meta property="og:image" content="<?php
            if($this->router->fetch_class()=='shop' && $this->router->fetch_method()=='product') {
                if($product_data['image']!='') {
                    echo assets_product($product_data['image'],$product_data['owner_type']);
                } else {
                    echo base_url().'assets/image/product.png';
                }
            } else {
                echo assets_image('logo.png');
            }
        ?>"/>
        <meta property="og:description" content="Glixa Online Shopping"/>
        <meta property="fb:app_id" content="114908148571218"/>
        <link rel="shortcut icon" href="<?php echo assets_image('favicon.ico'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo assets_css('main.css'); ?>" />
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo assets_js('jquery/jquery-1.4.2.min.js'); ?>"></script>
        <!-- Sliding Login -->
        <link rel="stylesheet" type="text/css" href="<?php echo assets_js('sliding-login/css/slide.css'); ?>" />
        <script type="text/javascript" src="<?php echo assets_js('sliding-login/js/slide.js'); ?>"></script>
	<!--[if lte IE 6]>
            <script type="text/javascript" src="<?php echo assets_js('sliding-login/js/pngfix/supersleight-min.js'); ?>"></script>
	<![endif]-->
        <!-- Template : Estore -->
        <link rel="stylesheet" href="<?php echo assets_template('estore/css/red.css'); ?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo assets_template('estore/css/sexylightbox.css'); ?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo assets_template('estore/css/ddsmoothmenu.css'); ?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo assets_template('estore/css/page.css'); ?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo assets_template('estore/css/jquery.ad-gallery.css'); ?>" type="text/css" />
        <script src="<?php echo assets_template('estore/js/ddsmoothmenu.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo assets_template('estore/js/menu.js'); ?>" type="text/javascript"></script>
    </head>
    <body>
        <?php
            $this->load->view('include/sliding_login');
        ?>
        <div id="wrapper">
            <?php
                $this->load->view('include/header');
                $this->load->view('include/content');
            ?>
        </div>
        <?php
            $this->load->view('include/footer');
        ?>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-19421919-1']);
            _gaq.push(['_setDomainName', '.glixa.com']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
<?php
    $this->output->enable_profiler(TRUE);
?>

    </body>
</html>