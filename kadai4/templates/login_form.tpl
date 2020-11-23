<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>login_form</title>
     <link rel="stylesheet" href="comn/style.css">
</head>
<body>

  <h1>ーログインー</h1>
  未登録の方は<a href="./user_register.php">こちら</a> <br><br>
  <form action="./user_login.php" method="post">
    ID：<input type="text" name="id" value="{$id}" placeholder="ID"><br>
    パスワード：<input type="password" name="password" placeholder="パスワード">
    <input type="submit" value="ログイン">
  </form>

</body>
</html>