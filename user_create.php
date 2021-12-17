<?php

//---------------ユーザー登録処理----------------------------------------//

//関数読み込み
include('functions.php');

// var_dump($_POST);
// exit();

//データの受け取り
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// var_dump('name');
// var_dump('password');
// exit();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT COUNT(*) FROM users_table WHERE username=:username';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  echo '<p>すでに登録されているユーザです．</p>';
  echo '<a href="todo_login.php">login</a>';
  exit();
}

//SQL 登録処理実行
$sql = 'INSERT INTO users_table(id, username, password, is_admin,is_deleted,created_at, updated_at) VALUES(NULL, :username, :password,0,0,now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//処理が終わった後のページ移動
header("Location:login.php");
exit();


?>