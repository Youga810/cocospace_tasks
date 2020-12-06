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
  <h1 class="error"> {$error} </h1>
  <form action="./user_register" method="get">
    <input type="submit" class="back_register" value="Back To Register">
  </form>

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
</div>
</body>
</html>