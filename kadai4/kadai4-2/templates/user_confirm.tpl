<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>user_confirm</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/user_confirm.css">
</head>

<body>


  <!--名前とパスワードとアドレスが入力されている場合-->
  {if !empty($register_name) && !empty($register_password) && !empty($register_address ) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$register_address)}

  <div class="wrap">
    <h1>Confirm</h1>

    <table>
      <tr><td class="header">UserName</td><td class="data">{$register_name}</td></tr>
      <tr><td class="header">Password</td><td class="data">{$register_password}</td></tr>
      <tr><td class="header">Email</td><td class="data">{$register_address}</td></tr>
    </table>

        <!-- 確認フォーム -->
      <form action="./user_confirm.php" method="post">
      <input type="hidden" name="register_name" value="{$register_name}">
      <input type="hidden" name="register_password" value="{$register_password}">
      <input type="hidden" name="register_id" value="{$register_id}">
      <input type="hidden" name="register_address" value="{$register_address}">
      <input type="submit" value="登録">
    </form>

    {else}
      入力漏れがあります
                      <table  class="ui celled table table table-hover" border="1">
                    <tr><td>タイトル</td><td>AA</td></tr>
                    <tr><td>お名前</td><td>BB</td></tr>
                    <tr><td>カテゴリー</td><td>CC</td></tr>
                    <tr><td>本文</td><td><pre>SS</pre></td></tr>
                </table>
    {/if}
    <br>

    <form action="./user_register.php" method="get">
      <input type="submit" value="戻る">
    </form>
  </div>
</body>

</html>