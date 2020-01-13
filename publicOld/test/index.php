<?php
  if(isset($_POST["ausfuehren"])) {
    $zitate = file("zitate.txt");
    for($i=0;$i < count($zitate); $i++){
    echo $i.": ".$zitate[$i]."<br><br>";
  }
}
>
  
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing</title>
</head>

<body>
  <form action="" method="post">
     <input type="submit" name="Test" value="Testing"/>
  </form>
</body>

</html>