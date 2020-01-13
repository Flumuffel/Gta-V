<?php
session_start();
if ( isset($_SESSION["id"]) )
{
    // Benutzer begruessen
    header("Location:https://nova.flumuffel.tk/desktop.php"); 
    exit;
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

// HTTPS Überprüfung
include 'config.php';

if(isset($_POST) & !empty($_POST)){
  $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :user"); 
  $stmt->bindParam(':user', $_POST["benutzername"]);
  $stmt->execute(); 
  
  $row = $stmt->fetch();
  
	if(!empty($row)){
    if(empty($row['E-Mail'])) {
      echo "<p class='h3 text-center' style='color: orange; margin-top: 10px;'>You didn't set a E-Mail so we can't send you a random passwort!</p>";
    } else {
      $pass = randomPassword();
      $stmt = $conn->prepare("UPDATE users SET `Password`= :pass WHERE Username = :user");
      $stmt->bindParam(':user', $_POST['benutzername']);
      $stmt->bindParam(':pass', password_hash($pass, PASSWORD_DEFAULT));
      $stmt->execute();
		  echo "<p class='h3 text-center' style='color: green; margin-top: 10px;'>E-mail was successfully send to user! [" . $pass . "]</p>";    
    }
	}else{
		echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>This User does not exist!</p>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Nova System | Forgot Password</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  
  <meta name='viewport' content='width=device.width, initial-scale=1.0'>
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
            <input name="benutzername" type="text" class="form-control" placeholder="Enter Username">
          </div>

          <button type="submit" class="btn" value="BLogin"><i class="fas fa-sign-in-alt"></i>Login</button>

        </form>
        <form class='col-12' method='POST' action='index.php'>
          <button type="submit" class="btn">Back</button>
        </form>

      </div><!--- End of Model Content-->
    </div>
  </div>







</body>

</html>