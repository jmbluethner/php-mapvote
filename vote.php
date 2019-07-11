<?php
  $config = include('config.php');
  $SQLhost = $config['SQLhost'];
  $SQLdbname = $config['SQLdbname'];
  $SQLuser = $config['SQLuser'];
  $SQLpass = $config['SQLpass'];

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
    } else {
      // Pin is assigned to team B
      $team = 'B';
    }
  } else {
    // Pin is assigned to team A
    $team = 'A';
  }

  // Check to which voteid the gamepin is assigned to...

  if($team == 'A') {
    $sql = "SELECT * FROM matches WHERE pinA='$pin'";
  } else {
    $sql = "SELECT * FROM matches WHERE pinB='$pin'";
  }
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc()) {
    $voteid = $row['voteid'];
  }

  // Get all Maps which are available for the vote

  $sql = "SELECT maps FROM matches WHERE voteid='$voteid'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $maps = $row['maps'];
  }

  // Make $maps an array
  $votemaps = explode(',', $maps);
  // Now the Maps can be accessed by $votemaps[]
?>
<html>
  <head>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>MAPVOTE by NIGHTTIMEDEV</title>
  </head>
  <body>
    <div class="cardwrapper">
      <?php
        // Check which maps are banned

        // Get Maps Banned by A
        $sql = "SELECT bannedA FROM matches WHERE voteid='$voteid'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
          $bannedmaps = $row['bannedA'];
        }
        $bannedByA = explode(',', $bannedmaps);


        // Get Maps Banned by B
        $sql = "SELECT bannedB FROM matches WHERE voteid='$voteid'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
          $bannedmaps = $row['bannedB'];
        }
        $bannedByB = explode(',', $bannedmaps);

        

        foreach($votemaps as $map) {
          ?>
          <div class="card" id="card_<?php echo $map ?>" style="width: 18rem;">
            <img src="https://cdn.nighttimedev.com/images/counterstrike/maps/<?php echo $map ?>.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $map ?></h5>
              <a href="#" class="btn btn-danger">Ban this!</a>
            </div>
          </div>
          <?php
        }
      ?>
    </div>
  </body>
</html>
