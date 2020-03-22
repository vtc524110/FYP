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
          url: 'http://desmond.business:8080/myp/getBPOReleases',
          dataSrc: ''
        },
        columns: [{
            data: "release_Number"
          },
          {
            data: "request_ID",
            "render": function(data, type, full, meta) {
              request_ID = data;
              return request_ID;
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
            // status 
            data: "status",
            "render": function(data, type, full, meta) {
              switch (data) {
                case "WaitingForDispatch":
                  return '<a href="#" class="dispatch">' + data + '</a>';
                  break;
                case "Shipping":
                  return data + '&nbsp&nbsp&nbsp<img src="https://images.emojiterra.com/twitter/512px/1f69a.png" width=25 height=25 />';
                  break;
                case "Received":
                  return '<font color="green">' + data + '</font>&nbsp&nbsp&nbsp<img src="https://image.flaticon.com/icons/png/512/20/20664.png" height="25" width="25" />';
                  break;
                default:
                  return data;
              }
            }
          },
          {
            data: "expected_Delivery_Date"
          },
          {
            data: "actual_Quantity_Of_Items"
          },
          {
            data: "actual_Amount"
          },
          {
            data: "purchase_Order_Revision"
          },
          {
            data: "bpa_Line_Number"
          },
        ]

      })

      var oTable = $('#dataTable').DataTable();

      $('#dataTable tbody').on('click', '.dispatch', function() {
        var row_json = oTable.row($(this).parents('tr')).data();
        var release_Number = row_json.release_Number;
        $.ajax({
          type: 'PUT',
          url: "http://desmond.business:8080/myp/putBPORelease/" + release_Number + "/2",
          contentType: 'application/json',
          data: row_json,
          success: function(data) {
            oTable.ajax.reload(null, false);
            return data;
          },
          error: function() {
            alert("ERROR");
            return row_json;
          }
        })
      });

    });
  </script>
</head>

<body>
  <?php include 'body.php'; ?>
  <!-- Begin Page Content -->

  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">UC-200-21 Process Request (Update BPO)</h1>
    <p class="mb-4">Role: Supplier(WaitForDispatch=>Shipping)</p>

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
                <th scope="col">Release Number</th>
                <th scope="col">Request id</th>
                <th scope="col">Location</th>
                <th scope="col">status</th>
                <th scope="col">expected_Delivery_Date</th>
                <th scope="col">actual_Quantity_Of_Items</th>
                <th scope="col">actual_Amount</th>
                <th scope="col">purchase_Order_Revision</th>
                <th scope="col">bpa_Line_Number</th>
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