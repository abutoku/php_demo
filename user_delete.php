<?php

//---------------ユーザー登録処理----------------------------------------//


// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

// var_dump($_GET);
// exit();

$id = $_GET['id'];

// var_dump($id);
// exit();
//DB接続
$pdo = connect_to_db();

// SQL実行
//idが一致しているものを取得
$sql = 'UPDATE users_table SET is_deleted = 1, updated_at = now() WHERE id=:id';
$stmt = $pdo->prepare($sql);
//バインド変数にする順番が大事
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//ファイル単体の場合fetch、複数の場合はfetchAll
$record = $stmt->fetch(PDO::FETCH_ASSOC);

//一覧画面へ戻る
header("Location:user_list.php");
exit();


?>