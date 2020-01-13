<?php
session_start();
$cacheFile = "../cache/" . $username . ".stats.cache";
unlink($cacheFile);
session_destroy();
header("Location: /");