<?php
//---ログインできるか確認--------------------//

// データ受け取り
// var_dump($_POST);
// exit();

// セッションの開始
session_start();
include('../functions.php');

// データを変数に代入
$email = $_POST['email'];
$password = $_POST['password'];

// DB接続
$pdo = connect_to_db();

// SQL実行
// email,password,is_deletedの3項目全てを満たすデータを抽出する

//一致するemailがDBにあるかどうかチェック
$sql = 'SELECT * FROM users_table WHERE email=:email AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//emailが一致するユーザー情報を$valに代入
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザ有無で条件分岐
if (!$val) { //もしユーザーがいなければ
  echo "<p>ログイン情報に誤りがあります</p>"; //エラー表示
  echo "<a href=login.php>ログイン</a>"; //ログイン画面へのリンク
  exit();

} else { //一致するユーザーがいた場合
  //パスワードチェック
  if (password_verify($_POST['password'], $val['password'])) {

    //一致するユーザーが見つかった場合、セッション変数にログイン情報を保持してmain.phpに移動
    $_SESSION = array(); //セッションを一旦リセット
    $_SESSION['session_id'] = session_id(); //セッションIDを取得
    $_SESSION['is_admin'] = $val['is_admin']; //管理者ユーザと一般ユーザの識別に使用
    $_SESSION['user_id'] = $val['id']; //管理者ユーザと一般ユーザの識別に使用

    //管理者の確認
    if ($_SESSION['is_admin'] == '1') {
      header("Location:../admin.main.php");  //管理者であれば、adimin.main.phpへ
      exit();
    } else {
      header("Location:../main.php"); //一般ユーザーであればmain.phpへ
      exit();
    }
  } else {
    echo "<p>ログイン情報に誤りがあります</p>"; //エラー表示
    echo "<a href=login.php>ログイン</a>"; //ログイン画面へのリンク
    exit();
  }
}