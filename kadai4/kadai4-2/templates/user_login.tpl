<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>user_login</title>
  <link rel="stylesheet" href="./css/common.css">

</head>
<body>

{if isset($error)}
  <span style="color:#ff0000;">
    {$error}
  </span>
  <form action="./login_form.php" method="post">
    <input type="hidden" name="login_id" value="{$id}">
    <input type="submit" value="戻る">
  </form>
{else}
  ログインに成功しました。
  <form action="./notice-board.php" method="post">
    <input type="hidden" name="login_id" value="{$id}">
    <input type="submit" value="掲示板へ">
  </form>
{/if}

</body>
</html>