<?php

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$fish_id = $_GET['id'];

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];

// var_dump($fish_id);
// exit();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT * FROM fish_table WHERE id = :fish_id ';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':fish_id', $fish_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$output .= "<h1 id=fish_title>{$result['name']}</h1>";

$title = "fish infomation";


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>infomation</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

  <!-- font-awesome読み込み -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>

<body>
  <!-- ヘッダー読み込み -->
  <?php include('header.php'); ?>

  <div id="wrapper">

    <!-- トップボタン部分 -->
    <div id="top_btn_section">
      <a href="main.php" id="top_btn">
        <div id="top_btn">TOP</div>
      </a>
    </div>

    <section id="infometion_section">
      <?= $output ?>
    </section>


  </div>

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>