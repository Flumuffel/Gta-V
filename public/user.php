<?php
    session_start();
    include 'config.php';
    include 'functions.php';
    include 'rankmanager.php';
    include 'functions/navbar.php';
    if (!isset($_SESSION["id"]))
      
    {
        // Benutzer begruessen
        header("Location: https://nova.flumuffel.tk/"); 
        exit; 
    }

    $rank = getRank($_SESSION['benutzername']);
    switch($rank){
      case -1:
        $rank = 'You are Banned!';
        break;
      case 0:
        $rank = 'User';
        break;
      case 1:
        $rank = 'Creator';
        break;
      case 2:
        $rank = 'Creator&Deleter';
        break;
      case 3:
        $rank = 'Admin';
        break;
      case 4:
        $rank = 'Owner';
        break;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :user"); 
    $stmt->bindParam(':user', $_SESSION['benutzername']);
    $stmt->execute(); 

    $row = $stmt->fetch();

    if(isset($_POST['UsChange'])) {
      if($_POST['benutzername'] == $row['Username']) {
        $user = true;
      } else {
        if( !empty($row) ) {
          $stmt = $conn->prepare("UPDATE users SET Username = :user WHERE id = :id"); 
          $stmt->bindParam(':id', $row['id']);
          $stmt->bindParam(':user', $_POST['benutzername']);
          $stmt->execute();
          
          $stmt = $conn->prepare("
          UPDATE notes SET Creator = :user WHERE Creator = :cuser;
          UPDATE warnings SET Creator = :user WHERE Creator = :cuser;
          UPDATE kicks SET Creator = :user WHERE Creator = :cuser;
          UPDATE bans SET Creator = :user WHERE Creator = :cuser;
          ");
          $stmt->bindParam(':cuser', $_SESSION['benutzername']);
          $stmt->bindParam(':user', $_POST['benutzername']);
          $stmt->execute();
        }
      }
      if(password_verify($_POST["password"], $row["Password"]) or empty($_POST['password'])) {
        $pass = true;
      } else {
        if( !empty($row) ) {
          $stmt = $conn->prepare("UPDATE users SET Password = :pass WHERE id = :id"); 
          $stmt->bindParam(':id', $row['id']);
          $stmt->bindParam(':pass', password_hash($_POST['password'], PASSWORD_DEFAULT));
          $stmt->execute();
        }
      } 
      $_SESSION['id'] = $row['id'];
      $_SESSION['benutzername'] = $_POST['benutzername'];
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nova System | User settings</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="site.css">
  
    <meta name='viewport' content='width=device.width, initial-scale=1.0'>
</head>

<body>
    <div class="container-fluid" style="padding-top: 20px;">
        <div class="col-md-100 main-section">
            <div class="modal-content">
              <div class="row">
                <div class="col-md-4 text-center">
                  <p class="h4 text-info">User Settings</p>
                  <p></p>
                  <form class="col-12" method="POST">
                    <div class="form-group">
                      <label class="text-secondary" for="rank">Rank</label>
                      <input id="rank" name="benutzername" type="text" class='form-control-plaintext text-center' <?php echo "value=" . $rank; ?> readonly>
                    </div>
                    <div class="form-group">
                      <label class="text-secondary" for="user">Username</label>
                      <input id="user" name="benutzername" type="text" <?php if(isset($user)){ echo "class='form-control text-center btn-outline-danger'";}elseif ($user == "success"){ echo "class='form-control text-center btn-outline-success'"; }  else { echo "class='form-control text-center'"; } ?> <?php echo "value='" . $_SESSION['benutzername'] . "'"; ?> placeholder="Change Username" <?php if($_SESSION['benutzername'] == "Testuser"){echo "readonly";}?>>
                    </div>
                    <div class="form-group">
                      <label class="text-secondary" for="pass">Password</label>
                      <input id="pass" name="password" type="password" <?php if(isset($pass)){ echo "class='form-control text-center btn-outline-danger'";} elseif ($pass == "success"){ echo "class='form-control text-center btn-outline-success'"; } else { echo "class='form-control text-center'"; } ?> <?php echo "value='" . $_POST['password'] . "'";?> placeholder="Change Password" <?php if($_SESSION['benutzername'] == "Testuser"){echo "readonly";}?>>
                    </div>
                    <button type="submit" class="btn bg-info" name="UsChange" value="Save"><i class="fas fa-sign-in-alt"></i> Save</button>
                    <p></p>
                  </form>
                </div>
                <div class="col-md-8">
                  <p class="h4 text-info center">Your Stats</p>
                  <?php 
                  $stmt = $conn->prepare("SELECT * FROM notes WHERE Creator = :user"); 
                  $stmt->bindParam(':user', $_SESSION['benutzername']);
                  $stmt->execute();
                  $stats['notes'] = $stmt->fetchAll();
                  $stmt = $conn->prepare("SELECT * FROM warnings WHERE Creator = :user"); 
                  $stmt->bindParam(':user', $_SESSION['benutzername']);
                  $stmt->execute();
                  $stats['warnings'] = $stmt->fetchAll();
                  $stmt = $conn->prepare("SELECT * FROM kicks WHERE Creator = :user"); 
                  $stmt->bindParam(':user', $_SESSION['benutzername']);
                  $stmt->execute();
                  $stats['kicks'] = $stmt->fetchAll();
                  $stmt = $conn->prepare("SELECT * FROM bans WHERE Creator = :user"); 
                  $stmt->bindParam(':user', $_SESSION['benutzername']);
                  $stmt->execute();
                  $stats['bans'] = $stmt->fetchAll();
                  $control = 0;
                  foreach ($stats as $item) {
                    $count = 0;
                    foreach($item as $item) {
                      $count = $count + 1;
                    }
                    $statsR[$control] = $count;
                    $control = $control + 1;
                  }  
                        
                  ?>
                  <div class=" col-md-12 stats"> 
                    <div class="">
                      <div class="card-body center">
                        <div class="row align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Notes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statsR[0];?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="col-md-10">
                  <div class=" col-md-12 stats"> 
                    <div class="">
                      <div class="card-body center">
                        <div class="row align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Warnings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statsR[1];?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="col-md-10">
                  <div class=" col-md-12 stats"> 
                    <div class="">
                      <div class="card-body center">
                        <div class="row align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kicks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statsR[2];?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="col-md-10">
                  <div class=" col-md-12 stats"> 
                    <div class="">
                      <div class="card-body center">
                        <div class="row align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bans</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statsR[3];?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</body>

</html>