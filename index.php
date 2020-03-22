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

    <title>Online bidding system</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<?php include 'body.php'; ?>

<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
    <div class="w-100">
        <h1 class="mb-0">Online bidding system
            <span class="text-primary">CarouBUY</span>
        </h1>
        <div class="subheading mb-5"> Supported Countries : Global

        </div>

        Please select category as below :
        <br />
        <?php
        function getCategory()
        {
            $url = 'http://desmond.business:8080/fyp/getCategoryFirstLvs/';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response_json = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response_json, true);
            $results = $response["results"];
            foreach ($results as $elm) {
                echo "<a href=https://www.google.com/search?q=" . $elm['category_first_lv_name'] . ">" . $elm['category_first_lv_name'] . "</a><br />";
            }
        }
        getCategory();
        ?>
        <script>
            $.ajax({
                url: 'http://desmond.business:8080/fyp/getCategoryFirstLvs/',
                type: 'get',
                contentType: 'application/json',
                success: function(response) {
                    var results = response.results;
                    results.forEach(element => {
                        console.log(element.category_first_lv_name);

                    });
                }
            });
        </script>
        <p class="lead mb-5">Frontend : Alan + Wing + 蕭總</p>
        <p class="lead mb-5">Backend :Desmond</p>
        <div class="social-icons">
            <a href="#">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#">
                <i class="fab fa-github"></i>
            </a>
            <a href="#">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#">
                <i class="fab fa-facebook-f"></i>
            </a>
        </div>
    </div>
</section>


</html>