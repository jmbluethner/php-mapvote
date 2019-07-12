<?php
  $config = include('config.php');
  $SQLhost = $config['SQLhost'];
  $SQLdbname = $config['SQLdbname'];
  $SQLuser = $config['SQLuser'];
  $SQLpass = $config['SQLpass'];

  session_start();

  $pin = $_POST['pin'];

  $conn = new mysqli($SQLhost, $SQLuser, $SQLpass, $SQLdbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT pinA FROM matches WHERE pinA='$pin'";
  $result = $conn->query($sql);

  // Check if the Gamepin exists...

  if ($result->num_rows == 0) {
    $sql = "SELECT pinB FROM matches WHERE pinB='$pin'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      // Pin does not exist
      header('Location: index.php?wrongpin=true');
      die();
    } else {
      // Pin is assigned to team B
      $team = 'B';
    }
  } else {
    // Pin is assigned to team A
    $team = 'A';
  }
  $_SESSION['team'] = $team;
  $_SESSION['login'] = true;
  $_SESSION['pin'] = $pin;
  header('Location: vote.php');
  die();
?>
