<?php
session_start();
if (isset($_SESSION["username"])) { } else {
  header("Location: login.php");
}

if (time() - $_SESSION["start"] > 10) { }
