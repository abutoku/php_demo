<?php
//--------------------日付のテーブル登録フォーム---------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

// var_dump($_SESSION);
// exit();

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];


// //SQL実行
// //今回は「ユーザが入力したデータ」を使用しないのでバインド変数は不要．
// $sql = 'SELECT * FROM date_table WHERE user_id = :user_id ORDER BY date ASC';
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);


// try {
//   $status = $stmt->execute();
// } catch (PDOException $e) {
//   echo json_encode(["sql error" => "{$e->getMessage()}"]);
//   exit();
// }

// SQL実行の処理
//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//繰り返し処理を用いて，取得したデータから HTML タグを生成する
// $output = ""; //表示のための変数
// foreach ($result as $record) {
//   $output .= "
//     <li class=date_txt><a href=log_input.php?id={$record["id"]}>{$record["date"]} {$record['dive_site']}</a></li>
//     ";
// }

//タグ
//<li><a href=fish_input.php?id=date_id> date </a></li>
$title = "Date input page";

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Date Input</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

  <!-- font-awesome読み込み -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>

<body>

  <!-- ヘッダー読み込み -->
  <?php include('header.php'); ?>

  <div id="wrapper">

    <!-- データ入力部分 -->
    <section id="log_input_section">
      
      <form action="log_create.php" method="post" id="date_form">

        <!-- 日付を入力 -->
        <input type="date" name="date">

        <!-- ダイビングポイントを選択 -->
        <div>
          <p>Dive site</p>
          <input type="text" name="dive_site" required>
        </div>

        <!-- ダイブタイムを選択 -->
        <div>
          <p>Dive Time</p>
          <input type="number" min="0"  value="45" name="dive_time" required>
        </div>

        <!-- 水温を選択 -->
        <div>
          <p>水温</p>
          <input type="number" name="temp" min="0" max="40" value="20" required>
        </div>

        <!-- コメントを入力 -->
        <div>
          <p>コメント</p>
          <textarea type="textarea" name="comment" required></textarea>
        </div>

        <!-- 送信ボタン -->
        <button type="submit" id="log_add_btn">add</button>

      </form>
    </section>

    <!-- データ出力部分 -->
    <section id="output_section">

      <div>
        <ul>
          <?= $output ?>
        </ul>
      </div>

    </section>

  </div><!-- wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>