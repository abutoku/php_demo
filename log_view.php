<?php
// ------------日付ごとの詳細ページ-------------------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$log_id = $_GET['id'];

// var_dump($log_id);
// exit();

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//タイトル表示のためにlog_tableからlog_idとuser_idが一致するものを取得
$sql = 'SELECT * FROM log_table WHERE id = :log_id AND user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':log_id', $log_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$date = $result['date'];//表示場所の変数へ代入
$dive_site = $result['dive_site'];//表示場所の変数へ代入
$dive_time = $result['dive_time'];//表示場所の変数へ代入
$temp = $result['temp'];//表示場所の変数へ代入
$comment = $result['comment']; //表示場所の変数へ代入


$sql = 'SELECT img,depth,name,info_id FROM life_table as a LEFT JOIN info_table as b ON a.info_id = b.id WHERE a.log_id = :log_id AND a.user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':log_id', $log_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL実行の処理
$val = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($val);
// echo '</pre>';
// exit();

$output = "";
foreach ($val as $record) {
  $img = htmlspecialchars($record["img"], ENT_QUOTES);
  $depth = htmlspecialchars($record["depth"], ENT_QUOTES);
  $name = htmlspecialchars($record["name"], ENT_QUOTES);
  $info_id = htmlspecialchars($record["info_id"], ENT_QUOTES);

  $output .= "
  <div class=life_contatiner>
    <div class=life_contents>
      <div class=life_pic>
      <img src={$img}>
      </div>

      <div class=infomation>
        <div>{$name}</div>
        <div>水深{$depth}ｍ</div>
      </div>
    </div>
  <div>
";
}

$title ='';

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

    <section id="title_section">
      <div id="date_title"><?= htmlspecialchars($date, ENT_QUOTES) ?></div>
      <div id="site_title"><?= htmlspecialchars($dive_site, ENT_QUOTES) ?></div>
      <div id="temp_title">水温:<?= htmlspecialchars($temp, ENT_QUOTES) ?>℃</div>
      <div id="time_title">DIVE TIME:<?= htmlspecialchars($dive_time, ENT_QUOTES) ?>min</div>
      <div id="comment_title"><?= htmlspecialchars($comment, ENT_QUOTES) ?></div>
    </section>

    <section id="life_list">
      <?= $output ?>
    </section>

  </div>

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>