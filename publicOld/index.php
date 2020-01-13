<?php
header("Access-Control-Allow-Origin: *");  

if(isset($_GET["groupCheck"])) {
  echo file_get_contents("https://api.roblox.com/users/get-by-username?username=" . $_GET["userName"]);
  die("");
}

if(isset($_GET["groupCheck2"])) {
  echo file_get_contents("https://api.roblox.com/users/".$_GET["uid"]."/groups");
  die("");
}

if(isset($_GET["friendCheck"])) {
  echo file_get_contents("https://api.roblox.com/users/get-by-username?username=" . $_GET["userName"]);
  die("");
}
if(isset($_GET["friendCheck2"])) {
  echo file_get_contents("https://api.roblox.com/users/" . $_GET["uid"] . "/friends");
  die("");
}

?>
<!DOCTYPE html header("Access-Control-Allow-Origin: http://flumuffel.bplaced.net/nova/test.html");>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nova System</title>
</head>

<body>
    <div style="margin: auto; width: 20%; padding: 10px;">
        <div id="response">
            <p>Status: </p>
        </div>
        <form action="">
            <div style="margin: 0.2cm;">
                <select name="option" id="option" required>
                    <option value="">Choose...</option>
                    <option value="Friend">Check friendship</option>
                    <option value="Group">Check Group</option>
                </select>
            </div>
            <div style="margin: 0.2cm;">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" required>
            </div>
            <div style="margin: 0.2cm;">
                <label for="fusername">Friend: </label>
                <input type="text" name="fusername" id="fusername" required>
            </div>
            <button type="button" style="margin: 0.2cm;" id="friendCheck">Check Friendship</button>
        </form>
        <div id="group"></div>
    </div>




    <script type="text/javascript">

        document.querySelector('#friendCheck').addEventListener('click', function () {
            var option = document.getElementById('option').value
            if (option == 'Friend') {
                friendCheck()
            } else if (option == 'Group') {
                groupCheck()
            } else {
                document.getElementById('response').innerHTML = '<p>Status: Choose a operation!</p>'
                setTimeout(function () { document.getElementById('response').innerHTML = '<p>Status: </p>' }, 2000)
            }
        })


        function friendCheck() {
            var Http = new XMLHttpRequest()
              Http.withCredentials = true; 
            var userName = document.getElementById('username').value
            var fuserId = document.getElementById('fusername').value
            var uurl = `?friendCheck&userName=${userName}`
            Http.open('GET', uurl, false)
            Http.send(null)
            var response2 = JSON.parse(Http.responseText)
            var furl = `?friendCheck2&uid=${response2.Id}`
            Http.open('GET', furl, false);
            Http.send(null);
            var response = JSON.parse(Http.responseText)
            readArray(response)

            function readArray(arr) {
                var out = ""
                var i
                for (i = 0; i < arr.length; i++) {
                    if (arr[i].Username == fuserId) {
                        document.getElementById('response').innerHTML = '<p>Status: They are friends!</p>'
                        break
                    } else {
                        document.getElementById('response').innerHTML = '<p>Status: They are not friends!</p>'
                    }

                }

            }
        }

        function groupCheck() {
            var Http = new XMLHttpRequest()
            var groupId = 4683371
            var userName = document.getElementById('username').value
            var uurl = `?groupCheck&userName=${userName}`
            Http.open('GET', uurl, false)
            Http.send(null)
            var response2 = JSON.parse(Http.responseText)
            var furl = `?groupCheck2&uid=${response2.Id}`
            Http.open('GET', furl, false);
            Http.send(null);
            var response = JSON.parse(Http.responseText)
            readArray(response)

            function readArray(arr) {
                var out = ""
                var i
                for (i = 0; i < arr.length; i++) {
                    if (arr[i].Id == groupId) {
                        document.getElementById('response').innerHTML = '<p>Status: Got User Information!</p>'
                        document.getElementById('group').innerHTML = `<p>Rank: ${arr[i].Rank}</p><p>Role: ${arr[i].Role}</p><p>Primary: ${arr[i].IsPrimary}</p>`
                        break
                    } else {
                        document.getElementById('response').innerHTML = '<p>Status: They user isn\'t in the Group!</p>'
                    }

                }

            }
        }

    </script>
</body>

</html>