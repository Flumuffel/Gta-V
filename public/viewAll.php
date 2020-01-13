<?php
session_start();
if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
include 'functions.php';
include 'rankmanager.php';
include 'functions/navbar.php';
include 'config.php';

if(getRank($_SESSION['benutzername']) < OWNER){
  $where = 'WHERE Creator = :user';
} else {
  $where = ""; // VARIABLEN MÜSSEN EXISTIEREN WENN DU SIE NUTZT
}


?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Nova System | View logs</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
    </head>

    <body>
        <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                          <div class="col-md-12">
                              <h3 class="h4 text-center text-info">Notes</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Username</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                      $stmt = $conn->prepare("SELECT * FROM notes " . $where . " order by Time desc limit 10");
                                      $stmt->bindParam(':user', $_SESSION['benutzername']);
                                      $stmt->execute();
                                      while ($row = $stmt->fetchAll()) {
                                          $count = 0;
                                          foreach ($row as $item) {
                                              $count = $count + 1;
                                              echo '<tr>';
                                              echo '<td>' . $item["id"] . '</td>';
                                              echo '<td>' . $item['Username'] . '</td>';
                                              echo '<td>' . $item['Reason'] . '</td>';
                                              echo '<td>' . $item['Time'] . '</td>';
                                              echo '<td>' . $item['Creator'] . '</td>';
                                              echo '</tr>';
                                          }
                                        }
                                          //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="col-md-12 table-div">
                              <h3 class="h4 text-center text-info">Warnings</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Username</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                          $stmt = $conn->prepare("SELECT * FROM warnings " . $where . " order by Time desc limit 10");
                                          $stmt->bindParam(':user', $_SESSION['benutzername']);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item["id"] . '</td>';
                                                  echo '<td>' . $item['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="col-md-12 table-div">
                              <h3 class="h4 text-center text-info">Kicks</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Username</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                          $stmt = $conn->prepare("SELECT * FROM kicks " . $where . " order by Time desc limit 10");
                                          $stmt->bindParam(':user', $_SESSION['benutzername']);
                                          $stmt->execute();

                                          //echo "<table border ='1px'>";
                                          while ($row = $stmt->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $count = $count + 1;
                                                  echo '<tr>';
                                                  echo '<td>' . $item['id'] . '</td>';
                                                  echo '<td>' . $item['Username'] . '</td>';
                                                  echo '<td>' . $item['Reason'] . '</td>';
                                                  echo '<td>' . $item['Time'] . '</td>';
                                                  echo '<td>' . $item['Creator'] . '</td>';
                                                  echo '</tr>';
                                              }
                                          }
                                          //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="col-md-12 table-div">
                              <h3 class="h4 text-center text-info">Bans</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Username</th>
                                          <th>Reason</th>
                                          <th>Time</th>
                                          <th>By</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                      $stmt = $conn->prepare("SELECT * FROM bans " . $where . " order by Time desc limit 10");
                                      $stmt->bindParam(':user', $_SESSION['benutzername']);
                                      $stmt->execute();

                                          //echo "<table border ='1px'>";
                                      while ($row = $stmt->fetchAll()) {
                                          $count = 0;
                                          foreach ($row as $item) {
                                              $count = $count + 1;
                                              echo '<tr>';
                                              echo '<td>' . $item['id'] . '</td>';
                                              echo '<td>' . $item['Username'] . '</td>';
                                              echo '<td>' . $item['Reason'] . '</td>';
                                              echo '<td>' . $item['Time'] . '</td>';
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
    </body>

    </html>