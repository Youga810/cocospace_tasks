<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>login_form</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/login_form.css">
</head>
<body>
<div class="wrap"> 
  <h1 class="login">ーログインー</h1>
  <div class="login">
    未登録の方は<a href="./user_register.php" >こちら</a>
  </div>
   <br><br>
  <form action="./user_login.php" method="post">
    ID：<input type="text" name="id" value="{$id}" placeholder="ID"><br>
    パスワード：<input type="password" name="password" placeholder="パスワード">
    <input type="submit" value="ログイン">
  </form>
</div>
</body>
</html>