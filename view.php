<?php

// ------------日付ごとの詳細ページ-------------------------------------//


// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$date_id = $_GET['id'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT * FROM log_table LEFT OUTER JOIN date_table ON log_table.date_id = date_table.id WHERE log_table.date_id = :date_id';
// $sql = 'SELECT * FROM log_table WHERE date_id = :date_id ORDER BY fishname ASC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date_id', $date_id, PDO::PARAM_STR);

//SELECT * FROM log_table LEFT OUTER JOIN log_table ON date_table.id = log_table.date_id;

//SELECT * FROM date_table LEFT OUTER JOIN log_table ON date_table.id = log_table.date_id WHERE log_table.date_id = :date_id ORDER BY log_table.fishname ASC;

// SELECT * FROM ( date_table LEFT OUTER JOIN log_table ON date_table.id = log_table.date_id ) AS main_table WHERE main_table.date_id = 27 ORDER BY main_table.fishname ASC;

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit();

$day = $result[0]['date'];
$temp = $result[0]['temp'];

$output = "";
foreach ($result as $record) {
  $output .= "
  <div class=fish_contatiner>
    <div></div>
    <div id=output{$record['id']} class=fish_contents>
      <a href=infomation.php?id={$record['fish_id']}><div class=fish_name>{$record['fishname']}</div></a>
      <div class=infomation>
        <div>水深{$record['depth']}ｍ</div>
      </div>
    </div>
  <div>
";
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fish data</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

</head>

<body>
  <header>

    <div id="header_left">
      <h1>Fish Data</h1>
    </div>

    <div id="header_right">
      <img src="./img/face.JPG" id="profile_image" alt="プロフィール画像">
      <div id="user_name"><?= $_SESSION['username'] ?></div>
      <a href="logout.php" id="logout_btn" class="btn">logout</a>
    </div>

  </header>

  <div id="wrapper">

    <!-- トップボタン部分 -->
    <div id="top_btn_section">
      <a href="main.php" id="top_btn">
        <div id="top_btn">TOP</div>
      </a>
    </div>

    <section id="title_section">
      <div id="date_title"><?= $day ?></div>
      <div id="temp_title">水温:<?= $temp ?>℃</div>
    </section>

    <section id="log_list">
      <?= $output ?>
    </section>

  </div>



</body>

</html>