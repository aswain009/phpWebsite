	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?= LIB_URL ?>bootstrap/dist/css/bootstrap.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="<?= LIB_URL ?>jquery-ui/themes/smoothness/jquery-ui.min.css">
	<!-- dataTables -->
	<link rel="stylesheet" href="<?= LIB_URL ?>DataTables/media/css/jquery.dataTables.min.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?= CSS_URL ?>style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?= CSS_URL ?>themes.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= LIB_URL ?>fontawesome/css/font-awesome.min.css"/>
	<!-- Chosen -->
	<link rel="stylesheet" href="<?= LIB_URL ?>chosen/chosen.css"/>
	<!-- Froala -->
	<link rel="stylesheet" href="<?= LIB_URL ?>froala/css/froala_content.min.css" />
	<link rel="stylesheet" href="<?= LIB_URL ?>froala/css/froala_editor.min.css" />
	<link rel="stylesheet" href="<?= LIB_URL ?>froala/css/froala_style.min.css" />



	<!-- jQuery -->
	<script src="<?= LIB_URL ?>jquery/dist/jquery.min.js"></script>
	<!-- Nice Scroll -->
	<script src="<?= LIB_URL ?>nicescroll/jquery.nicescroll.js"></script>
	<!-- imagesLoaded -->
	<script src="<?= LIB_URL ?>imagesloaded/imagesloaded.pkgd.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?= LIB_URL ?>jquery-ui/jquery-ui.min.js"></script>
	<!--Validation-->
	<script src="<?= LIB_URL ?>jquery.validate/dist/jquery.validate.js"></script>
	<!-- Bootstrap -->
	<script src="<?= LIB_URL ?>bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- dataTables -->
	<script src="<?= LIB_URL ?>DataTables/media/js/jquery.dataTables.min.js"></script> <!--Dev Version-->
	<!-- Chosen framework -->
	<script src="<?= LIB_URL ?>chosen/chosen.jquery.min.js"></script>
	<!-- Froala WYSIWYG -->
	<script src="<?= LIB_URL ?>froala/js/froala_editor.min.js"></script>
	<!-- Theme scripts -->
	<script src="<?= JS_URL ?>application.min.js"></script>
	<!-- Theme framework -->
	<script src="<?= JS_URL ?>eakroko.js"></script>


	

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />
	<style>
	/*.dataTables_filter {display:none;}*/
	</style>

	<script>
		//Foala Activation.
		$.Editable.DEFAULTS.key = '<?= FROALA_ACTIVATION_KEY ?>';
	</script>