<?php
//--------------------日付のテーブルに登録処理---------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

// var_dump($_POST);
// exit();

if (
  !isset($_POST['date']) || $_POST['date'] == '' ||
  !isset($_POST['dive_site']) || $_POST['dive_site'] == ''||
  !isset($_POST['dive_time']) || $_POST['dive_time'] == ''||
  !isset($_POST['temp']) || $_POST['temp'] == ''||
  !isset($_POST['comment']) || $_POST['comment'] == ''
) {
  exit('ParamError'); //エラーを返す
}

$date = $_POST['date'];
$dive_site = $_POST['dive_site'];
$dive_time = $_POST['dive_time'];
$temp = $_POST['temp'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];


// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//同じユーザーが同じ日付のログを作成していないかチェック
$sql = 'SELECT COUNT(*) FROM log_table WHERE user_id = :user_id AND date=:date';

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


//SQL log_tableにデータ登録
$sql = 'INSERT INTO log_table(id,date,dive_site,dive_time,temp,comment,created_at,updated_at,user_id) 
VALUES(NULL,:date,:dive_site,:dive_time,:temp,:comment,now(),now(),:user_id)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date',$date, PDO::PARAM_STR);
$stmt->bindValue(':dive_site',$dive_site, PDO::PARAM_STR);
$stmt->bindValue(':dive_time',$dive_time, PDO::PARAM_STR);
$stmt->bindValue(':temp',$temp, PDO::PARAM_STR);
$stmt->bindValue(':comment',$comment, PDO::PARAM_STR);
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//登録したログの情報を取得
$sql = 'SELECT * FROM log_table WHERE id = LAST_INSERT_ID()';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$log = $stmt->fetch(PDO::FETCH_ASSOC);



//セッションにログIDを渡す
$_SESSION['log_id'] = $log['id'];


//処理が終わったら、life_input生物登録のページ移動
header("Location:life_input.php");
exit();


?>