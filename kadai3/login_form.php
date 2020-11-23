<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
</head>

<body>

<?php
  if(isset($_POST['login_id'])){
  $id = $_POST['login_id'];
  }else{
    $id = "";
  }
?>
  <h1>ーログインー</h1>
  未登録の方は<a href="user_register.php">こちら</a> <br><br>
  <form action="./user_login.php" method="post">
    ID：<input type="text" name="id" value="<?php echo $id; ?>" placeholder="ID"><br>
    パスワード：<input type="password" name="password" placeholder="パスワード">
    <input type="submit" value="ログイン">
  </form>
</body>


</html>
