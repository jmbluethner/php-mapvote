<html>
  <head>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>MAPVOTE by NIGHTTIMEDEV</title>
  </head>
  <body>
    <?php
      session_start();
      if(isset($_GET['wrongpin'])) {
        ?>
        <div class="alert alert-danger" role="alert">
          Pin invalid!
        </div>
        <?php
      }
    ?>

    <div class="wrapcont">
      <div class="wraphead">
        <span>Enter Gamepin</span>
      </div>
      <div class="wrapcont_inner">
        <form action="vote.php" method="post">
          <input name="pin" type="text" class="form-control" placeholder="Votepin" aria-label="Username" aria-describedby="addon-wrapping">
          <br>
          <button type="submit" class="btn btn-primary">GO!</button>
        </form>
      </div>
    </div>
  </body>
</html>
