<?php
session_start();
$time_start = microtime(true);
$_SESSION["database_time"] = 0;

if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
include 'functions.php';
include 'rankmanager.php';
include 'functions/navbar.php';
include 'config.php';
if (isset($_POST['delete'])) {
    switch ($_POST['type']) {
        case "warnings":
            $type = "warnings";
            break;
        case "kicks":
            $type = "kicks";
            break;
        case "bans":
            $type = "bans";
            break;
        case "notes":
            $type = "notes";
            break;
        default:
            die();
    }
   if(getRank($_SESSION['benutzername']) < DELETE){
      die('No Permission! Bitte kehre zur Seite zurück!');
    }
    if(getRank($_SESSION['benutzername']) < ADMIN){
      $stmt = $conn->prepare("DELETE FROM " . $type . " WHERE id = :rid AND Creator = :user");
      $stmt->bindParam(':user', $_SESSION['benutzername']);
    } else {
      $stmt = $conn->prepare("DELETE FROM " . $type . " WHERE id = :rid");
    }
    $stmt->bindParam(':rid', $_POST['num']);
    $stmt->execute();
}

if (isset($_POST['create'])) {
    switch ($_POST['type']) {
        case "warnings":
            $type = "warnings";
            break;
        case "kicks":
            $type = "kicks";
            break;
        case "bans":
            $type = "bans";
            break;
        case "notes":
            $type = "notes";
            break;
        default:
            die();
    }
    if(getRank($_SESSION['benutzername']) <= CREATE){
      die('No Permission! Bitte kehre zur Seite zurück!');
    }
    $stmt = $conn->prepare("INSERT INTO `" . $type . "`( `Username`, `Reason`, `Creator`) VALUES (:username, :reason, :by)");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':reason', $_POST['reason']);
    if($_POST['from'] == ""){
      $stmt->bindParam(':by', $_SESSION['benutzername']);
    } else {
       $stmt->bindParam(':by', $_POST['from']);
    }
    $stmt->execute();
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Nova System | Records</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
  
        <meta name='viewport' content='width=device.width, initial-scale=1.0'>
    </head>

    <body>
        <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                        <div class="col-md-3">
                          <div class="screen-div">
                            <h3 class="h4 text-center text-info">Search Records</h3>
                            <hr>
                            <form action="" method="GET" enctype="multipart/form-data">
                                <input type="hidden" name="search">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="Search Record's" <?php if(getRank($_SESSION['benutzername']) == BANNED){echo disabled;}?>>
                                </div>
                            </form>
                        </div>
                          <div class="screen-div">
                            <h3 class="h4 text-center text-info">Create Record</h3>
                            <hr>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Enter Username" value="<?= isset($_GET["username"]) ? $_GET["username"] : ""; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="reason" class="form-control" placeholder="Enter Reason" required>
                                </div>
                                <?php  if(getRank($_SESSION['benutzername']) < ADMIN){ goto noform;} ?>
                                <div class="form-group">
                                    <input type="text" name="from" class="form-control" placeholder="From">
                                </div>
                                <?php noform: ?>
                                <div class="form-group">
                                    <select name="type" class="btn btn-primary btn-block">
                                        <option value="notes">Notes</option>
                                        <option value="warnings" selected="selected">Warnings</option>
                                        <option value="kicks">Kicks</option>
                                        <option value="bans">Bans</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="create" class="btn btn-primary btn-block" value="Create Record" <?php if(getRank($_SESSION['benutzername']) < CREATE){echo disabled;}?>>
                                </div>
                            </form>
                          </div>
                          <div class="screen-div">
                              <h3 class="h4 text-center text-info">Delete Record</h3>
                              <hr>
                              <form action="" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <input type="number" name="num" class="form-control" placeholder="Enter Record Id" required>
                                  </div>
                                  <div class="form-group">
                                      <select name="type" class="btn btn-primary btn-block">
                                          <option value="notes">Notes</option>
                                          <option value="warnings" selected="selected">Warnings</option>
                                          <option value="kicks">Kicks</option>
                                          <option value="bans">Bans</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <input type="submit" name="delete" class="btn btn-primary btn-block" value="Delete Record" <?php if(getRank($_SESSION['benutzername']) < DELETE){echo disabled;}?>>
                                  </div>
                              </form>
                          </div>
                               
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                          <div class="col-md-9">
                              <h3 class="h4 text-center text-info">Information</h3>
                              <hr>
                              <p class="text-center"><?php
                                                      if (isset($_GET['search'])) {
                                                          $response = getUserData($_GET['username']);
                                                          echo "Id: <a href='https://www.roblox.com/users/" . $response['Id'] . "/profile' target='popup '>" . $response['Id'] . "</a>";
                                                      }
                                                      ?></p>
                              <p class="text-center"><?php
                                                      if (isset($_GET['search']) && isset($_GET['username'])) {
                                                          $response = getUserData($_GET['username']);
                                                          echo "Username: " . $response['Username'];
                                                      }
                                                      ?></p>
                              <p class="text-center"><?php
                                                      $groupId = 4683371;
                                                      if (isset($_GET['search']) && isset($_GET['username'])) {
                                                          $response = getUserData($_GET['username']);
                                                          foreach ($response["Groups"] as $res) {
                                                              if ($res['Id'] == $groupId) {
                                                                  echo "Rank: " . $res['Rank'] . " | ";
                                                                  echo "Role: " . $res['Role'];
                                                              }
                                                          }
                                                      }
                                                      ?></p>
                              <p class="text-center"><?php
                                                      if (isset($_GET['search']) && isset($_GET['username'])) {
                                                          $response = getUserData($_GET['username']);
                                                          if(!empty($response['Admin'])) {
                                                            echo "Pass: " . $response['Admin'];
                                                          }
                                                      }
                                                      ?></p>

                          </div>
                          <div class="col-md-3" style="text-align: center;">
                            <img <?php echo "src='https://www.roblox.com/Thumbs/Avatar.ashx?x=150&y=150&Format=Png&username=" . (isset($_GET['username']) ? $_GET['username'] : "") . "' alt='Roblox Profil picture of " . (isset($_GET['username']) ? $_GET['username'] : "") . "'"; ?>>
                          </div>
                          </div>
                          <div class="">
                              <h3 class="h4 text-center text-info">Notes</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                      if (isset($_GET['search'])) {
                                          $stmt = $conn->prepare("SELECT * FROM notes WHERE Username = :user");
                                          $stmt->bindParam(':user', $_GET["username"]);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item["id"] . '</td>';
                                                  //echo '<td>' . $row1['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="">
                              <h3 class="h4 text-center text-info">Warnings</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                      if (isset($_GET['search'])) {
                                          $stmt = $conn->prepare("SELECT * FROM warnings WHERE Username = :user");
                                          $stmt->bindParam(':user', $_GET["username"]);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item["id"] . '</td>';
                                                  //echo '<td>' . $row1['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="table-div">
                              <h3 class="h4 text-center text-info">Kicks</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                      if (isset($_GET['search'])) {
                                          $stmt = $conn->prepare("SELECT * FROM kicks WHERE Username = :user");
                                          $stmt->bindParam(':user', $_GET["username"]);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item['id'] . '</td>';
                                                  //echo '<td>' . $row1['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="table-div">
                              <h3 class="h4 text-center text-info">Bans</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                      if (isset($_GET['search'])) {
                                          $stmt = $conn->prepare("SELECT * FROM bans WHERE Username = :user");
                                          $stmt->bindParam(':user', $_GET["username"]);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item['id'] . '</td>';
                                                  //echo '<td>' . $row1['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <?php
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            
            echo "<script>console.log('". json_encode($_RAMCACHE) ."')</script>";
            echo "<script>console.log('Page load: $time ms total')</script>";

            echo "<script>console.log('Database Connect time: ".$_SESSION["database_time"]." ms total')</script>";
          ?>
    </body>

    </html>