<?php

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール編集</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

</head>

<body>

  <form action="profile_edit.php" method="post" enctype="multipart/form-data">

    <h1>プロフィール画像</h1>

    <div>
      <input type="file" name="upfile" accept="image/*" capture="camera">
    </div>

    <button>submit</button>

  </form>

</body>

</html>