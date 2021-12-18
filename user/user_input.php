<!-- 新規登録画面 -->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>

  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">

</head>

<body>
  <div id="wrapper">
    <h1>新規登録</h1>
    <form action="user_create.php" method="post">
      <div>
        <p>email</p>
        <input type="email" name="email" required>
      </div>
      <div>
        <p>password</p>
        <input type="password" name="password" required>
      </div>

      <button type="submit">登録</button>
    </form>
  </div>
  <!--wrapperここまで-->
  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>