<?php

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

$user_id = $_SESSION['user_id'];


// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// exit();

// データの確認
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // 情報の取得
  $uploaded_file_name = $_FILES['upfile']['name'];
  $temp_path  = $_FILES['upfile']['tmp_name'];
  $directory_path = 'img/';
  // ファイル名の準備
  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis') . md5(session_id()) . '.' . $extension;
  $save_path = $directory_path . $unique_name;
  // 今回は画面に表示しないので権限の変更までで終了
  if (is_uploaded_file($temp_path)) {
    if (move_uploaded_file($temp_path, $save_path)) {
      chmod($save_path, 0644);
    } else {
      exit('Error:アップロードできませんでした');
    }
  } else {
    exit('Error:画像がありません');
  }
} else {
  exit('Error:画像が送信されていません');
}
//upload完了

//-------「POST で受け取った todo のデータ」と「ファイルを保存したパス」をテーブルに保存-----

//DB接続
$pdo = connect_to_db();

// var_dump($user_id);
// exit();

$sql = 'INSERT INTO profile_table(id,user_id,profile_image,created_at,updated_at) VALUES (NULL,:user_id, :profile_image,now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_STR);
$stmt->bindValue(':profile_image', $save_path, PDO::PARAM_STR); //保存したパスをテーブルに追加

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//処理が終わった後のページ移動
header("Location:main.php");
exit();

?>