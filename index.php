
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>User Rank</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "index.css" />
     <style>
      .jumbotron{    
       border-radius: 0px;
       text-align: center;
        }
     </style>
  </head>

  <body>
    <div class="jumbotron" style="border-radius: 0px; text-align: center;">
    
      <h4 class="display-4">English Wikipedia UserRank </h4><hr/>
     
      <form class="" id="myForm" action="#" method="post">
        <div class="input-group col-sm-6" style="margin:auto;">
      <input type="text" class="form-control" name='user' aria-label="Text input with dropdown button" placeholder="Enter user name">
      <div class="input-group-btn">
 <input type="submit" class="btn btn-warning " aria-haspopup="true" aria-expanded="false">
          Action
        </button>
     
    </div>
      </form>
    </div>
  </div><br/>

<?php
class wikiuserrank

  {
  function getrank($username)
    {
    $ts_pw = posix_getpwuid(posix_getuid());
    $ts_mycnf = parse_ini_file($ts_pw['dir'] . "/replica.my.cnf");
    $conn = mysqli('enwiki.labsdb', $ts_mycnf['user'], $ts_mycnf['password'], 'enwiki_p');
    if ($conn->connect_error)
      {
      die("Connection failed: " . $conn->connect_error);
      }

    $stmt = $conn->prepare("select count(*) as list from user where user_name =?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if ($result == false)
      {
      echo 'failed to fetch data';
      return;
      }

    $user = $result1->fetch_assoc() ["list"];
    if ($user == 0)
      {
      echo "<div class='well well-lg' style='margin:auto;width:500px;'> User does not exit in database   
     </div>";
      }
      else
      {
      $stmt1 = $conn->prepare("select count(*) as rank from user where user_editcount >
        ( select user_editcount from user where user_name = ?)");
      $stmt1->bind_param('s', $username);
      $stmt1->execute();
      $result2 = $stmt1->get_result();
      if ($result2 == false)
        {
        echo 'failed';
        return;
        }

      $stmt2 = "SELECT count(*) as list from user";
      $result3 = $conn->query($stmt2);
      if ($result3 == false)
        {
        echo 'failed.';
        return;
        }

      $total_no_user = $result3->fetch_assoc() ["list"];
      echo "<div class='well well-lg' style='margin:auto;width:500px;'>
                 Username: " . $username . "<br /> Rank: " . ($res2->fetch_assoc() ["rank"] + 1) . "<br />Total number of users: " . $total_no_user . "</div></div>";
      }

    $mysqli->close();
    }
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
  $username = $_POST['user'];
  $ob = new wikiuserrank();
  $ob->getrank($username);
  }

?>

  </body>
</html>
