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

            <button hidden type="button" id="success_btn" class='btn btn-primary btn-icon-split' data-toggle="modal" data-target="#SuccessModal">&nbspSuccess&nbsp</button>
    <button hidden type="button" id="fail_btn" class='btn btn-primary btn-icon-split' data-toggle="modal" data-target="#FailModal">&nbspFail&nbsp</button>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Get what you want!</h4>
                        <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="postBiddingForm" method="POST" class="well form-horizontal" autocomplete="off">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">ID</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user"></i></span>
                                            <input id="ID" name="ID" placeholder="" class="form-control" required="true" value="" type="text" readonly>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ttile</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="max-width: 100%;"><i class="	glyphicon glyphicon-map-marker"></i></span>
                                            <input id="title" name="title" placeholder="" class="form-control" required="true" value="" type="text" readonly>
                                        </div>
                                        <font id="location_error_id" color="red"></font>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Seller</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                            <input id="seller" name="seller" placeholder="" class="form-control" required="true" value="" type="text" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Photo</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                            <img src='https://farm4.staticflickr.com/3894/15008518202_c265dfa55f_h.jpg height=' 100' width='100'' />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Status</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                                            <input id="status" name="status" placeholder="" class="form-control" required="true" value="" type="text" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bidding Price</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i></i></span><input id="price" name="price" placeholder="" class="form-control" required="true" value="" type="text"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">remarks</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input id="remarks" name="remarks" placeholder="remarks" class="form-control" required="false" value="" type="text"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Submit Form</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <input id="Return" name="Return" placeholder="Return" class="btn btn-warning" value="Return" type="button" data-dismiss="modal">
                                        <input id="Submit_Form" name="Submit Form" placeholder="Submit Form" class="btn btn-success" value="Submit Form" type="button" data-dismiss="modal">
                                        <br />

                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <br />
                            </fieldset>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
      
        <!-- Content Row -->
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <table id="data-table">
                                            <thead>
                                                <tr class="table100-head">

                                                    <th class="column1">Id</th>
                                                    <th class="column2">Title</th>
                                                    <th class="column3">Seller</th>
                                                    <th class="column4">Photo</th>
                                                    <th class="column5">Status</th>
                                                    <th class="column6">Bidding Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $biddings = call_api('http://desmond.business:8080/fyp/getBiddings')["results"];
                                                foreach ($biddings as $elm) {
                                                    $statusId = $elm['bidding_status_id'];
                                                    $status = call_api('http://desmond.business:8080/fyp/biddingStatuses', $statusId)["title"];
                                                    echo "
                                <tr>
                                <td class='column1'>" . $elm['id'] . "</td>
                                <td class='column2'>" . $elm['title'] . "</td>
                                <td class='column3'>" . $elm['seller_customer_id'] . "</td>
                                <td class='column4'><img src='https://farm4.staticflickr.com/3894/15008518202_c265dfa55f_h.jpg height='100' width='100'' /></td>
                                <td class='column5'>" . $status . "</td>
                                <td class='column5'>";
                                                    if ($elm['bidding_price'] != null) {
                                                        echo $elm['bidding_price'];
                                                    } else {
                                                        echo "POST new price";
                                                    }
                                                    echo "</td></tr>";
                                                }
                                                ?>

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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<!-- Page level custom scripts -->

<script>
    $(document).ready(function() {
      

        var formData;
        var inputPrice;
        $("table").on('click', 'tr', function() {
            var values = $(this).find('td').map(function() {
                return $(this).text();
            });

            var id = values[0];
            var title = values[1];
            var seller = values[2];
            var status = values[4];
            var price = values[5];
            if (status == "Finished") {
                alert("Bidding finished, come quick next time!");
            } else {
                $("#myModal").modal('show');
                $("#ID").val(id);
                $("#title").val(title);
                $("#seller").val(seller);
                $("#status").val(status);
                $("#price").val(price);
                $.ajax({
                    url: 'http://desmond.business:8080/fyp/getBiddingByID/' + id,
                    type: 'get',
                    contentType: 'application/json',
                    success: function(response) {
                        formData = response.results;
                        console.log(formData);
                    }
                });
            }
            //alert(values[0]); // first td
            //alert(values[1]); // second td
            //alert(values[2]); // third td
            //alert(values[3]); // fourth td
        });

        $("#price").change(function() {
            formData.bidding_price = $("#price").val();
            inputPrice = $("#price").val();
            console.log(inputPrice);
        })

        $('#postBiddingForm').validate({ // initialize the plugin
        rules: {
          price: {
            required: true,
            min : $("#price").val(), 
            number: true
          }
        },
        messages:{
            required : "OK",
        },
        submitHandler: function(form) { // for demo
          alert('valid form submitted'); // for demo
          return false; // for demo
        }
      });
      
      
      $('#Submit_Form').click(function() {
      if ($("#postBiddingForm").validate().form()) {

            var id = $("#ID").val();
            var title = $("#title").val();
            var seller = $("#seller").val();
            var status = $("#status").val();
            var price = $("#price").val();

            $.ajax({
                type: "PUT",
                crossDomain: true,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                url: "http://desmond.business:8080/fyp/putBidding/",
                data: JSON.stringify(formData), // Note it is important
                success: function(result) {
                    $("#success_btn").trigger("click");
                    console.log("SUCCESS")
                    //oTable.ajax.reload(null, false);
                },
                error: function(result) {
                    $("#fail_btn").trigger("click");
                    console.log("FAIL")
                }
            });
        } else {
          $("#fail_btn").trigger("click");
                    console.log("FAIL")
        }
      })
    });
</script>

</html>