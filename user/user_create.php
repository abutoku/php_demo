<?php
//---------------ユーザー登録処理----------------------------------------//

// セッションの開始
session_start();
//関数読み込み
include('../functions.php');

// var_dump($_POST);
// exit();

//データの受け取り
$email = $_POST['email'];
//パスワードはハッシュ化して受取り
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//メールアドレスが一致しているものがあるかの件数を取得
$sql = 'SELECT COUNT(*) FROM users_table WHERE email=:email';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//もし同じメールアドレスが登録済みであればエラー
if ($stmt->fetchColumn() > 0) {
  echo '<p>すでに登録されているメールアドレスです．</p>';
  echo '<a href="todo_login.php">login</a>';
  exit();
}

//SQL users_tableに登録処理実行
$sql = 'INSERT INTO users_table(id, email, password, is_admin,is_deleted,created_at, updated_at) 
VALUES(NULL, :email, :password,0,0,now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//SQL users_tableのidを取得
$sql = 'SELECT id FROM users_table WHERE id = LAST_INSERT_ID()';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$createid = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($createid['id']);
exit();


$_SESSION = array(); //セッションを一旦リセット
$_SESSION['session_id'] = session_id(); //セッションIDを取得
$_SESSION['user_id'] = $$createid['id'];//user_idをセッションに渡す

//処理が終わった後はプロフィール登録ページへ移動
header("Location:profile_input.php");
exit();

?>