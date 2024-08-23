<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <title>
    Dashboard Principal
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Jquery Import -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- End Jquery Import -->

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100" style=""></div>
  <main class="main-content position-relative border-radius-lg ">
    <?php
      if(isset($_GET["funcao"])) {
        switch($_GET["funcao"]) {
          case "dashboardPrincipal":
              require_once("./pages/dsh_b001_dashboardPrincipal.php");
            break;
        }
      }
        
    ?>    
  </main>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

    <!--CSS DO DEVEXTREME -->
    <link rel="stylesheet" type="text/css" href="./assets/js/plugins/DevExtreme/Sources/Lib/css/dx.common.css" />

		<!-- TEMAS DEVEXTREME -->
		<link rel="stylesheet" type="text/css" href="./assets/js/plugins/DevExtreme/Sources/Lib/css/dx.generic.plantae.css?_<?=filemtime('./assets/js/plugins/DevExtreme/Sources/Lib/css/dx.generic.plantae.css');?>" />

    <!--BIBLIOTECAS DEVEXTREME GLOBALIZE-->
    <script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/event.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/supplemental.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/cldr/unresolved.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/globalize.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/globalize/message.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/globalize/number.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/globalize/date.min.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/globalize/currency.min.js"></script>

		<!--BIBLIOTECAS DEVEXTREME PLUGINS-->
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/dx.all.js"></script>
		<script src="./assets/js/plugins/DevExtreme/Sources/Lib/js/localization/dx.messages.pt.js"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
