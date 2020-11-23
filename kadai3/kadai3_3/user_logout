<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>logout</title>
</head>
<body>
  
<?php


  if(session_id()) { 
    if($_SESSION['timeout']){
      ?>
      セッションがタイムアウトしました。
      <?php
    }else{
        ?>
      ログアウトしました。
      <?php
      }
    $_SESSION = array();
    setcookie("PHPSESSID", '', time() - 1800);
  }
  session_destroy();



  

?>
<p><a href="./login_form.php">ログイン</a></p>

</body>
</html>
