<?php

// var_dump($_FILES);
// exit();

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

//セッションからユーザーIDを取得
$user_id = $_SESSION['user_id'];

// データの確認 正しくデータが送信されていれば，ファイル自体は tmp 領域に保存された状態
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  //送信が正常に行われたときの処理
  //情報の取得
  $uploaded_file_name = $_FILES['upfile']['name'];//ファイル名を取得
  $temp_path  = $_FILES['upfile']['tmp_name']; //一時保存されている場所を取得
  $directory_path = 'profile_img/'; //指定の保存場所
  // ファイル名の準備
  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);//ファイルの拡張子の種類を取得
  $unique_name = date('YmdHis') . md5(session_id()) . '.' . $extension;//ユニークな名前を作成し，末尾に拡張子を追加
  $save_path = $directory_path . $unique_name;//指定の保存場所を追加し，保存用のパスを作成

  // tmp 領域から指定の保存場所へファイルを移動
  if (is_uploaded_file($temp_path)) {//tmp 領域にファイルが存在しているかどうか．
    if (move_uploaded_file($temp_path, $save_path)) {//ファイルの移動
      chmod($save_path, 0644);//権限の変更
    } else {//ファイルの移動ができていない場合
      exit('Error:アップロードできませんでした');//エラーを返す
    }
  } else { //tmp 領域にファイルが存在していない場合
    exit('Error:画像がありません');//エラーを返す
  }
} else { //送信が正常に行われていない場合
  exit('Error:画像が送信されていません');//エラーを返す
}
//upload完了

//DB接続
$pdo = connect_to_db();

//処理が終わった後のページ移動
header("Location:profile_view.php");
exit();

?>