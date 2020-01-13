<?php
include 'config.php';

if (isset($_POST['search'])) {
    $stmt = $conn->prepare("SELECT * FROM warnings WHERE Username = :user");
    $stmt->bindParam(':user', $_POST["username"]);
    $stmt->execute();

    //echo "<table border ='1px'>";
    while ($row = $stmt->fetchAll()) {
        $count = 0;
        foreach ($row as $row1) {
            $count = $count + 1;
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row1['Username'] . '</td>';
            echo '<td>' . $row1['Reason'] . '</td>';
            echo '<td>' . $row1['Time'] . '</td>';
            echo '<td>' . $row1['By'] . '</td>';
            echo '</tr>';
        }
    }
    //echo '</table>';
}
