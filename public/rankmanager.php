<?php
  define('BANNED',-1);
  define("USER",0);
  define("CREATE",1);
  define("DELETE",2);
  define("ADMIN",3);
  define("OWNER",4);

function getRank($username) {
  require('config.php');
  $stmt = $conn->prepare('SELECT * FROM users WHERE Username = :user');
  $stmt->bindParam(':user', $username);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row['ServerRank'];
}

function isBanned($username){
  if(getRank($username) === -1){
    return true;
  } else {
    return false;
  }
}