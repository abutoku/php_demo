<?php

//--------------------日付のテーブルに登録処理---------------------------//


//関数読み込み
include('functions.php');

// var_dump($_POST);
// exit();

if (
  !isset($_POST['date']) || $_POST['date'] == '' ||
  !isset($_POST['dive_site']) || $_POST['dive_site'] == ''||
  !isset($_POST['temp']) || $_POST['temp'] == ''||
  !isset($_POST['user_id']) || $_POST['user_id'] == ''
) {
  exit('ParamError'); //エラーを返す
}

$date = $_POST['date'];
$dive_site = $_POST['dive_site'];
$temp = $_POST['temp'];
$user_id = $_POST['user_id'];

// var_dump($input_date);
// var_dump($user_id);
// exit();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

$sql = 'SELECT COUNT(*) FROM date_table WHERE user_id = :user_id AND date=:date';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $input_date, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  echo '<p>すでに登録されている日付です.</p>';
  echo '<a href="date_input.php">戻る</a>';
  exit();
}


//SQL 登録処理実行
$sql = 'INSERT INTO date_table(id,date,dive_site,temp,created_at,updated_at,user_id) VALUES(NULL,:date,:dive_site,:temp,now(),now(),:user_id)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date',$date, PDO::PARAM_STR);
$stmt->bindValue(':dive_site',$dive_site, PDO::PARAM_STR);
$stmt->bindValue(':temp',$temp, PDO::PARAM_STR);
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//処理が終わった後のページ移動
header("Location:date_input.php");
exit();


?>