<?php
//--------------------魚のテーブルに登録処理---------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();


//データの受け取りチェック
if (
  !isset($_POST['fishname']) || $_POST['fishname'] == '' ||
  !isset($_POST['depth']) || $_POST['depth'] == '' ||
  !isset($_POST['log_id']) || $_POST['log_id'] == ''
) {
  exit('ParamError'); //エラーを返す
}

// データの確認 正しくデータが送信されていれば，ファイル自体は tmp 領域に保存された状態
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  //送信が正常に行われたときの処理
  //情報の取得
  $uploaded_file_name = $_FILES['upfile']['name']; //ファイル名を取得
  $temp_path  = $_FILES['upfile']['tmp_name']; //一時保存されている場所を取得
  $directory_path = 'upload/'; //指定の保存場所
  // ファイル名の準備
  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION); //ファイルの拡張子の種類を取得
  $unique_name = date('YmdHis') . md5(session_id()) . '.' . $extension; //ユニークな名前を作成し，末尾に拡張子を追加
  $save_path = $directory_path . $unique_name; //指定の保存場所を追加し，保存用のパスを作成

  // tmp 領域から指定の保存場所へファイルを移動
  if (is_uploaded_file($temp_path)) { //tmp 領域にファイルが存在しているかどうか．
    if (move_uploaded_file($temp_path, $save_path)) { //ファイルの移動
      chmod($save_path, 0644); //権限の変更
    } else { //ファイルの移動ができていない場合
      exit('Error:アップロードできませんでした'); //エラーを返す
    }
  } else { //tmp 領域にファイルが存在していない場合
    exit('Error:画像がありません'); //エラーを返す
  }
} else { //送信が正常に行われていない場合
  exit('Error:画像が送信されていません'); //エラーを返す
}
//upload完了


// データの受け取り
$fishname = $_POST['fishname'];//生物の名前を取得
$img = $save_path;//画像のパスを取得
$depth = $_POST['depth'];//水深を取得
$user_id = $_SESSION['user_id'];//ユーザーidを取得
$log_id = $_POST['log_id'];//ログIDを取得



// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//fish_tableに同じ名前のものがあれば取得
$sql = 'SELECT * FROM fish_table WHERE name = :fishname';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':fishname', $fishname, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$fishに受け取り
$fish = $stmt->fetch(PDO::FETCH_ASSOC);

//fish_tableにすでに登録されているかで条件分岐
if($fish){ //すでに登録されている場合は
  $fish_id = $fish['id']; //fish_tableのIDを取得
  
  //SQL life_table 登録処理実行
  $sql = 'INSERT INTO 
  life_table(id,img,depth,log_id,user_id,fish_id,created_at,updated_at)
  VALUES(NULL,:img,:depth,:log_id,:user_id,:fish_id,now(),now())';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':img', $img, PDO::PARAM_STR);
  $stmt->bindValue(':depth', $depth, PDO::PARAM_STR);
  $stmt->bindValue(':log_id', $log_id, PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':fish_id', $fish_id, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

} else { //もし登録がない場合はfish_tableに登録

  //SQL fish_table 登録処理実行 → life_table 登録処理実行
  $sql = 'INSERT INTO 
  fish_table (id,name,infomation,user_id,created_at,updated_at) 
  VALUE (NULL,:fishname,"",:user_id,now(),now());
  INSERT INTO 
  life_table(id,img,depth,log_id,user_id,fish_id,created_at,updated_at) 
  VALUES(NULL,:img,:depth,:log_id,:user_id,LAST_INSERT_ID(),now(),now())';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':fishname', $fishname, PDO::PARAM_STR);
  $stmt->bindValue(':img', $img, PDO::PARAM_STR);
  $stmt->bindValue(':depth', $depth, PDO::PARAM_STR);
  $stmt->bindValue(':log_id', $log_id, PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

}//条件分岐ここまで


//処理が終わったらlife_input.phpへ移動
header("Location:life_input.php");
exit();


?>