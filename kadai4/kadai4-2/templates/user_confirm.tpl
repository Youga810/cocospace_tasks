<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user_confirm</title>
  <link rel="stylesheet" href="./css/common.css">

</head>

<body>


  <!--名前とパスワードとアドレスが入力されている場合-->
  {if !empty($register_name) && !empty($register_password) && !empty($register_address ) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$register_address)}


  <h1>ーユーザ情報の確認ー</h1>
  お名前：
  {$register_name}
  パスワード：
  {$register_password}
  メールアドレス：
  {$register_address}
  

      <!-- 確認フォーム -->
    <form action="./user_confirm.php" method="post">
    <input type="hidden" name="register_name" value="{$register_name}">
    <input type="hidden" name="register_password" value="{$register_password}">
    <input type="hidden" name="register_id" value="{$register_id}">
    <input type="hidden" name="register_address" value="{$register_address}">
    <input type="submit" value="登録">
  </form>


  {/if}
  <br>

  <form action="./user_register.php" method="get">
    <input type="submit" value="戻る">
  </form>

</body>

</html>