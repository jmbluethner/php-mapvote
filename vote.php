<?php
  $config = include('config.php');
  $SQLhost = $config['SQLhost'];
  $SQLdbname = $config['SQLdbname'];
  $SQLuser = $config['SQLuser'];
  $SQLpass = $config['SQLpass'];

  session_start();

  if($_SESSION['login'] != true) {
    header('Location: index.php');
    die();
  }

  $pin = $_SESSION['pin'];
  $team = $_SESSION['team'];

  $conn = new mysqli($SQLhost, $SQLuser, $SQLpass, $SQLdbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
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
  $_SESSION['voteid'] = $voteid;

  // Get all Maps which are available for the vote

  $sql = "SELECT maps FROM matches WHERE voteid='$voteid'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $maps = $row['maps'];
  }

  // Make $maps an array
  $votemaps = explode(',', $maps);
  // Now the Maps can be accessed by $votemaps[]

  // Have to check which maps are actually already banned. Than blur out or remove ...
?>
<html>
  <head>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>MAPVOTE by NIGHTTIMEDEV</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      function refreshPage() {
        jQuery("#body").load("./assets/php/sessioncheck.php",{});
      }
    </script>
  </head>
  <body id="body">
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

        // If all Maps are banned, it's A's turn to Ban

        if(empty($bannedByA) && empty($bannedByB)) {
          $banTeam = 'A';
        } else {
          // If Maps are Banned, we have to check which Team has to ban
          if(sizeof($bannedByA) > sizeof($bannedByB)) {
            $banTeam = 'B';
          } else {
            $banTeam = 'A';
          }
        }

        echo 'Now Banning: '.$banTeam;

        foreach($votemaps as $map) {
          ?>
          <div class="card" id="card_<?php echo $map ?>" style="width: 18rem;">
            <img src="https://cdn.nighttimedev.com/images/counterstrike/maps/<?php echo $map ?>.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $map ?></h5>
              <form action="banMap.php" method="POST">
                <input type="hidden" name="banSubmit" value="<?php echo $map ?>">
                <input type="hidden" name="banTeam" value="<?php echo $banTeam ?>">
                <button type="submit" class="btn btn-danger">Ban this!</button>
              </form>
            </div>
          </div>
          <?php
        }
      ?>
    </div>
    <script>
      //setInterval(function(){refreshPage()},2000);
    </script>
  </body>
</html>
