<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>user_login</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/user_login.css">
</head>
<body>
<div class="wrap">
  {if isset($error)}
    <h1 class="error-txt"> {$error} </h1>
    <div>
      <form action="./login_form" method="post">
        <input type="hidden" name="login_id" value="{$id}">
        <input class="back_login" type="submit" value="Back To Login">
      </form>
    </div>
  {else}
  {$current_time}
  {$id}
    <h1 class="success"> Login successed. </h1>
    <div>
      <form action="./notice-board.php" method="post">
        <input type="hidden" name="login_id" value="{$id}">
        <input type="hidden" name="current_time" value="{$current_time}">
        <input class="to_board" type="submit" value="To Notice-Board">
      </form>
    </div>
  {/if}
</div>
</body>
</html>