<?php
session_start();
if (isset($_SESSION["Email"])) {
  $Email = $_SESSION["Email"];
  $Name =  $_SESSION['Name'];
}
else {
  header('Location: index.php');
}
?>