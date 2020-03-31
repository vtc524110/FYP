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
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <!--<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <!--<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->

</head>

<body>
    <?php include 'body.php'; ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">
            <?php
            $path_parts = pathinfo(__FILE__);
            echo $path_parts['filename'], "\n";
            ?>
        </h1>
        <p class="mb-4">
            <?php
            $path_parts = pathinfo(__FILE__);
            echo $path_parts['filename'], "\n";
            ?>
            bidding status are shown as below for follow up</p>

        <!-- Content Row -->
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <table>
                            <thead>
                                <tr class="table100-head">

                                    <th class="column1">Id</th>
                                    <th class="column2">Title</th>
                                    <th class="column3">seller_customer_id</th>
                                    <th class="column4">Photo</th>
                                    <th class="column5">Quantity</th>
                                    <th class="column6">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $url = 'http://desmond.business:8080/fyp/getBiddings';
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_HTTPGET, true);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response_json = curl_exec($ch);
                                curl_close($ch);
                                $response = json_decode($response_json, true);
                                $results = $response["results"];
                                foreach ($results as $elm) {
                                    echo "
                                <tr>
                                <td class='column1'>" . $elm['id'] . "</td>
                                <td class='column2'>" . $elm['title'] . "</td>
                                <td class='column3'>" . $elm['seller_customer_id'] . "</td>
                                <td class='column4'>" . $elm['bidding_status_id'] . "</td>
                                <td class='column4'><img src='https://farm4.staticflickr.com/3894/15008518202_c265dfa55f_h.jpg height='100' width='100'' /></td>
                                </tr>";
                                }
                                ?>
                                <td class="column1">2017-09-29 01:22</td>
                                <td class="column2">200398</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-28 05:57</td>
                                    <td class="column2">200397</td>
                                    <td class="column3">Samsung S8 Black</td>
                                    <td class="column4">$756.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$756.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-26 05:57</td>
                                    <td class="column2">200396</td>
                                    <td class="column3">Game Console Controller</td>
                                    <td class="column4">$22.00</td>
                                    <td class="column5">2</td>
                                    <td class="column6">$44.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-25 23:06</td>
                                    <td class="column2">200392</td>
                                    <td class="column3">USB 3.0 Cable</td>
                                    <td class="column4">$10.00</td>
                                    <td class="column5">3</td>
                                    <td class="column6">$30.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-24 05:57</td>
                                    <td class="column2">200391</td>
                                    <td class="column3">Smartwatch 4.0 LTE Wifi</td>
                                    <td class="column4">$199.00</td>
                                    <td class="column5">6</td>
                                    <td class="column6">$1494.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-23 05:57</td>
                                    <td class="column2">200390</td>
                                    <td class="column3">Camera C430W 4k</td>
                                    <td class="column4">$699.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$699.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-22 05:57</td>
                                    <td class="column2">200389</td>
                                    <td class="column3">Macbook Pro Retina 2017</td>
                                    <td class="column4">$2199.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$2199.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-21 05:57</td>
                                    <td class="column2">200388</td>
                                    <td class="column3">Game Console Controller</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-19 05:57</td>
                                    <td class="column2">200387</td>
                                    <td class="column3">iPhone X 64Gb Grey</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-18 05:57</td>
                                    <td class="column2">200386</td>
                                    <td class="column3">iPhone X 64Gb Grey</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-22 05:57</td>
                                    <td class="column2">200389</td>
                                    <td class="column3">Macbook Pro Retina 2017</td>
                                    <td class="column4">$2199.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$2199.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-21 05:57</td>
                                    <td class="column2">200388</td>
                                    <td class="column3">Game Console Controller</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-19 05:57</td>
                                    <td class="column2">200387</td>
                                    <td class="column3">iPhone X 64Gb Grey</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>
                                <tr>
                                    <td class="column1">2017-09-18 05:57</td>
                                    <td class="column2">200386</td>
                                    <td class="column3">iPhone X 64Gb Grey</td>
                                    <td class="column4">$999.00</td>
                                    <td class="column5">1</td>
                                    <td class="column6">$999.00</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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