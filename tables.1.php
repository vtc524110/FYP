<?php
session_start();
if (isset($_SESSION["username"])){
  if (isset($_SESSION["authority"])){
  if ($_SESSION["authority"] == "admin"){
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
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

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
    $(document).ready(function () {

      var Location_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/getLocations",
        contentType: 'application/json',
        global: false,
        async: false,
        success: function (data) {
          return data;
        }
      }).responseJSON;

      var Virtual_item_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/VirtualCategories",
        contentType: 'application/json',
        global: false,
        async: false,
        success: function (data) {
          return data;
        }
      }).responseJSON;

      var Employee_json = $.ajax({
        type: 'GET',
        url: "http://desmond.business:8080/myp/getEmployees",
        contentType: 'application/json',
        global: false,
        async: false,
        success: function (data) {
          return data;
        }
      }).responseJSON;



      var request_ID;

      $('#dataTable').DataTable({
        scrollY: '60vh',
        scrollCollapse: false,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        ajax: {
          url: 'http://desmond.business:8080/myp/getRequestItems',
          dataSrc: ''
        },
        columns: [
          { data: "request_ID",
          "render": function (data,type,full,meta){
            request_ID = data;
            return request_ID;
          }
        },
          {
            data: "employee_ID",
            "render": function (data, type, full, meta) {
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
            "render": function (data, type, full, meta) {
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
            "render": function (data, type, full, meta) {
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
          { data: "quantity" },
          { data: "remarks" },
          {
            data: "status",
            "render": function (data, type, full, meta) {
              return '<a href="#">'+data+'</a>';
            }
          },
          { data: "expected_Delivery_Date" }
        ]
      })
    });
  </script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center
          justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SCMS <sup>2</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
          aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
          aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
          aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Function</h6>
            <a class="collapse-item" href="login.php">Login</a>
            <a class="collapse-item" href="tables.php">Make new quest</a>
            <a class="collapse-item" href="forgot-password.html">Forgot
              Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Request Items status</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item active">
        <a class="nav-link" href="tables.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Requested Item</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4
            static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none
              rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3
              my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow
                  animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0
                        small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right
                  shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is
                      ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for
                    your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right
                  shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you
                      can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you
                      ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks
                      great, I am very happy with the progress so far, keep up
                      the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I
                      ask is because someone told me that people say this to
                      all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["username"] ?></span>
                <img class="img-profile rounded-circle"
                  src="https://secure.gravatar.com/avatar/db62c3be5d077c042eb6e578253e2d51?s=60&d=mm&r=g">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow
                  animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2
                      text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">UC-100-10 Make new quest</h1>
          <p class="mb-4">Requested Items are shown as below table</p>
          <button type="button" class='btn btn-primary btn-icon-split' data-toggle="modal"
            data-target="#myModal">&nbspRequest new item for db&nbsp</button>
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
            <span>Supply Chain Management System @ 19-06-2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end
          your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- The new request Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Request New Item</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form id="request_form" method="POST" class="well form-horizontal" autocomplete="off">
            <fieldset>
              <div class="form-group">
                <label class="col-md-4 control-label">request ID</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i
                        class="glyphicon glyphicon-wrench"></i></span><input id="request_ID" name="request_ID"
                      placeholder="" class="form-control" required="true" value="" type="text" readonly></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">Employee ID</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i
                        class="glyphicon glyphicon-user"></i></span><input id="Employee_ID" name="Employee_ID"
                      placeholder="1" class="form-control" required="true" value="1" type="text" readonly></div>
                </div>

              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Location</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i
                        class="	glyphicon glyphicon-map-marker"></i></span>
                    <select id='sel_location' name='sel_location' class="selectpicker form-control">
                      <option value='0'>-- Select Location --</option>

                      <option value='{{ $Location->location_ID }}'>
                      </option>

                    </select>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-4 control-label">Category</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                    <span class="input-group-addon" style="max-width: 100%;"><i
                        class="glyphicon glyphicon-list"></i></span>
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
                    <span class="input-group-addon" style="max-width: 100%;"><i
                        class="glyphicon glyphicon-list"></i></span>
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
                    <span class="input-group-addon" style="max-width: 100%;"><i
                        class="glyphicon glyphicon-list"></i></span>
                    <select id='sel_virtual_item' name='sel_virtual_item' class="selectpicker form-control">
                      <option value='0'>-- Select Virtual Item --</option>
                    </select>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-4 control-label">quantity</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i
                        class="glyphicon glyphicon-plus"></i></span><input id="quantity" name="quantity"
                      placeholder="quantity" class="form-control" required="true" value="" type="text" required></div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">remarks</label>
                <div class="col-md-8 inputGroupContainer">
                  <div class="input-group"><span class="input-group-addon"><i
                        class="glyphicon glyphicon-info-sign"></i></span><input id="remarks" name="remarks"
                      placeholder="remarks" class="form-control" required="false" value="" type="text"></div>
                </div>
              </div>

              <button type="button" class='btn btn-primary btn-icon-split' data-toggle="modal"
            data-target="#SuccessModal" data-dismiss="modal">&nbspRequest new item for db&nbsp</button>

              <div class="form-group">
                <label class="col-md-4 control-label">Submit Form</label>
                <div class="col-md-8 inputGroupContainer">
                  <input id="Return" name="Return" placeholder="Return" class="btn btn-warning" value="Return"
                    type="button" data-dismiss="modal">
                  <input id="Submit_Form" name="Submit Form" placeholder="Submit Form" class="btn btn-success"
                    value="Submit Form" type="button">
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

  <!-- The success message Modal -->
    <!-- Logout Modal-->
    <div class="modal fade" id="SuccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Your request has been submitted ! </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">  <div class="alert alert-success">
    <strong>Success!</strong> 
  </div></div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <!-- Form script Jquery-->
  <script type='text/javascript'>
    $(document).ready(function () {

      //request_ID
      $.ajax({
        url: 'http://desmond.business:8080/myp/getRequestItems',
        type: 'get',
        contentType: 'application/json',
        success: function (response) {
          var lastElement = response[0];
          newRequest_ID = lastElement.request_ID + 1;
          $("#request_ID").attr("value", newRequest_ID);
          $("#request_ID").attr("placeholder", newRequest_ID);
        }
      });

      $('#Submit_Form').click(function () {

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
          success: function (result) {
            // do what ever you want with data
            console.log(result);
            alert("new request created");
            window.location.assign("/admin/tables.php");
          },
          error : function (result) {
            alert("Error on submitting new request");
          }
        });

      })


      $.ajax({
        url: 'http://desmond.business:8080/myp/getLocations',
        type: 'get',
        contentType: 'application/json',
        success: function (response) {

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
        success: function (response) {
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
      $('#sel_category').change(function () {

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
          success: function (response) {

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
      $('#sel_sub_category').change(function () {

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
          success: function (response) {

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
    });
  </script>
</body>

</html>