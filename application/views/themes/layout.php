<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?=isset($title) ? $title. ' - '. $this->general_settings['application_name']: $this->general_settings['application_name'] ; ?></title>
	<!-- Favicon-->
	<link rel="shortcut icon" href="<?= base_url($this->general_settings['favicon']); ?>">
	<meta charset="utf-8">
	<meta name="description" content="<?=isset($meta_description) ? $meta_description : $this->general_settings['description']; ?>">
	<meta name="keywords" content="<?= isset($keywords) ? $keywords : ''; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="canonical"href="<?= current_url() ?>">
	<link href="https://fonts.googleapis.com/css?family=Mina" rel="stylesheet"> 
	<!--
	CSS
	============================================= -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/linearicons.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/magnific-popup.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/nice-select.css">					
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/animate.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.theme.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.transitions.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/carousel_advance.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/hot_products.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/main.css">
	<script src="<?= base_url() ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
	<script>
    $(function(){
    	$("header").before($(".StickyHeader").clone().addClass("fixed"));
    	$(window).scroll(function(){
    	if($(window).scrollTop() >= 150){
            $('.StickyHeader.fixed').addClass('slideDown');
    	}
    	else{
    		$('.StickyHeader.fixed').removeClass('slideDown');
    	}
    	
    	});
    });
    </script>
</head>
<body>
	<!-- Navbar File-->
	<?php if(isset($_COOKIE['country_user']) and $_COOKIE['country_user'] != '') { include('navbar.php'); } ?>
	<!--main content start-->
	<?php $this->load->view($layout); ?>
	<!--main content end-->
	<!-- Footer File-->
	<?php if(isset($_COOKIE['country_user']) and $_COOKIE['country_user'] != '') { include('footer.php'); } ?>

	<!-- Scripts Files -->
	<script src="<?= base_url() ?>assets/js/vendor/bootstrap.min.js"></script>			
	<script src="<?= base_url() ?>assets/js/easing.min.js"></script>			
	<script src="<?= base_url() ?>assets/js/hoverIntent.js"></script>
	<script src="<?= base_url() ?>assets/js/superfish.min.js"></script>	
	<script src="<?= base_url() ?>assets/js/jquery.ajaxchimp.min.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery.magnific-popup.min.js"></script>	
	<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>			
	<script src="<?= base_url() ?>assets/js/jquery.sticky.js"></script>
	<script src="<?= base_url() ?>assets/js/parallax.min.js"></script>		
	<script src="<?= base_url() ?>assets/js/mail-script.js"></script>	
	<script src="<?= base_url() ?>assets/js/jquery.touchSwipe.min.js"></script>
	<script src="<?= base_url() ?>assets/js/responsive_bootstrap_carousel.js"></script>
	<script src="<?= base_url() ?>assets/js/paradise_slider_min.js"></script>
	<script src="<?= base_url(); ?>assets/js/sweetalert.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
	<!-- Notify JS -->
	<script src="<?= base_url() ?>assets/admin/plugins/notify/notify.min.js"></script>
	<script src="<?= base_url() ?>assets/js/main.js"></script>
	<!-- Custom JS-->
	<?php $this->load->view('js_footer'); ?>
</body>
</html>