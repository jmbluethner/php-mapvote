<html>
  <head>
    <title>MAPVOTE by NIGHTTIMEDEV</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="./install.css" type="text/css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.css" type="text/css">
    <script type="text/javascript">
      function installFailed() {
        document.getElementById("headbar").style.backgroundColor = "rgb(190,0,0)";
        document.getElementById("gear1").style.display = "none";
        document.getElementById("gear2").style.display = "none";
        document.getElementById("triangle").style.display = "block";
      }
      function installDone() {
        document.getElementById("headbar").style.backgroundColor = "rgb(0,200,0)";
        document.getElementById("gear1").style.display = "none";
        document.getElementById("gear2").style.display = "none";
        document.getElementById("hook").style.display = "block";
      }
    </script>
  </head>
  <body>
    <div class="box">
      <div class="box_head" id="headbar">
        <h1>Installation</h1>
        <div class="gears">
          <i id="hook" class="fas fa-check"></i>
          <i class="fas fa-exclamation-triangle" id="triangle"></i>
          <i id="gear1" class="fas fa-cog"></i>
          <i id="gear2" class="fas fa-cog"></i>
        </div>
      </div>
      <div class="box_content">
        <?php
          if (ob_get_level() == 0) ob_start();

          print_r('The installer will take care of all that has to be done<br>');
          ob_flush();
          flush();
          sleep(2);
          print_r('Connecting to the Database ...<br>');
          ob_flush();
          flush();
          sleep(1);
          // Connect to SQL

          $config = include('../config.php');
          $SQLhost = $config['SQLhost'];
          $SQLdbname = $config['SQLdbname'];
          $SQLuser = $config['SQLuser'];
          $SQLpass = $config['SQLpass'];

          $conn = new mysqli($SQLhost, $SQLuser, $SQLpass, $SQLdbname);
          if ($conn->connect_error) {
            print_r('<script>installFailed()</script>');
            die('<span style="color: rgb(190,0,0)">Connecting to the SQL database failed: ' . $conn->connect_error . '</span>');
          }
          print_r('A connection to the Database was sucessfully established! Yeeeey<br>');
          print_r('I will now set up all needed tables ...<br>');
          ob_flush();
          flush();
          sleep(1);



          // Set up a table

         print_r('Now I set up <i>Matches</i><br>');
         ob_flush();
         flush();

         $val = $conn->query('select 1 from `matches` LIMIT 1');

         if($val !== FALSE) {
            print_r('<i>matches</i> already exists. Skipping.<br>');
         } else {
           $sql = "CREATE TABLE matches (
             voteid int NOT NULL AUTO_INCREMENT,
             pinA TINYTEXT,
             pinB TINYTEXT,
             maps LONGTEXT,
             result TINYTEXT,
             bannedA TINYTEXT,
             bannedB TINYTEXT,
             PRIMARY KEY (voteid)
           )";
           if ($conn->query($sql) === TRUE) {
             echo "Table <i>matches</i> created successfully<br>";
           } else {
              print_r('<script>installFailed()</script>');
              die("Error creating table: " . $conn->error);
            }

         }



          print_r('<script>installDone()</script>');
          print_r('All tasks are done! I will now close the Connection to the DB. You can go to the login page and log in.<br><b>Have fun managing your servers! GL & HF</b>');
          ob_flush();
          flush();
          $conn->close();
          ob_end_flush();
        ?>
      </div>
    </div>
  </body>
</html>
