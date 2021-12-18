<?php
//-----------------ログアウト処理-----------------------------------------------//

//ログアウトの処理は前項のセッション終了のコードそのもの

// セッションの開始
session_start();

// session情報の全削除
$_SESSION = array();

// ブラウザに保存した情報の有効期限を操作
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}

// session領域自体をを破壊
session_destroy();
//ログイン画面へ
header('Location:login.php');
exit();

