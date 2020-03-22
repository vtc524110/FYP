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

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- Ajax Table-->

  <script>
    $(document).ready(function() {


      //request_ID
      $.ajax({
        url: 'http://desmond.business:8080/myp/getRequestItems',
        type: 'get',
        contentType: 'application/json',
        success: function(response) {
          var lastElement = response[0];
          newRequest_ID = lastElement.request_ID + 1;
          $("#request_ID").attr("value", newRequest_ID);
          $("#request_ID").attr("placeholder", newRequest_ID);
        }
      });

      $('#Submit_Form').click(function() {

        var formData = {

          "virtual_Item_ID": $("#sel_virtual_item option:selected").val(),
          "location_ID": $("#sel_location option:selected").val(),
          "quantity": $('input[name=quantity]').val(),
          "remarks": $('input[name=remarks]').val(),
          "employee_ID": $('input[name=Employee_ID]').val()
        };

        $.ajax({
          type: "POST",
          contentType: 'application/json; charset=utf-8',
          dataType: 'json',
          url: "http://desmond.business:8080/myp/postRequestItem/",
          data: JSON.stringify(formData), // Note it is important
          success: function(result) {
            // do what ever you want with data

            alert("new request created");
            window.location.assign("/Admin/UC_100_10.php");
          },
          error: function(result) {
            //alert("Error on submitting new request");
            $("#SuccessModal").dialog();
          }
        });

      })


      $.ajax({
        url: 'http://desmond.business:8080/myp/getLocations',
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

              var id = response[i].location_ID;
              var name = response[i].address;
              var district = response[i].district
              var option = "<option value='" + id + "'>" + name + ", " + district + "</option>";

              $("#sel_location").append(option);
            }
          }

        }
      });

      // Category
      $.ajax({
        url: 'http://desmond.business:8080/myp/VirtualCategories',
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

              var id = response[i].category_ID;
              var name = response[i].name;

              var option = "<option value='" + id + "'>" + name + "</option>";

              $("#sel_category").append(option);
            }
          }

        }
      });

      // Category Select Change
      $('#sel_category').change(function() {

        // Department id
        var Category_ID = $(this).val();
        // Empty the dropdown
        $('#sel_sub_category').find('option').not(':first').remove();
        $('#sel_virtual_item').find('option').not(':first').remove();

        // AJAX request 
        $.ajax({
          url: 'http://desmond.business:8080/myp/VirtualCategories',
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

                var id = response[i].category_ID;
                if (id == Category_ID) {
                  subCategoriesArray = response[i].subCategories;
                  len2 = subCategoriesArray.length;
                  var test = subCategoriesArray[0].sub_Category_ID;
                  var testname = subCategoriesArray[0].name;
                  for (var j = 0; j < len2; j++) {
                    var id = subCategoriesArray[j].sub_Category_ID;
                    var name = subCategoriesArray[j].name;
                    var option = "<option value='" + id + "'>" + name + "</option>";
                    $("#sel_sub_category").append(option);
                  }
                }
              }
            }

          }
        });
      });

      // Sub Category Select Change
      $('#sel_sub_category').change(function() {

        // Department id
        var Category_ID = $('#sel_category').val();
        var sub_category_ID = $(this).val();

        // Empty the dropdown
        $('#sel_virtual_item').find('option').not(':first').remove();

        // AJAX request 
        $.ajax({
          url: 'http://desmond.business:8080/myp/VirtualCategories',
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

                var id = response[i].category_ID;
                if (id == Category_ID) {
                  subCategoriesArray = response[i].subCategories;
                  len2 = subCategoriesArray.length;
                  for (var j = 0; j < len2; j++) {
                    var id = subCategoriesArray[j].sub_Category_ID;
                    var name = subCategoriesArray[j].name;
                    if (id == sub_category_ID) {
                      VirtualItemsArray = subCategoriesArray[j].virtualItems;
                      len3 = VirtualItemsArray.length;
                      for (var t = 0; t < len3; t++) {
                        var id = VirtualItemsArray[t].virtual_Item_ID;
                        var name = VirtualItemsArray[t].name;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#sel_virtual_item").append(option);
                      }
                    }

                  }
                }
              }
            }

          }
        });
      });

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
          url: 'http://desmond.business:8080/myp/getRequestItemByEmployeeID/1',
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
            // status 
            data: "status",
            "render": function(data, type, full, meta) {
              switch (data) {
                case "Shipping":
                  return '<a href="#">' + data + '</a>&nbsp&nbsp&nbsp<img src="https://images.emojiterra.com/twitter/512px/1f69a.png" width=25 height=25 />';
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
          }
        ]
      })

      var oTable = $('#dataTable').DataTable();


      $('#dataTable tbody').on('click', 'a', function() {
        var row_json = oTable.row($(this).parents('tr')).data();
        var request_ID = row_json.request_ID;
        $.ajax({
          type: 'PUT',
          url: "http://desmond.business:8080/myp/putRequestItem/" + request_ID + "/R",
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
    <h1 class="h3 mb-2 text-gray-800">UC-100-40 Update and receive item</h1>
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