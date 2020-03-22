<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SCMS - Requested Item</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style type="text/css">
    .box {
      width: 600px;
      margin: 0 auto;
      border: 1px solid #ccc;

    }
  </style>

  <!-- Jquery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- Ajax Table-->
  <script>
    $(document).ready(function() {

      var Location_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/getLocations",
        contentType: 'application/json',
        global: false,
        async: false,
        success: function(data) {
          return data;
        }
      }).responseJSON;



      var request_ID;
      $('#dataTable').DataTable({
        scrollY: '60vh',
        scrollCollapse: false,
        "iDisplayLength": 10,
        "order": [
          [0, "desc"]
        ],
        ajax: {
          url: 'http://desmond.business:8080/myp/getWareHousestocks',
          dataSrc: ''
        },
        columns: [{
            data: "bulk_number"
          },
          {
            data: "theitem",
            "render": function(data, type, full, meta) {
              return data.name;
            }
          },
          {
            data: "location_ID",
            "render": function(data, type, full, meta) {
              var len = 0;
              if (Location_json != null) {
                len = Location_json.length;
              }
              if (len > 0) {
                // Read data and create <option >
                for (var i = 0; i < len; i++) {

                  var id = Location_json[i].location_ID;
                  var name = Location_json[i].address;
                  var district = Location_json[i].district
                  if (data == id) {
                    value = name + ", " + district;
                    return value;
                  }

                }
              }
            }
          },
          {
            data: "expiry_Date",
            "render": function(data, type, full, meta) {
              var today = new Date();
              var dd = today.getDate();

              var mm = today.getMonth() + 1;
              var yyyy = today.getFullYear();
              if (dd < 10) {
                dd = '0' + dd;
              }

              if (mm < 10) {
                mm = '0' + mm;
              }
              today = yyyy + '-' + mm + '-' + dd;
              var d1 = new Date(today);
              var d2 = new Date(data);
              if (d1 <= d2) {
                return data;
              } else {
                return '<font color="red">' + data + '</font>&nbsp&nbsp<b>Expired!</b>';
              }

            }
          },
          {
            data: "quantity"
          },
          {
            data: "return_Reason"
          }
        ]

      })

    });
  </script>
</head>

<body>
  <?php include 'body.php'; ?>
  <!-- Begin Page Content -->

  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Warehouse stock</h1>
    <p class="mb-4">Role: Restaurant Manager</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Default settings :
          10 rows</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th scope="col">Bulk number</th>
                <th scope="col">Item</th>
                <th scope="col">Location</th>
                <th scope="col">expiry_Date</th>
                <th scope="col">quantity</th>
                <th scope="col">return_Reason</th>
              </tr>
            </thead>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Supply Chain Management System @ June-2019</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

</html>