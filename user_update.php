<?php

//----------------登録ユーザー更新処理------------------------------------------//

//関数読み込み
include('functions.php');

// var_dump($_POST);
// exit();

if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == '' ||
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  exit('paramError');
}

$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];

// var_dump($username);
// var_dump($password);
// var_dump($id);
// exit();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

// SQL実行 UPDATE の SQL を実行
//取得したidと一致したものを更新（書き換え）
//必ず WHERE で id を指定すること！！！
$sql = 'UPDATE users_table SET username = :username, password = :password, updated_at = now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//一覧画面へ戻る
header("Location:user_list.php");
exit();

?>