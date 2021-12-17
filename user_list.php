<?php

//----------------登録ユーザー一覧-----------------------------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//SQL実行
//今回は「ユーザが入力したデータ」を使用しないのでバインド変数は不要．
$sql = 'SELECT * FROM users_table WHERE is_deleted = 0 ORDER BY created_at ASC';
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//繰り返し処理を用いて，取得したデータから HTML タグを生成する
$output = ""; //表示のための変数
foreach ($result as $record) {
  $output .= "
    <tr>
    <td>{$record["username"]}</td>
    <td>{$record["password"]}</td>
    <td>
        <a href=user_edit.php?id={$record["id"]}>edit</a>
      </td>
      <td>
        <a href=user_delete.php?id={$record["id"]}>delete</a>
      </td>
    </tr>
    ";
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザーリスト（管理画面）</title>
</head>

<body>
  <fieldset>
    <legend>ユーザーリスト（管理画面）</legend>
    <a href="user_input.php">ユーザー登録画面</a>
    <a href="main.php">TOP</a>
    <table>
      <thead>
        <tr>
          <th>username</th>
          <th>password</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>username</td><td>password</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>