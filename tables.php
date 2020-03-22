<?php
session_start();
if (isset($_SESSION["username"])) {
  if (isset($_SESSION["authority"])) {
    if ($_SESSION["authority"] == "admin") {
      $request_table = true;
    } else {
      $request_table = false;
    }
  } else {
    $_SESSION["authority"] = "user";
    $request_table = false;
  }
} else {
  header("Location: login.php");
}
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

      var Virtual_item_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/VirtualCategories",
        contentType: 'application/json',
        global: false,
        async: false,
        success: function(data) {
          return data;
        }
      }).responseJSON;

      var Employee_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/getEmployees",
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
          url: 'http://desmond.business:8080/myp/getRequestItems',
          dataSrc: ''
        },
        columns: [{
            data: "request_ID",
            "render": function(data, type, full, meta) {
              request_ID = data;
              return request_ID;
            }
          },
          {
            data: "employee_ID",
            "render": function(data, type, full, meta) {
              var len = 0;
              if (Location_json != null) {
                len = Location_json.length;
              }
              if (len > 0) {
                // Read data and create <option >
                for (var i = 0; i < len; i++) {

                  var employee_ID = Employee_json[i].employee_ID;
                  var last_name = Employee_json[i].last_name;
                  var first_name = Employee_json[i].first_name;
                  if (data == employee_ID) {
                    value = last_name + ", " + first_name;
                    return value;
                  }

                }
              }
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
            data: "virtual_Item_ID",
            "render": function(data, type, full, meta) {
              var len = 0;
              if (Virtual_item_json != null) {
                len = Virtual_item_json.length;
              }
              if (len > 0) {
                for (var i = 0; i < len; i++) {
                  subCategoriesArray = Virtual_item_json[i].subCategories;
                  len2 = subCategoriesArray.length;
                  for (var j = 0; j < len2; j++) {
                    virtualItemsArray = subCategoriesArray[j].virtualItems;
                    len3 = virtualItemsArray.length;
                    for (var t = 0; t < len3; t++) {
                      var virtual_Item_ID = virtualItemsArray[t].virtual_Item_ID;
                      var name = virtualItemsArray[t].name;
                      if (data == virtual_Item_ID) {
                        //value = virtual_Item_ID+": "+name;
                        return '<p>' + name + '</p>';
                      }

                    }
                  }
                }
              }

            }
          },
          {
            data: "quantity"
          },
          {
            data: "remarks"
          },
          {
            data: "status",
            "render": function(data, type, full, meta) {
              switch (data){
                case "Shipping":
                return data +'&nbsp&nbsp&nbsp<img src="https://images.emojiterra.com/twitter/512px/1f69a.png" width=25 height=25 />';
                break;
                case "Received":
                return '<font color="green">' + data + '</font>&nbsp&nbsp&nbsp<img src="https://image.flaticon.com/icons/png/512/20/20664.png" height="25" width="25" />';
                break;
                case "WaitingForDelivery":
                return data +'&nbsp&nbsp&nbsp<img src="https://cdn4.iconfinder.com/data/icons/ecommerce-thinline-icons-set/144/Delivery_Wait-512.png" width=25 height=25 />';
                break;
                default:
                return data;
              }
            }
          },
          {
            data: "expected_Delivery_Date"
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
                <th scope="col">Request</th>
                <th scope="col">Employee</th>
                <th scope="col">Location</th>
                <th scope="col">Item</th>
                <th scope="col">quantity</th>
                <th scope="col">remarks</th>
                <th scope="col">status</th>
                <th scope="col">expected_Delivery_Date</th>
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