<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>class demo</title>
  <style>
    /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
    #map {
      height: 100%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
</head>

<body>
  <form action="/registration" method="POST">
    <p>
      User name (4 characters minimum, only alphanumeric characters):
      <input data-validation="length alphanumeric" data-validation-length="min4">
    </p>
    <p>
      Year (yyyy-mm-dd):
      <input data-validation="date" data-validation-format="yyyy-mm-dd">
    </p>
    <p>
      Website:
      <input data-validation="url">
    </p>
    <p>
      <input type="submit">
    </p>
  </form>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
  <script>
    $.validate({
      lang: 'en'
    });
  </script>
</body>


</html>