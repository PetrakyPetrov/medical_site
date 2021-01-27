<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Language" content="bg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= COMPANY_SITE_NAME ?></title>
    <meta name="description" content="<?= COMPANY_SITE_NAME ?>">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDDNtgH3XILQC21g1QQ5-VaYL57U5fD77w&sensor=false&libraries=places"></script>
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <link href="<?php echo site_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/assets/css/font-awesome.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/assets/css/themify-icons.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/assets/css/flag-icon.min.css'); ?>">
    <!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/assets/css/style.css'); ?>"> -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/assets/css/lib/vector-map/jqvmap.min.css'); ?>">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <?php
    if(isset($css_files)){
        foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach;
    }
    ?>

    <?php
    if(isset($js_files)){
        foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach;
    }
    ?>

</head>
<body>
	<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?php echo admin_url('/'); ?>"><?= COMPANY_SITE_NAME ?></a>
      
      <div class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
          <a class="nav-link" href="<?php echo site_url('user/logout'); ?>">Изход <?php echo $userName; ?> </a>
        </li>
      </div>
    </nav>
	<div class="container-fluid">
		<div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Секции</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('services'); ?>">Манипулации</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('teams'); ?>">Екип</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('gallery'); ?>">Галерия</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('officesconfig'); ?>">Често задавани въпроси</a></li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Настройки</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('pages'); ?>">Контакти</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo admin_url('pages'); ?>">Потребители</a></li>
                    </ul>
                </div>
            </nav>
		</div>
	</div>
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="content m-3">
            <?php
                if(isset($output)){
                    echo $output;
                } else {
                    $this->load->view($CONTENT);
                }
            ?>
        </div>
	
	</main>
    <!-- Right Panel -->

<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>-->

    <script src="<?php echo base_url('assets/admin/assets/js/vendor/jquery-2.1.4.min.js'); ?>"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <!--<script src="--><?php //echo base_url('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js'); ?><!--"></script>-->

    <!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="<?php echo base_url('assets/admin/assets/js/plugins.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/assets/js/main.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/third_party/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/third_party/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/third_party/jQuery-File-Upload/js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/third_party/editor2/jquery.sceditor.xhtml.min.js"></script>
    <!--
        Uncaught TypeError: Cannot read property 'msie' of undefined - jQuery tools // FIX EXAMPLE
     -->
    <script type="text/javascript">
        var siteUrl = window.location.href;

        var setClass = function(elementIds, setToggle) {
            for (var i = 0; i < elementIds.length; i++) {
                if (setToggle) {
                    document.getElementById(elementIds[i]).className += ' show';
                } else {
                    document.getElementById(elementIds[i]).className =
                        elementIds[i] === 'currencies' ? 'sub-menu children dropdown-menu' : 'menu-item-has-children dropdown';
                }
            }
        };

        if (siteUrl.includes('/admin/ratesconfig/getratesbyoffice')) {
            setClass(['currency-section', 'currencies'], true);
        } else {
            setClass(['currency-section', 'currencies'], false);
        }

        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>
    <!---------------------------------------------------------------->
</body>
</html>

