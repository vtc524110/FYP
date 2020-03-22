<?php
session_start();
$pwd_check_error = false;
if (isset($_SESSION["username"])) {
  header("Location: index.php");
}

if (isset($_POST['Submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  //$password = strtoupper(md5($password));
  if (isset($_POST['remember_me'])) {
    setcookie("username", $username);
    setcookie("remember_me", "checked");
  } else {
    setcookie("username", '', time() - 3600);
    setcookie("remember_me", '', time() - 3600);
  };


  $server_pwd = call_password($username);
  if ($server_pwd == $password) {
    //$authority = call_authority($username);
    $authority = "admin";
    if (isset($authority)) {
      $_SESSION["username"] = $username;
      $_SESSION["authority"] = $authority;
      $_SESSION["start"] = time();
    } else {

      $_SESSION["username"] = $username;
      $_SESSION["authority"] = "guest";
      $_SESSION["start"] = time();
    }
    header("Location: index.php");
  } else {
    $pwd_check_error = true;
  }
}

?>
<?php
function call_password($username)
{
  $url = 'http://desmond.business:8080/fyp/getUserByUsername/' . $username;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  echo "<script>console.log('Debug Objects: " . $response['results'][0]['password'] . "' );</script>";
  return $response['results'][0]['password'];
}

function call_authority($username)
{
  $url = 'http://desmond.business:8080/myp/getAuthority/' . $username;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  return $response["authority"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SCMS - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="POST" action="login.php" autocomplete="off">
                    <div class="form-group">
                      <input type="username" name="username" class="form-control form-control-user" id="username" aria-describedby="emailHelp" placeholder="User name"
                       value="<?php if (isset($_COOKIE['username'])) {echo $_COOKIE['username'];}?>" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                      <br />
                      <?php if ($pwd_check_error) {
                        echo "<p><font color='red'>Incorrect password, please try again</font></p>";
                      } ?>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="remember_me" class="custom-control-input" id="customCheck"
                        <?php 
                        if(isset($_COOKIE['remember_me'])){
                          echo "checked";
                        } else {

                        }
                        ?>
                        >
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                      <br />
                      <input type="submit" class="btn btn-primary btn-user btn-block" name="Submit" value="Login" />

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                    <br /><br />
                    <p class="small">If you do not have account, please login without password</p>
                    <br />
                    <p class="small">Supply Chain Management System @ June-2019</p>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script>

  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>