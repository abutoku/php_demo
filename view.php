<?php
// ------------日付ごとの詳細ページ-------------------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$date_id = $_GET['id'];

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT date,dive_site,temp,name,depth,b.id
FROM log_table as a
LEFT JOIN fish_table as b ON a.fish_id = b.id 
LEFT JOIN date_table as c ON a.date_id = c.id 
WHERE a.date_id = :date_id
ORDER BY name ASC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date_id', $date_id, PDO::PARAM_STR);

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
    <div class=fish_contents>
      <a href=infomation.php?id={$record['id']}>
        <div class=fish_name>{$record['name']}</div>
      </a>

      <div class=infomation>
        <div>水深{$record['depth']}ｍ</div>
      </div>

    </div>
  <div>
";
}

$title ='fish infometion';

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

    <section id="title_section">
      <div id="date_title"><?= htmlspecialchars($day, ENT_QUOTES) ?></div>
      <div id="temp_title">水温:<?= htmlspecialchars($temp, ENT_QUOTES) ?>℃</div>
    </section>

    <section id="log_list">
      <?= $output ?>
    </section>

  </div>

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>