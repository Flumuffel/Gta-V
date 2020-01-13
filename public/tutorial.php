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
    <title>Nova System | Tutorial</title>
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
              <div class="col-md-9">
                <img src="https://cdn.glitch.com/55991224-c07c-4284-8588-d0a7fa182f2b%2FUnbenannt.PNG?v=1578318896740" class="responsive" style="width: 102%; height: auto;">
              </div>
              <div class="col-md-3">
                <h3 class="h2 text-center text-info">Guide | How to...</h3>
                <div>
                  <div id="1" class="tabcontent text-center">
                    <div class="col-md-12">
                      <p class="h5 text-info">1. Search Records</p>
                    </div>
                    <div class="col-md-12">
                      <p>After you see the picture at the left you can put a Roblox Username in the Search field and click on "Search Records"! After that it will search all records over the User so like... Notes, Warnings, Kicks or Bans that he got. You get other helpful informations like the Group Rank/Role, if he did buy InstantWorker/Mod/Admin or Owner or you can view his Profile Picture if you don't know if you have the right person!</p>
                    </div>
                  </div>
                  <div id="2" class="tabcontent text-center" style="display:none;">
                    <div class="col-md-12">
                      <p class="h5 text-info">2. Create Record</p>
                    </div>
                    <div class="col-md-12">
                      <p>If you need to create a record you need to enter a reason and the type of record like... Notes, Warnings, Kicks or Bans. After that it will write it in the User records and you can see it live.</p>
                    </div>
                  </div>
                  <div id="3" class="tabcontent text-center" style="display:none;">
                    <div class="col-md-12">
                      <p class="h5 text-info">3. Delete Record</p>
                    </div>
                    <div class="col-md-12">
                      <p>If you decide to delete a record you can do that by typing the record id that will show in the table at the first row with the "#"! You can only delete your records no one else.</p>
                    </div>
                  </div>
                </div>
                <div class="text-center" style="margin-bottom: 20px;">
                  <a id="down" name="0" class="btn btn-outline-warning" onclick="back(this.name)">Back</a>
                  <a id="up" name="2" class="btn btn-outline-success" onclick="next(this.name)">Next</a>
                </div>
              </div>
            </div>
        </div>
    </div>
  <script>
  
  function next(id) {
    var i, tabcontent, count = 0, tablinks;
    
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      count++;
    }
    count++;
    if (id < count) {
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    document.getElementById(id).style.removeProperty('display');
    id++;
    document.getElementById("up").name = id;
    id--;
    id--;
    document.getElementById("down").name = id;
    }
  }

  function back(id) {
    var i, tabcontent, count = 0, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    if (id > count) {
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      document.getElementById(id).style.removeProperty('display');
      id++;
      document.getElementById("up").name = id;
      id--;
      id--;
      document.getElementById("down").name = id;
    }
  }
  </script>
</body>
</html>