<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main_register.css">

</head>
<body>
<div class="wrap">
  {if isset($error)}

      <form action="./login_form" method="post">
       <div class="error">   
      {if $error == 1}
        <h1 class="error1"> Wrong Parameters </h1>
      {elseif $error == 2}
        <h2> id: <span class="error2">{$id} </span> is already registered.</h2>
        <input type="hidden" name="login_id" value="{$id}">
      {/if}
        <input type="submit" class="back_login" value="Back To Login">
        </div>    
      </form>

  {else}
    <div class="complete">
      Certification has been completed.<br>
      Please keep the following id and password.

      <table>
        <tr><td class="header">Id</td><td class="data">{$id}</td></tr>
        <tr><td class="header">Password</td><td class="data">{$password}</td></tr>
      </table>

      <form action="login_form.php" method="post">
        <input type="hidden" name="login_id" value="{$id}">
        <input class="back_login" type="submit" value="To Login">
      </form>
    </div>
  {/if}
</div>
</body>
</html>