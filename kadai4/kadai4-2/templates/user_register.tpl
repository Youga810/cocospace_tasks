<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai_3_1</title>
</head>
<body>


  <h1>ーユーザー登録フォームー</h1>
  <form action="./user_confirm.php" method="post">
  お名前：
  <input type="text" size="30" name="name" placeholder="鈴木太郎" value="{$name}"><br>
  パスワード
  <input type="password" size="30" name="password" placeholder="password" value="{$password}"><br>
  メールアドレス
  <input type="email" size="30" name="address" placeholder="abc@example.jp" value="{$address}">
  <input type="submit" value="確認">
</form>

<p>登録済みの方は<a href="./login_form.php">こちら</a></p>
<br><br>
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



</body>
</html>