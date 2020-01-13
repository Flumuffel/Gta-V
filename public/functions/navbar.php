<?php
  if(session_status() != PHP_SESSION_ACTIVE) // Wenn session nicht aktiv ist.
    session_start(); // Starte session
  $Nconn = new PDO('mysql:host=mysql.Tutorialwork.de;dbname=Flumuffel', 'Flumuffel', 'Lucaspielt2004');
  
  $time = (date("H")+1).':'.date('i:s');
  $time = date("H:i:s", strtotime($time));

  $Nstmt = $Nconn->prepare("SELECT * FROM news WHERE STime < :time  AND ETime > :time order by STime desc");
  $Nstmt->bindParam(':time', $time);
  $Nstmt->execute();

  // Diese müssen existieren, foreach (und while) haben einen eigenen scope
  $news = ''; 
  $description = '';
  while ($row = $Nstmt->fetchAll()) {
    foreach ($row as $item) {
      $news = $item['Type'];
      $description = $item['Description'];
    }
  }

?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background: url(img/mountain.jpg) no-repeat center center fixed;
                background-size: cover;
            }

            .modal-content {
                background-color: #ffffff;
                box-shadow: 0px 0px 3px #ffffff;
                opacity: 0.925;
            }
            .news-text {
              margin: 0 auto;
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

            @-webkit-keyframes glowing-issues {
              0% { -webkit-box-shadow: 0 0 3px #B20000; }
              50% { -webkit-box-shadow: 0 0 40px #FF0000; }
              100% { -webkit-box-shadow: 0 0 3px #B20000; }
            }
            @-webkit-keyframes glowing-news {
              0% { -webkit-box-shadow: 0 0 3px #b2b200; }
              50% { -webkit-box-shadow: 0 0 40px #ffff03; }
              100% { -webkit-box-shadow: 0 0 3px #b2b200; }
            }
            @-webkit-keyframes glowing-updates {
              0% { -webkit-box-shadow: 0 0 3px #0282ad; }
              50% { -webkit-box-shadow: 0 0 40px #00bfff; }
              100% { -webkit-box-shadow: 0 0 3px #0282ad; }
            }

                   
            @-moz-keyframes glowing-issues {
              0% { -moz-box-shadow: 0 0 3px #B20000; }
              50% { -moz-box-shadow: 0 0 40px #FF0000; }
              100% { -moz-box-shadow: 0 0 3px #B20000; }
            }
            @-moz-keyframes glowing-news {
              0% { -moz-box-shadow: 0 0 3px #b2b200; }
              50% { -moz-box-shadow: 0 0 40px #ffff03; }
              100% { -moz-box-shadow: 0 0 3px #b2b200; }
            }
             @-moz-keyframes glowing-updates {
              0% { -moz-box-shadow: 0 0 3px #0282ad; }
              50% { -moz-box-shadow: 0 0 40px #00bfff; }
              100% { -moz-box-shadow: 0 0 3px #0282ad; }
            }

                   
            @-o-keyframes glowing-issues {
              0% { box-shadow: 0 0 3px #B20000; }
              50% { box-shadow: 0 0 25px #FF0000; }
              100% { box-shadow: 0 0 3px #B20000; }
            }
            @-o-keyframes glowing-news {
              0% { box-shadow: 0 0 3px #b2b200; }
              50% { box-shadow: 0 0 25px #ffff03; }
              100% { box-shadow: 0 0 3px #b2b200; }
            }
             @-o-keyframes glowing-updates {
              0% { box-shadow: 0 0 3px #0282ad; }
              50% { box-shadow: 0 0 25px #00bfff; }
              100% { box-shadow: 0 0 3px #0282ad; }
            }

                   
            @keyframes glowing-issues {
              0% { box-shadow: 0 0 3px #B20000; }
              50% { box-shadow: 0 0 40px #FF0000; }
              100% { box-shadow: 0 0 3px #B20000; }
            }
            @keyframes glowing-news {
              0% { box-shadow: 0 0 3px #b2b200; }
              50% { box-shadow: 0 0 40px #ffff03; }
              100% { box-shadow: 0 0 3px #b2b200; }
            }
            @keyframes glowing-updates {
              0% { box-shadow: 0 0 3px #0282ad; }
              50% { box-shadow: 0 0 40px #00bfff; }
              100% { box-shadow: 0 0 3px #0282ad; }
            }
        </style>
        <?php 
          switch($news){
            case 'issues':
              echo '
              <style>
                .news-button {
                  -webkit-animation: glowing-issues 1500ms infinite;
                  -moz-animation: glowing-issues 1500ms infinite;
                  -o-animation: glowing-issues 1500ms infinite;
                  animation: glowing-issues 1500ms infinite;
                }
              </style>';
              break;
            case 'news':
              echo '
              <style>
                .news-button {
                  -webkit-animation: glowing-news 1500ms infinite;
                  -moz-animation: glowing-news 1500ms infinite;
                  -o-animation: glowing-news 1500ms infinite;
                  animation: glowing-news 1500ms infinite;
                }
              </style>';
              break;
            case 'updates':
              echo '
              <style>
                .news-button {
                  -webkit-animation: glowing-updates 1500ms infinite;
                  -moz-animation: glowing-updates 1500ms infinite;
                  -o-animation: glowing-updates 1500ms infinite;
                  animation: glowing-updates 1500ms infinite;
                }
              </style>';
              break;
          }  
        ?>
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">

            <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapse_target">
                <span class="navbar-text"><a href="https://nova.flumuffel.tk/">NovaSystem</a></span>
                <div style="margin-right: 20px;"></div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="https://nova.flumuffel.tk/checkUser.php">Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://nova.flumuffel.tk/viewAll.php">View logs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://nova.flumuffel.tk/tutorial.php">Tutorial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 4</a>
                    </li>
                </ul>
            </div>
            <div class="nav navbar-nav navbar-right" id="collapse_target">
            <?php if(getRank($_SESSION['benutzername']) < ADMIN) { goto nomadmin;}?>
              <li class="nav-item dropdown my-2 my-lg-0">
                  <button class="btn btn-outline-danger my-2 my-sm-0 dropdown-toggle" data-toggle="dropdown" data-target="admin_panel">Admin Panel</button>
                  <div class="dropdown-menu bg-danger" aria-labelledby="admin_panel">
                      <a class="dropdown-item" href='https://nova.flumuffel.tk/admin/dashboard.php'>Dashboard</a>
                      <?php if(getRank($_SESSION['benutzername']) < OWNER) { goto nomremote;}?>
                      <a class="dropdown-item" href="https://nova.flumuffel.tk/admin/remoteLogin.php">Remote Login</a>
                      <?php nomremote: ?>
                  </div>
              </li>
            <?php nomadmin: ?>
            <div style="margin-right: 20px;"></div>
                <?php if($news == ''){goto buttons;}else{switch($news){case 'issues': break; case 'news': break; case 'updates': break; default: goto buttons;}} ?>
                <button name="news" <?php switch($news){case 'issues': echo "class='btn btn-outline-danger my-2 my-sm-0 news-button'"; break; case 'news': echo "class='btn btn-outline-warning my-2 my-sm-0 news-button'"; break; case 'updates': echo "class='btn btn-outline-info my-2 my-sm-0 news-button'"; break;}?>type="submit" data-toggle="collapse" data-target="#news"><?php switch($news){case 'issues': echo 'Issues'; break; case 'news': echo 'News'; break; case 'updates': echo 'Updates'; break;}?></button>
                <div style="margin-right: 20px;"></div>
                <?php buttons: ?>
                <li class="nav-item dropdown my-2 my-lg-0">
                    <button class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle" data-toggle="dropdown" data-target="droptown_target">User</button>
                    <div class="dropdown-menu" aria-labelledby="dropdown_target">
                        <a class="dropdown-item" href="https://nova.flumuffel.tk/user.php"><?php echo $_SESSION['benutzername']; ?></a>
                        <a class="dropdown-item" href="https://nova.flumuffel.tk/user.php"><?php 
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
                          echo $rank;
                        ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="https://nova.flumuffel.tk/user.php">Settings</a>
                    </div>
                </li>

                <div style="margin-right: 20px;"></div>
                <form class="form-inline my-2 my-lg-0" action="https://nova.flumuffel.tk/functions/logout.php">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
                </form>
            </div>
        </nav>
        <?php if($news == ''){goto end;}else{switch($news){case 'issues': break; case 'news': break; case 'updates': break; default: goto end;}} ?>
         <div class="container-fluid col-md-10 collapse" id="news" style="padding-top: 10px; padding-bottom: 0px; opacity: 0.925;">
            <div class="col-md-100 primar-section">
                <div <?php switch($news){case 'issues': echo "class='modal-content bg-danger' style='color: white;'"; break; case 'news': echo "class='modal-content bg-warning'"; break; case 'updates': echo "class='modal-content bg-info'"; break;}?>>
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                      <div class="screen-div col-md-11 news-text">
                        <h3 class="h4 text-center"><?php switch($news){case 'issues': echo 'Issues'; break; case 'news': echo 'News'; break; case 'updates': echo 'Update'; break;}?></h3>
                        <hr>
                        <center>
                          <?php echo $description; ?>
                        </center>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <?php end:?>
    </body>

    </html>