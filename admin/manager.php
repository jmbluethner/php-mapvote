<?php
  error_reporting(E_ERROR | E_PARSE);
  session_start();
  $config = include '../config.php';
  if(hash('sha512',$_POST['pass']) != $config['adminPW']) {
    header('Location: index.php?wrongpw=true');
    die();
  }
?>
Logged in
