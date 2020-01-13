<?php
session_start();
include '../config.php';

if ( !empty($_POST['benutzername']) and !empty($_POST['currKennwort']) and !empty($_POST['kennwort']) )
{
    // Kontrolle, ob Benutzername und Kennwort korrekt
    // diese werden i.d.R. aus Datenbank ausgelesen

    // UNSICHER!
    //$pdo = new PDO('mysql:host=localhost;dbname=NovaSystem', 'root', '');
    //$sql = "SELECT user FROM users WHERE password = '". $_POST["kennwort"] ."'";
    //$data = $pdo->query($sql)
  
    header("Location:https://nova.flumuffel.tk/"); 

}
 

// hier kommt Programmteil/Datenausgabe für berechtige Benutzer ...
?>