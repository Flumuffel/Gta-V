<?php
  

$time_start = microtime(true);

if(!isset($conn)) {
  $conn = new PDO('mysql:host=mysql.Tutorialwork.de;dbname=Flumuffel', 'Flumuffel', 'Lucaspielt2004');
}

$time_end = microtime(true);
$time = $time_end - $time_start;

if(isset($_SESSION["database_time"]))
$_SESSION["database_time"] = $_SESSION["database_time"] + $time;

//echo "<script>console.log('Database-Start took $time ms')</script>";