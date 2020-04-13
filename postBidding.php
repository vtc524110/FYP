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
    <form id="postBiddingForm" method="POST" class="well form-horizontal" autocomplete="off">
      <fieldset>

        <div class="form-group">
          <label class="col-md-4 control-label">Ttile</label>
          <div class="col-md-8 inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon" style="max-width: 100%;"><i class="	glyphicon glyphicon-map-marker"></i></span>
              <input id="title" name="title" placeholder="" class="form-control" required="true" value="" type="text">
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
                                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span><input id="price" name="price" placeholder="" class="form-control" required="true" value="" type="text"></div>
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
                                        <input id="Submit_Form" name="Submit Form" placeholder="Submit Form" class="btn btn-success" value="Submit Form" type="hidden" data-dismiss="modal">
                                        <br />

                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <br />
                            </fieldset>
                        </form>
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
  $(document).ready(function () {
    var lastID
    var seller_customer_id
    var formData
    var userName = $("#session_username").html()

    $("#seller").val(userName)

    $.ajax({
        url: 'http://desmond.business:8080/fyp/getUserByUsername/'+ userName,
        type: 'get',
        contentType: 'application/json',
        success: function (response) {
          seller_customer_id = response.results[0].id;
        }
    })

    $.ajax({
        url: 'http://desmond.business:8080/fyp/getBiddings',
        type: 'get',
        contentType: 'application/json',
        success: function (response) {
            lastID = response.results[0].id + 1;
            $("#Submit_Form").prop('type', 'button'); 
        }
    })

    $('#Submit_Form').click(function () {
        formData = {
            "id": lastID,
            "title": $("#title").val(),
            "category_third_lv_id": null,
            "condition_id": null,
            "details": null,
            "selling_price": null,
            "bidding_price": "123",
            "closing_date_timestmp": null,
            "theBiddingPhotos": {
                "id": 91,
                "photo1": null,
                "photo_type1": null,
                "photo2": null,
                "photo_type2": null,
                "photo3": null,
                "photo_type3": null,
                "create_timestamp": "2020-04-13 17:26:25",
                "modify_timestamp": null
            },
            "bidding_currency": null,
            "district_id": null,
            "seller_customer_id": seller_customer_id,
            "buyer_customer_id": null,
            "bidding_status_id": 1,
            "logistics_di_id": null,
            "payment_id": null,
            "seller_ref_id": null,
            "buyer_ref_id": null,
            "remarks": null,
            "create_timestamp": "2020-04-13 17:26:25",
            "modify_timestamp": null
        };

        $.ajax({
            type: "POST",
            crossDomain: true,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            url: "http://desmond.business:8080/fyp/postBidding",
            data: JSON.stringify(formData), // Note it is important
            success: function (result) {
                console.log("SUCCESS")
                $("#success_btn").trigger("click");
                console.log(formData);
                //oTable.ajax.reload(null, false);
            },
            error: function (result) {
              console.log("FAIL")
              $("#fail_btn").trigger("click");
                console.log(formData);
                //oTable.ajax.reload(null, false);
            }
        });
    })
})
</script>
</html>