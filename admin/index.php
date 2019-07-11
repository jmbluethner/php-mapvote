<?php
  error_reporting(E_ERROR | E_PARSE);
  session_start();
  if(isset($_SESSION['admin'])) {
    if($_SESSION['admin']) {
      header('Location manager.php');
      die();
    }
  }
?>
<html>
  <head>
    <script src="../assets/js/functions.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <title>MAPVOTE by NIGHTTIMEDEV</title>
  </head>
  <body>
    <?php
      session_start();
      if(isset($_GET['wrongpw'])) {
        ?>
        <div class="alert alert-danger" role="alert">
          Wrong password
        </div>
        <?php
      }
    ?>

    <div class="wrapcont">
      <div class="wraphead">
        <span>Enter Admin Password</span>
      </div>
      <div class="wrapcont_inner">
        <form action="manager.php" method="post">
          <input name="pass" type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
          <br>
          <button type="submit" class="btn btn-primary">GO!</button>
        </form>
      </div>
    </div>
  </body>
</html>
