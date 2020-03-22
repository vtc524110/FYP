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




  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>
  <style type="text/css">
    .box {
      width: 600px;
      margin: 0 auto;
      border: 1px solid #ccc;

    }
  </style>

  <!-- Jquery -->


  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- Ajax Table-->

  <script>
    $(document).ready(function() {

      var jq = $.noConflict();
      $('#request_form').validate({ // initialize the plugin
        rules: {
          quantity: {
            required: true,
            number: true
          },
          remark: {
            required: true,
            minlength: 5
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


      session_username = $("#session_username").html();

      $.ajax({
        url: 'http://desmond.business:8080/myp/getUser/' + session_username,
        type: 'get',
        contentType: 'application/json',
        success: function(response) {
          $("#Employee_ID").attr("value", response.employee_ID);
          $("#Employee_ID").attr("placeholder", response.employee_ID);
        }
      });
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

        sel_virtual_item = $("#sel_virtual_item option:selected").val(),
          location_id = $("#sel_location option:selected").val(),
          quantity = $('input[name=quantity]').val(),
          remarks = $('input[name=remarks]').val(),
          employee_ID = $('input[name=Employee_ID]').val();
        var formData = {

          "virtual_Item_ID": sel_virtual_item,
          "location_ID": location_id,
          "quantity": quantity,
          "remarks": remarks,
          "employee_ID": employee_ID
        };

        if ($("#request_form").validate().form()) {
          $.ajax({
            type: "POST",
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            url: "http://desmond.business:8080/myp/postRequestItem/",
            data: JSON.stringify(formData), // Note it is important
            success: function(result) {
              $("#success_btn").trigger("click");
              oTable.ajax.reload(null, false);
            },
            error: function(result) {
              $("#fail_btn").trigger("click");
              oTable.ajax.reload(null, false);
            }
          });
        } else {
          //$("#fail_btn").trigger("click");
          $("#request_new_item").trigger("click");
        }
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

      var user_json = $.ajax({
        type: 'GET',
        url: 'http://desmond.business:8080/myp/getUser/' + session_username,
        contentType: 'application/json',
        global: false,
        async: false,
        success: function(data) {
          return data;
        }
      }).responseJSON;


      var request_ID;

      session_employee_ID = user_json.employee_ID;

      var oTable = $('#dataTable').DataTable({
        scrollY: '60vh',
        scrollCollapse: false,
        "iDisplayLength": 10,
        "order": [
          [0, "desc"]
        ],
        ajax: {
          //url: 'http://desmond.business:8080/myp/getRequestItems',
          url: 'http://desmond.business:8080/myp/getRequestItemByEmployeeID/' + session_employee_ID,
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
                case "WaitingForConfirm":
                  return data + '&nbsp&nbsp&nbsp<img src="https://cdn.shopify.com/s/files/1/1061/1924/products/Raised_Back_Of_Hand_Emoji_Icon_ios10_large.png?v=1542436023" width=25 height=25 />';
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
    <h1 class="h3 mb-2 text-gray-800">UC-100-10 Make new request</h1>
    <p class="mb-4">Role: Restaurant Manager</p>
    <button type="button" id="request_new_item" class='btn btn-primary btn-icon-split' data-toggle="modal" data-target="#myModal">&nbspRequest new item for db&nbsp</button>
    <button hidden type="button" id="success_btn" class='btn btn-primary btn-icon-split' data-toggle="modal" data-target="#SuccessModal">&nbspSuccess&nbsp</button>
    <button hidden type="button" id="fail_btn" class='btn btn-primary btn-icon-split' data-toggle="modal" data-target="#FailModal">&nbspFail&nbsp</button>
    <br />
    <br />
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
  <!-- The new request Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Request New Item</h4>
          <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form id="request_form" method="POST" class="well form-horizontal" autocomplete="off">
            <fieldset>
              <div class="form-group">
                <label class="col-md-4 control-label">Employee ID</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="Employee_ID" name="Employee_ID" placeholder="" class="form-control" required="true" value="" type="text" readonly></div>
                </div>

              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Location</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i class="	glyphicon glyphicon-map-marker"></i></span>
                    <select id='sel_location' name='sel_location' class="selectpicker form-control">
                      <option value='0'>-- Select Location --</option>

                      <option value='{{ $Location->location_ID }}'>
                      </option>

                    </select>
                  </div>
                  <font id="location_error_id" color="red"></font>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-4 control-label">Category</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                    <select id='sel_category' name='sel_category' class="selectpicker form-control">
                      <option value='0'>-- Select Category --</option>


                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Sub Category</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                    <select id='sel_sub_category' name='sel_sub_category' class="selectpicker form-control">
                      <option value='0'>-- Select Sub Category --</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Virtual Item</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                    <select id='sel_virtual_item' name='sel_virtual_item' class="selectpicker form-control">
                      <option value='0'>-- Select Virtual Item --</option>
                    </select>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-4 control-label">quantity</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span><input id="quantity" name="quantity" placeholder="quantity" class="form-control" required="true" value="" type="text"></div>
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

</html>