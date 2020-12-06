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
  <h1 class="login">Login</h1>
    <form action="./user_login" method="post">
      <input type="text" name="id" value="{$id}" placeholder="Id">
      <input type="password" name="password" placeholder="Password">
      <input class="login-btn" type="submit" value="Login">
    </form>
  <div class="signup">
    Not a member? <a class="signup-link" href="./user_register" >Register now</a>
  </div>
</div>
</body>
</html>