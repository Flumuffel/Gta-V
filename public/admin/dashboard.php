<?php
session_start();
$time_start = microtime(true);
include '../rankmanager.php';
if (getRank($_SESSION['benutzername']) >= ADMIN) {
    } else {
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
include '../functions.php';
include '../functions/navbar.php';
include '../config.php';
if (isset($_POST['admin_dsaig9d98923'])) {
    $result = false;
    switch ($_POST['type']) {
        case "create":
            $type = "create";
            break;
        case "delete":
            if (getRank($_SESSION['benutzername']) < OWNER){
            if(getRank($_POST['username']) >= getRank($_SESSION['benutzername'])) { echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>You can not change this account! Too few permissions!</p>"; header("Refresh:5"); $resuls = true; exit;}}
            $type = "delete";
            break;
        case "update":
            if (getRank($_SESSION['benutzername']) < OWNER){
            if(getRank($_POST['username']) >= getRank($_SESSION['benutzername'])) { echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>You can not change this account! Too few permissions!</p>"; header("Refresh:5"); $result = true; exit;}}
            $type = "update";
            break;
        default:
            die();
    }
    switch ($_POST['rank']) {
        case "banned":
            $rank = -1;
            break;
        case "user":
            $rank = 0;
            break;
        case "create":
            $rank = 1;
            break;
        case "create&delete":
            $rank = 2;
            break;
        case "admin":
            $rank = 3;
            break;
        default:
            die();
    }
    if ($type == 'create') {
      $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO users ( `Username`, `Password`, `ServerRank`) VALUES (:user, :pass, :rank)");
      $stmt->bindParam(':user', $_POST['username']);
      $stmt->bindParam(':pass', $password_hash); // Du kannst nur variablen über bindParam nutzen, alles andere macht fehler
      $stmt->bindParam(':rank', $rank);
      if($stmt->execute()) {
        echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>This user already exists!</p>";
      } else {
        echo "<p class='h3 text-center' style='color: green; margin-top: 10px;'>User Created!</p>";
      }
      } else if ($type == 'update') {
      if ($result == false){
        if($_POST['password'] != "") {
          $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $stmt = $conn->prepare("UPDATE users SET `Password`= :pass,`ServerRank`= :rank WHERE Username = :user");
          $stmt->bindParam(':pass', $password_hash);
        } else {
          $stmt = $conn->prepare("UPDATE users SET `ServerRank`= :rank WHERE Username = :user");
        }
        $stmt->bindParam(':user', $_POST['username']);
        $stmt->bindParam(':rank', $rank);
        $stmt->execute();
        if($stmt->errorCode() != 0) {
          echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>The user could not be updated!</p>";
          header("Refresh:5");
        }
      }
    } else if ($type == 'delete') {
      if ($result == false){
        $stmt = $conn->prepare("DELETE FROM users WHERE Username = :usern");
        $stmt->bindParam(':usern', $_POST['username']);
        $stmt->execute();
      }
    } else {
      die('Admin error!');
    }
}

if (isset($_POST['news_2752987275398723'])) {
  $result = false;
    switch ($_POST['type']) {
        case "create":
            $type = "create";
            break;
        case "delete":
            $type = "delete";
            break;
        case "update":
            $type = "update";
            break;
        default:
            die();
    }
    switch ($_POST['art']) {
        case "news":
            $art = 'news';
            break;
        case "updates":
            $art = 'updates';
            break;
        case "issues":
            $art = 'issues';
            break;
        default:
            die();
    }
    if ($type == 'create') {
      $stmt = $conn->prepare("INSERT INTO `news`( `Description`, `Type`, `STime`, `ETime`, `Creator`) VALUES (:desc, :type, :start, :end, :creator)");
      $stmt->bindParam(':desc', $_POST['announce']);
      $stmt->bindParam(':type', $_POST['art']);
      $stmt->bindParam(':start', $_POST['start']);
      $stmt->bindParam(':end', $_POST['end']);
      $stmt->bindParam(':creator', $_SESSION['benutzername']);
      $stmt->execute();
      if($stmt->errorCode() != 0) {
        echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>The news could not be created!</p>";
        header("Refresh:5");
      }
      } else if ($type == 'update') {
      if ($result == false){
        $stmt = $conn->prepare("UPDATE news SET `Description`= :desc,`Type`= :type, `STime`= :start, `ETime`= :end WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':desc', $_POST['announce']);
        $stmt->bindParam(':type', $_POST['art']);
        $stmt->bindParam(':start', $_POST['start']);
        $stmt->bindParam(':end', $_POST['end']);
        $stmt->execute();
        if($stmt->errorCode() != 0) {
          echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>The news could not be updated!</p>";
          header("Refresh:5");
        }
      }
    } else if ($type == 'delete') {
      if ($result == false){
        $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();
        if($stmt->errorCode() != 0) {
          echo "<p class='h3 text-center' style='color: red; margin-top: 10px;'>The news could not be deletet!</p>";
          header("Refresh:5");
        }
      }
    } else {
      die('Admin error!');
    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Nova System | Admin Panel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background: url(../img/mountain.jpg) no-repeat center center fixed;
                background-size: cover;
            }

            .modal-content {
                background-color: #ffffff;
                box-shadow: 0px 0px 3px #ffffff;
                opacity: 0.925;
            }

            hr {
                color: #000000;
            }
            .table-div {
                padding-top: 20px;
            }
            .screen-div {
                padding-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                        <div class="col-md-3">
                          <div class="screen-div">
                              <h3 class="h4 text-center text-info">Manage Users</h3>
                              <hr>
                              <form action="" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                                  </div>
                                  <div class="form-group">
                                      <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                  </div>
                                  <div class="form-group">
                                      <select name="rank" class="btn btn-primary btn-block">
                                          <option value="banned">Banned</option>
                                          <option value="user" selected="selected">User</option>
                                          <option value="create">Create</option>
                                          <option value="create&delete">Create&Delete</option>
                                          <option value="admin">Admin</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <select name="type" class="btn btn-primary btn-block">
                                          <option value="create">Create</option>
                                          <option value="update" selected="selected">Update</option>
                                          <option value="delete">Delete</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <input type="submit" name="admin_dsaig9d98923" class="btn btn-primary btn-block" value="Submit">
                                  </div>
                              </form>
                          </div>
                               
                        </div>
                          <div class="col-md-9">
                              <h3 class="h4 text-center text-info">Users</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Username</th>
                                          <th>Rank</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                              
                                          $stmt = $conn->prepare("SELECT * FROM users ORDER BY ServerRank ASC");
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  switch($item['ServerRank']){
                                                    case -1:
                                                      $rank = 'Banned';
                                                      $param = "bgcolor='#f598a3'";
                                                      break;
                                                    case 0:
                                                      $rank = 'User';
                                                      $param = "bgcolor='#44f2a4'";
                                                      break;
                                                    case 1:
                                                      $rank = 'Creator';
                                                      $param = "bgcolor='#95f244'";
                                                      break;
                                                    case 2:
                                                      $rank = 'Creator&Deleter';
                                                      $param = "bgcolor='#f2ef44'";
                                                      break;
                                                    case 3:
                                                      $rank = 'Admin';
                                                      $param = "bgcolor='#73c2fa'";
                                                      break;
                                                    case 4:
                                                      $rank = 'Owner';
                                                      $param = "bgcolor='#44aaf2'";
                                                      break;
                                                    default:
                                                      $rank = 'Error';
                                                  }
                                                  echo '<tr '. $param .'>';
                                                  echo '<td>' . $item["id"] . '</td>';
                                                  echo '<td>' . $item['Username'] . '</td>';
                                                  echo '<td>' . $rank . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(getRank($_SESSION['benutzername']) < OWNER){goto eNews;} ?>
         <div class="container-fluid" style="padding-top: 0px; padding-bottom: 10px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                      <div class="col-md-3">
                          <div class="screen-div">
                              <h3 class="h4 text-center text-info">Announce System</h3>
                              <hr>
                              <form action="" method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <input type="number" name="id" class="form-control" placeholder="Enter Id (Update/Delete)">
                                  </div>
                                   <div class="form-group">
                                      <select name="art" class="btn btn-primary btn-block" required>
                                          <option value="news" selected="selected">News</option>
                                          <option value="updates">Updates</option>
                                          <option value="issues">Issues</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <textarea name="announce" class="form-control" placeholder="Enter Announcement"></textarea>
                                  </div>
                                  <div class="form-group row">
                                      <div class="form-group col-md-6">
                                        <input type="time" name="start" class="form-control" placeholder="Start time (00:00:00)" step="1">
                                      </div>
                                      <div class="form-group col-md-6">
                                        <input type="time" name="end" class="form-control" placeholder="End time (00:00:00)" step="1">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <select name="type" class="btn btn-primary btn-block" required>
                                          <option value="create" selected="selected">Create</option>
                                          <option value="update">Update</option>
                                          <option value="delete">Delete</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <input type="submit" name="news_2752987275398723" class="btn btn-primary btn-block" value="Submit">
                                  </div>
                              </form>
                          </div>
                               
                        </div>
                        <div class="col-md-9">
                              <h3 class="h4 text-center text-info">Users</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Type</th>
                                          <th>Description</th>
                                          <th>Start Time</th>
                                          <th>End Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                              
                                          $stmt = $conn->prepare("SELECT * FROM news ORDER BY STime ASC");
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              foreach ($row as $item) {
                                                  $time = (date("H")+1).':'.date('i:s');
                                                  echo time($item['STime']) . '<' . time($time) . ' | ' . time($item['ETime']) . '>' . time($time) . '\n';
                                                  echo time($item['STime']) . '>' . time($time);
                                                  if ($item['STime'] < $time and $item['ETime'] > $time){
                                                    $param = "bgcolor='#44f26a'";
                                                    //echo 'RIGHT NOW';
                                                  } elseif($item['STime'] > $time) {
                                                    $param = "bgcolor='#999193'";
                                                    //echo 'BEFOR';
                                                  } else {
                                                    $param = "bgcolor='#f24464'";
                                                    //echo 'AFTER';
                                                  }
                                                  tabelle:
                                                  echo '<tr '. $param .'>';
                                                  echo '<td>' . $item["id"] . '</td>';
                                                  echo '<td>' . $item['Type'] . '</td>';
                                                  echo '<td>' . $item['Description'] . '</td>';
                                                  echo '<td>' . $item['STime']  . '</td>';
                                                  echo '<td>' . $item['ETime']  . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <?php eNews: ?>
          
          <?php
            $time_end = microtime(true);
            $time = $time_end - $time_start;

            echo "<script>console.log('$time ms')</script>";
          ?>
    </body>

    </html>