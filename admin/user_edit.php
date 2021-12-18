<?php

//---------------ユーザー編集画面----------------------------------------//

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
$sql = 'SELECT * FROM users_table WHERE id=:id';
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


//取得したデータを確認

// echo '<pre>';
// var_dump($record);
// echo '</pre>';
// exit();


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー管理（編集）</title>
</head>

<body>
  <form action="user_update.php" method="POST">
    <fieldset>
      <legend>ユーザー管理（編集）</legend>
      <a href="user_list.php">一覧画面</a>
      
      <div>
        <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
        name: <input type="text" name="username" value="<?= $record['username'] ?>">
      </div>
      <div>
        <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
        password: <input type="password" name="password" value="<?= $record['password'] ?>">
      </div>
      <!-- postでidを送るために下記inputも作る、編集ができないようにtype="hidden" -->
      <!-- 次の更新処理でidが必要になるため，<input type="hidden">を用いてidを送信する． -->
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>