<?php
    session_start();
    include 'functions.php';
    include 'rankmanager.php';
    include 'functions/navbar.php';
    if (!isset($_SESSION["id"]))
      
    {
        // Benutzer begruessen
        header("Location: https://nova.flumuffel.tk/"); 
        exit; 
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nova System | Desktop</title>
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
                <div class="col-md-7">
                  <h3 class="h2 text-center text-info">Hello <?php echo $_SESSION['benutzername'];?>,</h3>
                  <p class="center h5">How can I assist you...</p>
                  <div class="center" style="margin-top: 50px; margin-bottom: 70px;">
                    <a href="checkUser.php" type="button" class="btn btn-outline-success">Start working</a>
                    <a href="user.php" type="button" class="btn btn-outline-info">View Stats</a>
                    <a href="tutorial.php" type="button" class="btn btn-outline-warning">Get Tutorial</a>
                  </div>
                  <?php if(getRank($_SESSION['benutzername']) < ADMIN) { goto nospec;} ?>
                  <p class="center h5">Here are special things for your special permissions ...</p>
                  <div class="center" style="margin-top: 20px; margin-bottom: 20px;">
                    <a href="admin/dashboard.php" type="button" class="btn btn-outline-danger">Admin Panel</a>
                  <?php if(getRank($_SESSION['benutzername']) < OWNER) { goto noremote;} ?>
                    <a href="admin/remoteLogin.php" type="button" class="btn btn-outline-danger">Remote Login</a>
                    <?php 

                    ?>
                  <?php noremote: ?>
                  </div>
                  <?php nospec: ?>
                </div>
                <div id="charts" class="col-md-5">
                  <h3 class="h2 text-center text-info">Stats of a Day</h3>
                  <canvas id="woche"></canvas>
                </div>
              </div>
            </div>
        </div>
    </div>
</body>
            
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        var design = false;
        var user = [<?php echo getStatsData('label','label');?>];
        var color = [];
        var dynamicColors = function() {
          var r = Math.floor(Math.random() * 255);
          var g = Math.floor(Math.random() * 255);
          var b = Math.floor(Math.random() * 255);
          return "rgb(" + r + "," + g + "," + b + ")";
        };
        for (var i in user) {
          color.push(dynamicColors());
          color.push(dynamicColors());
        }

        var all = document.getElementById("woche");
                mydata = {
                    datasets: [{
                                label: ['notes'],
                                data: [<?php echo getStatsData('notes','value');?>],
                        backgroundColor: color,
                    }, {
                                label: ['warnings'],
                                data: [<?php echo getStatsData('warnings','value');?>],
                        backgroundColor: color,
                    }, {
                                label: ['kicks'],
                                data: [<?php echo getStatsData('kicks','value');?>],
                        backgroundColor: color,
                    }, {
                                label: ['bans'],
                                data: [<?php echo getStatsData('bans','value');?>],
                        backgroundColor: color,
                    }],
                    labels: user,
              },
        
        config = new Chart(all,{
              type: 'bar',
              data: mydata,
            })
        window.addEventListener("resize", function() {
          if (window.matchMedia("(min-width: 1000px)").matches) {
            config.destroy();
            config = new Chart(all,{
              type: 'bar',
              data: mydata,
            })
          } else {
            config.destroy();
            config = new Chart(all,{
              type: 'pie',
              data: mydata,
              options: {
                title: {
                    display: true,
                    text: 'Outside: Notes | Next: Warnings | Next: Kicks | Last: Bans'
                }
              }
            })
          }
        });
    </script>

</html>