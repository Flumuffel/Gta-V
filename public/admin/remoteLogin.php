<?php
session_start();

include '../config.php';
include '../rankmanager.php';
  
if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
if(getRank($_SESSION['benutzername']) < OWNER){
  header("Location: https://nova.flumuffel.tk/");
  exit;
}

if(isset($_POST['rlogin'])){
  include '../config.php';
  $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :user"); 
  $stmt->bindParam(':user', $_POST["benutzername"]);
  $stmt->execute();
  $row = $stmt->fetch();

  $Erfolgreich = false;

  if(!empty($row)) {
      $Erfolgreich = true;
  }

  if ($Erfolgreich){
    $stmt2 = $conn->prepare("SELECT * FROM users WHERE Username = :user"); 
    $stmt2->bindParam(':user', $_POST["UUsername"]);
    $stmt2->execute();
    $row2 = $stmt2->fetch();
     $Erfolgreich = false;

    if(!empty($row2)) {
        $Erfolgreich = password_verify($_POST["kennwort"], $row2["Password"]);;
    }

    if ($Erfolgreich){
      $_SESSION['id'] = $row['id'];
      $_SESSION['benutzername'] = $_POST['benutzername'];
      header("Location: https://nova.flumuffel.tk/");
    }
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Nova System | Remote Login</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  
  </head>

<body>

  <div class="modal-dialog text-center">
    <div class="col-sm-8 main-section">
      <div class="modal-content">

        <div class="col-12 user-img">
          <img src="https://cdn.glitch.com/55991224-c07c-4284-8588-d0a7fa182f2b%2Fprofil.png?v=1575276185554">
        </div>
          <form class="col-12" method="POST">
            <div class="form-group">
              <input name="benutzername" type="Rusername" class="form-control" placeholder="Enter Username" required>
            </div>
             <div class="form-group">
              <input name="UUsername" type="Rusername" class="form-control" placeholder="Enter your Username" required>
            </div>
            <div class="form-group">
              <input name="kennwort" type="password" class="form-control" placeholder="Enter your Passwort" required>
            </div>

            <button type="submit" class="btn" name="rlogin" value="BLogin">Login</button>
          </form>
          <form class='col-12' method='POST' action='dashboard.php'>
            <button type="submit" class="btn">Back</button>
          </form>

      </div>
    </div>
  </div>







</body>

</html>