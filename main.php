<?php
//-----------トップ画面------------------------------------//

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

//ログインしているユーザーの情報を取得
// profile_table(a)とusers_table(b)を結合
$sql = 'SELECT username,card_rank,dive_count,birthday,profile_image,user_id 
FROM profile_table as a LEFT JOIN users_table as b ON user_id = b.id 
WHERE a.user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$userに渡す
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['username'] = $user['username'];//セッションにユーザ名を渡す
$_SESSION['profile_image'] = $user['profile_image'];//セッションにプロフィール画像のURLを渡す

//もし画像の登録がなければ仮の画像のパスを代入
if (!$_SESSION['profile_image']) {
  $_SESSION['profile_image'] = 'img/null.png';
}
//セッションから変数に代入
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];


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

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>