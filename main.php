<?php
//--------------------トップ画面-----------------------------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

//変数にユーザーIDとユーザータイプを取得
$user_id = $_SESSION['user_id'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//date-tableからuserIDが一致しているものを取得
$sql = 'SELECT id,date,dive_site 
FROM date_table WHERE user_id = :user_id 
ORDER BY date DESC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

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


$sql = 'SELECT profile_image FROM profile_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
  $image["profile_image"] = 'img/null.png';
}

// echo '<pre>';
// var_dump($image);
// echo '</pre>';
// exit();

//繰り返し処理を用いて，取得したデータから HTML タグを生成する
$output = ""; //表示のための変数
foreach ($result as $record) {
  //エスケープ処理
  $id = htmlspecialchars($record["id"], ENT_QUOTES);
  $date = htmlspecialchars($record["date"], ENT_QUOTES);
  $dive_site = htmlspecialchars($record["dive_site"], ENT_QUOTES);

  $output .= "
    <a href=view.php?id={$id}><li class=date_txt>{$date} {$dive_site}</li></a>
";
}

//タグづけ
//<a href=view.php?id=date_id<li class=btn date_txt> date dive_site</li></a>

//タイトル表示のための変数
$title = "Top page";

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Fish LOG</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

  <!-- font-awesome読み込み -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>

<body>

  <!-- ヘッダー読み込み -->
  <?php include('header.php'); ?>

  <div id="wrapper">

    <!-- データ追加ボタン -->
    <section id="top_btn_section">
      <a href="date_input.php">
        <div id="add_btn" class="add">add</div>
        <i class="las la-paw"></i>
        <span class="fa-layers-counter" style="background:Tomato">1,419</span>
      </a>
    </section>

    <section id="search_section">
      <form action="result.php" method="post">
        <input type="text">
        <button type="submit">serch</button>
      </form>
    </section>

    <!-- 日付とポイント名出力部分 -->
    <section>
      <ul id="date_list">
        <?= $output ?>
        <!--PHP側でエスケープ処理済み -->
        <ul>
    </section>

  </div>
  <!-- wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>