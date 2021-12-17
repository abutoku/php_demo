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
$admin = $_SESSION['is_admin'];


// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//date-tableからuserIDが一致しているものを取得
$sql = 'SELECT * FROM date_table WHERE user_id = :user_id ORDER BY date DESC';
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



if(!$image){
  $image["profile_image"] = 'img/null.png';
}

// echo '<pre>';
// var_dump($image);
// echo '</pre>';
// exit();



//繰り返し処理を用いて，取得したデータから HTML タグを生成する
$output = ""; //表示のための変数
foreach ($result as $record) {
  $output .= "
    <a href=view.php?id={$record["id"]}><li class=date_txt>{$record["date"]} {$record['dive_site']}</li></a>
";
}

//タグづけ
//<a href=view.php?id=date_id<li class=btn date_txt> date </li></a>

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

</head>

<body>
  <!-- ヘッダー部分 -->
  <header>

    <!-- ヘッダー左側 -->
    <div id="header_left">
      <h1>FISH Log</h1>
    </div>

    <!-- ヘッダー右側 -->
    <div id="header_right">
      <img src=<?= $image["profile_image"]?> id="profile_image">
      <div id="user_name"><?= $_SESSION['username'] ?></div>
      <a href="logout.php" id="logout_btn" class="btn">logout</a>
      <a href="profile_input.php">プロフィール画像を登録</a>
    </div>

  </header>

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
        <ul>
    </section>

  </div>

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</body>

</html>