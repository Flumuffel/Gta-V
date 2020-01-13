<?php
    /*
    * Created on 30.01.2010 by Nico Schubert
    */
    $dir =
        $_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PH
        P_SELF']).'/test/';
    $folder = dir($dir);
    while ($dateiname = $folder->read()) {
        if (filetype($dir.$dateiname) != "dir") {
            if (strtotime("-2 weeks") >
                @filemtime($dir.$dateiname)) {
                if (@unlink($dir.$dateiname) != false)
                echo $dateiname.' wurde gelöscht<br>';
                else
                echo $dateiname.' konnte nicht
                    gelöscht werden<br>';
                }
        }
    }
    echo "Fertig";
    $folder->close();
    exit;
?>