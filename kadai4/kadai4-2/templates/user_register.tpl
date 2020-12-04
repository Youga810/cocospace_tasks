<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_3_1</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/user_register.css">
</head>
<body>

<div class="wrap">
  <h1 class="register">Register</h1>
  <form action="./user_confirm.php" method="post">
    <input type="text" size="30" name="name" placeholder="UserName" value="{$name}">
    <input type="password" size="30" name="password" placeholder="Password" value="{$password}">
    <input type="email" size="30" name="address" placeholder="Email" value="{$address}">
    <input type="submit" value="Confirm">
  </form>

  <div class="login">Already have an account? <a class="login-link" href="./login_form.php">Login now</a></div>
</div>
<br><br>
<!--
--------------------------------＜以下デバッグ用＞---------------------------------------
<br>
<br>

    {if $cnt != 0}
      
      <table border="2">
      <tr>
        <td>名前</td>
        <td>パスワード</td>
        <td>登録日時</td>
        <td>本登録かどうか</td>
        <td>一意のID</td>
        <td>メールアドレス</td>
      </tr>
      {foreach $stmt as $value }
          
            <tr>
             <td> {$value['name']}</td>
             <td> {$value['password']}</td>
             <td> {$value['time']|date_format:"%Y年%m月%d日 %H時%M分%S秒"}</td>
             <td> {$value['flag']}</td>
             <td> {$value['id']}</td>
             <td> {$value['address']}</td>
            </tr>
          
        
      {/foreach}
      </table>
  
    {else}
      登録しているユーザーはいません。
    {/if}

-->

</body>
</html>