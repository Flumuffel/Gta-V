<?php
session_start();
if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Nova System | Change passwort</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
  <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <div class="modal-dialog text-center">
    <div class="col-sm-8 main-section">
      <div class="modal-content">

        <div class="col-12 user-img">
          <img src="https://cdn.glitch.com/55991224-c07c-4284-8588-d0a7fa182f2b%2Fprofil.png?v=1575276185554">
        </div>

        <form class="col-12" method="POST" action="functions/changePass.php">
          <div class="form-group">
            <input name="benutzername" type="username" class="form-control" placeholder="Enter Username" required>
          </div>
           <div class="form-group">
            <input name="currKennwort" type="password" class="form-control" placeholder="Enter current Passwort" required>
          </div>
          <div class="form-group">
            <input name="kennwort" type="password" class="form-control" placeholder="Enter Passwort" required>
          </div>

          <button type="submit" class="btn" value="BLogin">Change</button>

        </form>
        <form class='col-12' method='POST' action='index.php'>
          <button type="submit" class="btn">Back</button>
        </form>
  
      </div><!--- End of Model Content-->
    </div>
  </div>







</body>

</html>