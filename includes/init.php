<?php
session_start();
if (!isset($_SESSION['authorized'])) {
  $_SESSION['authorized'] = false;
}
$BASE_URL = "/webDevelopment/cybersport/";
try {
  error_reporting(E_ERROR | E_PARSE);
  $connection = new PDO('mysql:host=localhost;port=3307;dbname=cybersport', "root", "");
} catch (PDOException $e) {
  print_r("Couldnt connect to the database");
}
?>