<?php

class CurlHelper {
  private $curl;
  
  public function __construct() {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);  
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);     
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    
      $this->curl = $ch;
  }
  
  public function get($url) {
    curl_setopt($this->curl, CURLOPT_URL, $url);
    return curl_exec($this->curl);
  }
  
  public function close() {
    curl_close($this->curl);
  }
}
  
function getUserData($username)
{

    $cacheFile = "./cache/" . sha1(strtolower($username)) . ".user.cache";
    //$cacheFile = "./cache/" . $username . ".user.cache";

    //if(!isset($_RAMCACHE)) $_RAMCACHE = array(); // Temporärer RAM Cache.. schneller halt
    //if(!empty($_RAMCACHE[$cacheFile])) return $_RAMCACHE[$cacheFile];

    if (!file_exists($cacheFile) || filemtime($cacheFile) < (time() - 300)) {
        
        $curl = new CurlHelper();
      
        $get_data = $curl->get('https://api.roblox.com/users/get-by-username?username=' . $username);
        $data = json_decode($get_data, true);
        
        if(isset($data["success"]) && $data["success"] === false) {
          die("User not found."); // Dreckig aber funktioniert
        }

      
        $get_group_infos = $curl->get('https://api.roblox.com/users/' . $data['Id'] . '/groups');
        $get_admin_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/7920675');
        $get_mod_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/5762542');
        $get_mod_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/7852058');
        $get_admin_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/5762543');
        $get_admin_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/7852069');
        $get_owner_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/5762546');
        $get_owner_data = $curl->get('https://inventory.roblox.com/v1/users/' . $data['Id'] . '/items/GamePass/7852073');
      
        $curl->close();
        $curl = null;
      
      
        $data["Groups"] = json_decode($get_group_infos, true);         
        $admin['worker'] = json_decode($get_admin_data, true);
        $admin['mod'] = json_decode($get_mod_data, true);
        $admin['new mod'] = json_decode($get_mod_data, true);
        $admin['admin'] = json_decode($get_admin_data, true);
        $admin['new admin'] = json_decode($get_admin_data, true);
        $admin['owner'] = json_decode($get_owner_data, true);
        $admin['new owner'] = json_decode($get_owner_data, true);
      
        $admin['worker'] = isset($admin['worker']['data'][0]['name']) ? "Worker" : 0;
        $admin['mod'] = isset($admin['mod']['data'][0]['name']) ? "Mod" : 0;
        $admin['new mod'] = isset($admin['new mod']['data'][0]['name']) ? "New Mod" : 0;
        $admin['admin'] = isset($admin['admin']['data'][0]['name']) ? "Admin" : 0;
        $admin['new admin'] = isset($admin['new admin']['data'][0]['name']) ? "New Admin" : 0;
        $admin['owner'] = isset($admin['owner']['data'][0]['name']) ? "Owner" : 0;
        $admin['new owner'] = isset($admin['new owner']['data'][0]['name']) ? "New Owner" : 0;
        
        /*
        if(isset($admin['worker']['data'][0]['name'])){ $admin['worker'] = 'Worker'; } else { $admin['worker'] = 0; }
        if(isset($admin['mod']['data'][0]['name'])){ $admin['mod'] = 'Mod'; } else { $admin['mod'] = 0; }
        if(isset($admin['new mod']['data'][0]['name'])){ $admin['new mod'] = 'New Mod'; } else { $admin['new mod'] = 0; }
        if(isset($admin['admin']['data'][0]['name'])){ $admin['admin'] = 'Admin'; } else { $admin['admin'] = 0; }
        if(isset($admin['new admin']['data'][0]['name'])){ $admin['new admin'] = 'New Admin'; } else { $admin['new admin'] = 0; }
        if(isset($admin['owner']['data'][0]['name'])){ $admin['owner'] = 'Owner'; } else { $admin['owner'] = 0; }
        if(isset($admin['new owner']['data'][0]['name'])){ $admin['new owner'] = 'New Owner'; } else { $admin['new owner'] = 0; }
        */
        foreach ($admin as $item) {
          if($item !== 0){
            $data['Admin'] = $item;
          }
        }
        
        if(file_exists($cacheFile))
        unlink($cacheFile);
        file_put_contents($cacheFile, serialize($data));
        echo "<script>console.log('Cache Miss: getUserData')</script>";
    } else {
        echo "<script>console.log('Cache Hit: getUserData')</script>";
        $get_data = file_get_contents($cacheFile);
        $data = unserialize($get_data);
    }
    //$_RAMCACHE[$cacheFile] = $data; // Dies wird den cache ebenfalls im RAM behalten
    // Schneller falls die Speicher zugriffe von glitch lahm sind
  
    return $data;
}


function getStatsData($type, $value)
{
    session_start();
    $username = $_SESSION['benutzername'];
    $cacheFile = "./cache/" . sha1(strtolower($username)) . ".stats.cache";
  
    //if(!isset($_RAMCACHE)) $_RAMCACHE = array(); // Temporärer RAM Cache.. schneller halt
    //if(!empty($_RAMCACHE[$cacheFile])) return $_RAMCACHE[$cacheFile. ":" . $type . ":" . $value];
  
    $content = file_get_contents($cacheFile);
    $test = unserialize($content);
    if (!file_exists($cacheFile) || $test[$type]['LastUpdate'] < (time() - 300)) {
        unlink($cacheFile);
        $data = unserialize($content);
        $array = getMostUserStats($type,$value);
        $data[$type]['LastUpdate'] = time();
        $data[$type][$value] = $array;

        file_put_contents($cacheFile, serialize($data));
    } else {
        $data = unserialize($content);
    }
    //$_RAMCACHE[$cacheFile. ":" . $type . ":" . $value] = $data[$type][$value];
    return $data[$type][$value];
}


function getMostUserStats($type, $value) {
  switch($type) {
    case 'label';
      $type = 'notes';
      break;
    case 'notes':
      $type = 'notes';
      break;
    case 'warnings':
      $type = 'warnings';
      break;
    case 'kicks':
      $type = 'kicks';
      break;
    case 'bans':
      $type = 'bans';
      break;
    default:
      die();
  }
  $data = array();
  $user = array();
  include 'config.php';
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY Username ASC");
    $stmt->execute();
  
    while ($row = $stmt->fetchAll()) {
      foreach ($row as $item) {
        array_push($user, $item['Username']);
      }
    }
  $data['label'] = [];
  $data['value'] = [];
  foreach ($user as $item) {
    $count = 0;
    $stmt2 = $conn->prepare("SELECT * FROM " . $type . "  WHERE Creator = :user AND Time > NOW() - INTERVAL 1 DAY ORDER BY Creator ASC");
    $stmt2->bindParam(':user', $item);
    $stmt2->execute();
    
    while ($row2 = $stmt2->fetchAll()) {
      foreach ($row2 as $item2) {
        $count = $count + 1;
      }
    }
    if($count>0) {
    array_push($data['label'], $item);
    array_push($data['value'], $count);
    }
  }
  $string = "'" . implode ( "', '", $data[$value] ) . "'";
  return $string;
}
