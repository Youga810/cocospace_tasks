<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
{if isset($error)}
<span style="color:#ff0000;">
  {$error} <br>
  <a href="user_register.php">ユーザ登録フォームへ</a>
</span>

{else}
    認証が完了しました。<br>
    以下のidとpasswordは大切に保管してください。<br><br>
    id:{$id}<br>
    password:{$password}<br>
    <form action="login_form.php" method="post">
      <input type="hidden" name="login_id" value="{$id}">
      <input type="submit" value="ログインフォームへ">
    </form>
{/if}
</body>
</html>