<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SCMS - Status</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>
  <?php include 'body.php'; ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Request Items status</h1>
    <p class="mb-4">Requested Items status are shown as below for follow up</p>

    <!-- Content Row -->
    <div class="row">

      <div class="col-xl-8 col-lg-7">


        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Request Items status</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <div class="chart-pie pt-4">
              <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-primary" id="WaitingForConfirm_figure"></i> WaitingForConfirm
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-success" id="WaitingForDispatch_figure"></i> WaitingForDispatch
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-info" id="WaitingForMap_figure"></i> WaitingForMap
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-regular" id="Shipping_figure"></i> Shipping
              </span>
            </div>
            <hr>
            Figures for reference only - Data approximately approached to 99%
          </div>
        </div>
      </div>





      <!-- Donut Chart -->
    </div>

  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Supply Chain Management System @ June-2019</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->
</body>
<!-- Bootstrap core JavaScript-->

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<!-- <script src="vendor/chart.js/Chart.min.js"></script>-->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->

<script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  var e = document.createElement("script");
  e.src = 'https://code.jquery.com/jquery-3.4.1.js';
  e.type = "text/javascript";
  document.getElementsByTagName("head")[0].appendChild(e);

  var WaitingForConfirm = 0;
  var WaitingForDispatch = 0;
  var WaitingForMap = 0;
  var Shipping = 0;
  var Total_status = 0;
  $(document).ready(function() {
    $.ajax({
      url: 'http://desmond.business:8080/myp/getRequestItems',
      type: 'get',
      contentType: 'application/json',
      success: function(response) {

        var len = 0;
        if (response != null) {
          len = response.length;
        }

        if (len > 0) {
          // Read data and create <option >
          for (var i = 0; i < len; i++) {
            status = response[i].status
            switch (status) {
              case "WaitingForConfirm":
                WaitingForConfirm = WaitingForConfirm + 1;
                break;
              case "WaitingForDispatch":
                WaitingForDispatch = WaitingForDispatch + 1;
                break;
              case "WaitingForMap":
                WaitingForMap = WaitingForMap + 1;
                break;
              case "Shipping":
                Shipping = Shipping + 1
              default:
                // code block
            }
          }
        }

        Total_status = WaitingForConfirm + WaitingForDispatch + WaitingForMap + Shipping
        WaitingForConfirm = Math.round((WaitingForConfirm / Total_status) * 100);
        WaitingForDispatch = Math.round((WaitingForDispatch / Total_status) * 100);
        WaitingForMap = Math.round((WaitingForMap / Total_status) * 100);
        Shipping = Math.round((Shipping / Total_status) * 100);

        $("#WaitingForConfirm_figure").append(" " + WaitingForConfirm + "%");
        $("#WaitingForDispatch_figure").append(" " + WaitingForDispatch + "%");
        $("#WaitingForMap_figure").append(" " + WaitingForMap + "%");
        $("#Shipping_figure").append(" " + Shipping + "%");

        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ["WaitingForConfirm", "WaitingForDispatch", "WaitingForMap", "Shipping"],
            datasets: [{
              data: [WaitingForConfirm, WaitingForDispatch, WaitingForMap, Shipping],
              backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#808080'],
              hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#606060'],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
            },
            legend: {
              display: false
            },
            cutoutPercentage: 80,
          },
        });
      }
    });
  });


  // Pie Chart Example
</script>

</html>