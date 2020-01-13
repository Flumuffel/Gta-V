<?php
session_start();
if ( isset($_SESSION["id"]) )
{
    // Benutzer begruessen
    header("Location:https://nova.flumuffel.tk/desktop.php"); 
    exit;
}

if ( !empty($_POST['benutzername']) and !empty($_POST['kennwort'])  )
{
    // Kontrolle, ob Benutzername und Kennwort korrekt
    // diese werden i.d.R. aus Datenbank ausgelesen

    // UNSICHER!
    //$pdo = new PDO('mysql:host=localhost;dbname=NovaSystem', 'root', '');
    //$sql = "SELECT user FROM users WHERE password = '". $_POST["kennwort"] ."'";
    //$data = $pdo->query($sql)

    include '../config.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = :user"); 
    $stmt->bindParam(':user', $_POST["benutzername"]);
    $stmt->execute(); 

    $row = $stmt->fetch();

    $Erfolgreich = false;

    if(!empty($row)) {
        $Erfolgreich = password_verify($_POST["kennwort"], $row["Password"]);
    }

    if ($Erfolgreich)
    {
        //$stmt = $conn->prepare("UPDATE users SET LastLogin= :time WHERE id= :id"); 
        //date_default_timezone_set('Europe/Berlin');
        //$test = 'Fri, 15 Jan 2016 02:07:10 +0800';
        //$t = date('Y-m-d H:i:s',strtotime($test));
        //print_r($t);
        //exit;
        //$stmt->bindParam(':time', $date);
        //$stmt->bindParam(':id', $row["id"]);
        //$stmt->execute(); 
        $_SESSION['id'] = $row['id'];
        $_SESSION['benutzername'] = $_POST['benutzername'];
        header("Location: https://nova.flumuffel.tk/desktop.php"); 
        echo "<b>einloggen erfolgreich</b>";
    }
    else
    {
        header("Location: https://nova.flumuffel.tk/?error"); 
        echo "<b>ungültige Eingabe</b>";
        unset($_SESSION["id"]);
    }
    mysqli_close($conn);
}
 

// hier kommt Programmteil/Datenausgabe für berechtige Benutzer ...
?>