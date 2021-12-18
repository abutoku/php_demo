<?php

// セッションの開始
session_start();
//関数読み込み
include('../functions.php');
//セッション状態の確認の関数
check_session_id();

// var_dump($_SESSION);
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール登録</title>

  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div id="wrapper">
    <h1>プロフィール登録</h1>
    <form action="profile_create.php" method="post">

      <div>
        <p>名前</p>
        <input type="text" name="username">
      </div>

      <div>
        <p>カードランク</p>
        <select name="card_rank" id="card_rank">
          <option value="OW">OW</option>
          <option value="AOW">AOW</option>
          <option value="MSD">MSD</option>
          <option value="DM">DM</option>
        </select>
      </div>

      <div>
        <p>ダイブ本数</p>
        <input type="number" name="dive_count">
      </div>

      <button type="submit">登録</button>

    </form>
  </div>
  <!--wrapperここまで-->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>