<?php
  include '../core/init.php';
  $getFromU->logout();
  if ($getFromU->loggedIn() === false) {
    header('Location:'.BASE_URL.'index.php');
  }
?>
