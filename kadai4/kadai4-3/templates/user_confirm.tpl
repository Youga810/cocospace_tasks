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

  <div class="wrap">
  <!--名前とパスワードとアドレスが入力されている場合-->
  {if !empty($register_name) && !empty($register_password) && !empty($register_address ) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$register_address)}


    <h1 class="confirm">Confirm</h1>

    <table>
      <tr><td class="header">UserName</td><td class="data">{$register_name}</td></tr>
      <tr><td class="header">Password</td><td class="data">{$register_password}</td></tr>
      <tr><td class="header">Email</td><td class="data">{$register_address}</td></tr>
    </table>
    <div class="btn">
      <form action="./user_register" method="get">
        <input type="submit" class="back" value="Cancel">
      </form>
      <!-- 確認フォーム -->
      <form action="./user_confirm.php" method="post">
        <input type="hidden" name="register_name" value="{$register_name}">
        <input type="hidden" name="register_password" value="{$register_password}">
        <input type="hidden" name="register_id" value="{$register_id}">
        <input type="hidden" name="register_address" value="{$register_address}">
        
        <input type="submit" class="register" value="Register">
      </form>
    </div>
    {else}
      <h1 class="emsg"> {$error} </h1>
        {if !empty($tmpmsg) }
          <div class="msg">
            We have sent the verification URL to the following email address.
            <p class="tmpmsg"> {$tmpmsg} </p>
            Click to complete the authentication.
          </div>
        {/if}
      <div class="error">
        <form action="./user_register" method="get">
          <input type="submit" class="back_register" value="Back To Register">
        </form>
        <form action="./login_form" method="get">
          <input type="submit" class="back_login" value="Back To Login">
        </form>
      </div>
    {/if}
    <br>


  </div>
</body>

</html>