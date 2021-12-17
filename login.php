<!-- ログインフォーム -->
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
</head>

<body>
  <!-- 入力情報をcheck.phpへ -->
  <form action="login_check.php" method="post">
    <fieldset>
      <legend>Login</legend>
      <div>
        username: <input type="text" name="username">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
      <a href="user_input.php">Create ID</a>
    </fieldset>
  </form>

</body>

</html>