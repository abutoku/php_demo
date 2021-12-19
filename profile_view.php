<?php
//--------------------プロフィール画面---------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT card_rank,dive_count,birthday 
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

$card_rank = $user['card_rank'];
$dive_count = $user['dive_count'];
$birthday = $user['birthday'] == null ? '未登録' : $user['birthday'];


$title = "profile page";

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

  <!-- プロフィール写真アップロードモーダル -->
  <div id="img_mask">
    <div class="fas fa-times"></div>
  </div>
  <!-- プロフィール写真アップロードフォーム -->
  <div id="img_upload_inner">
    <form action="./profile_img_upload.php" id="img_upload_form" method="post" enctype="multipart/form-data">
      <img src=<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?> class="my_img" id="demo_img">
      <input type="file" name="upfile" id="new_profile_img" accept="image/*">
      <button type="sumit" id="img_upload_btn">変更</button>
    </form>
  </div>

  <!-- ヘッダー読み込み -->
  <?php include('./header.php'); ?>

  <div id="wrapper">

    <!-- 写真表示部分 -->
    <section id="img_section">
      <img src=<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?> class="my_img" alt="プロフィール写真">
      <p id="img_edit">写真変更</p>
    </section>

    <!-- プロフィール表示部分 -->
    <section id="profile_section">
      <h1><?= htmlspecialchars($username, ENT_QUOTES) ?></h1>

      <table>
        <!-- カードランク -->
        <tr>
          <th>RANK:</th>
          <td><?= htmlspecialchars($card_rank, ENT_QUOTES) ?></td>
        </tr>
        <!-- ダイブ本数 -->
        <tr>
          <th>ダイブ本数:</th>
          <td><?= htmlspecialchars($dive_count, ENT_QUOTES) ?></td>
        </tr>
        <!-- 最終ダイブ -->
        <tr>
          <th>最終ダイブ:</th>
          <td>未実装</td>
        </tr>

      </table>
    </section>

    <!-- 器材一覧表示部分 -->
    <section id="gear_section">
      <h1>使用器材</h1>

      <table>
        <tr>
          <th>ダイブコンピューター</th>
          <td>未実装</td>
        </tr>
        <tr>
          <th>マスク</th>
          <td>未実装</td>
        </tr>
        <tr>
          <th>スノーケル</th>
          <td>未実装</td>
        </tr>
        <tr>
          <th>フィン</th>
          <td>未実装</td>
        </tr>
        <tr>
          <th>レギュレーター</th>
          <td>未実装</td>
        </tr>
        <tr>
          <th>BCD</th>
          <td>未実装</td>
        </tr>

      </table>
      <!-- 使用カメラ表示部分 -->
      <section id="camera_section">
        <h1>使用カメラ</h1>

        <table>

          <tr>
            <th>カメラ1</th>
            <td>未実装</td>
          </tr>
          <tr>
            <th>カメラ2</th>
            <td>未実装</td>
          </tr>

        </table>
      </section>

      <!-- 編集ボタンの表示エリア -->
      <section id="edit_btn_section">
        <a href="" class="edit_btn">
          <div>プロフィール編集</div>
        </a>
        <a href="" class="edit_btn">
          <div>器材編集</div>
        </a>
        <a href="" class="edit_btn">
          <div>カメラ編集</div>
        </a>
        <a href="main.php" class="edit_btn">
          <div>TOP</div>
        </a>
      </section>

  </div><!-- wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

</body>

</html>