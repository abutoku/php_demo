<?php
//---プロフィール登録処理のphp----------------//

// セッションの開始
session_start();
//関数読み込み
include('../functions.php');
//セッション状態の確認の関数
check_session_id();

// var_dump($_POST);
// exit();

$username = $_POST['username'];
$card_rank = $_POST['card_rank'];
$dive_count = $_POST['dive_count'];
$user_id = $_SESSION['user_id'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//SQL users_tableに登録処理実行
$sql = 'INSERT INTO profile_table(id,username,card_rank,dive_count,birthday,profile_image,created_at,updated_at,user_id) VALUES (NULL,:username,:card_rank,:dive_count,NULL,"",now(),now(),:user_id)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':card_rank', $card_rank, PDO::PARAM_STR);
$stmt->bindValue(':dive_count', $dive_count, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:../main.php");
exit();

