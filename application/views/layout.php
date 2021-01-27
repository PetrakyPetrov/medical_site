<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= COMPANY_SITE_NAME ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />

  <!-- =======================================================
  * Template Name: Medilab - v2.1.0
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info" style="margin-left: auto; margin-right: auto;">
        <i class="icofont-envelope"></i> <a href="mailto:contact@example.com"><?= $contacts['email']?></a>
        <i class="icofont-phone"></i> <?= $contacts['phone']?>
        <!-- <i class="icofont-google-map"></i> <?= $contacts['address']?> -->
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="/"><?= COMPANY_SITE_NAME ?></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="/">Начало</a></li>
          <li><a href="#about">За нас</a></li>
          <li><a href="#departments">Манипулации</a></li>
          <li><a href="#doctors">Екип</a></li>
          <li><a href="#gallery">Галерия</a></li>
          <li><a href="#contact">Контакти</a></li>
          <li><a href="#faq">Често задавани въпроси</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="#appointment" class="appointment-btn scrollto">Запази час</a>

    </div>
  </header><!-- End Header -->
<div>
    <?php
        $this->load->view($CONTENT);
    ?>
</div>
<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container d-md-flex py-4">

      <div class="text-center" style="margin-left: auto;margin-right: auto;">
        <div class="copyright">
          &copy; <?php echo date("Y"); ?> <strong><span><?= COMPANY_SITE_NAME ?></span></strong>. Всички права запазени 
        </div>
        <!--<div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
          <span style="font-size: 10px;">Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a></span>
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
  <script>
      window.cookieconsent.initialise({
        "palette": {
          "popup": {
            "background": "#1977cc"
          },
          "button": {
            "background": "#fff",
            "text": "#237afc"
          }
        },
        "showLink": false,
        "theme": "classic",
        "position": "bottom-right",
        "content": {
          "message": "Toзи caйт изпoлзвa „биcĸвитĸи“, зaщoтo тe ca вaжни зa нeгoвoтo фyнĸциoниpaнe. C пoceщeниeтo нa тoзи caйт, виe ce cъглacявaтe c изпoлзвaнeтo нa „биcĸвитĸитe“.",
          "dismiss": "Приемам"
        }
      });
  </script>
</body>
</html>