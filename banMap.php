<?php
  session_start();

  $mapToBan = $_POST['banSubmit'];
  $bannedBy = $_POST['banTeam'];
  $voteid = $_SESSION['voteid'];

  $config = include('config.php');
  $SQLhost = $config['SQLhost'];
  $SQLdbname = $config['SQLdbname'];
  $SQLuser = $config['SQLuser'];
  $SQLpass = $config['SQLpass'];

  $conn = new mysqli($SQLhost, $SQLuser, $SQLpass, $SQLdbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Should be like: UPDATE bike SET full_day = 10 WHERE bike_type = 'mens_hybrid';
  $sql = "UPDATE matches SET banned$bannedBy = '$mapToBan' WHERE voteid='$voteid'";
  $conn->query($sql);

  //print_r('<script>window.history.back();</script>');
?>
