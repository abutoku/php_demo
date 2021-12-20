<?php
//--------------------魚のテーブルに登録フォーム---------------------------//

// セッションの開始
session_start();
//関数読み込み
include('functions.php');
//セッション状態の確認の関数
check_session_id();


$log_id = $_SESSION['log_id'];

//セッションから変数に代入
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$imgUrl = $_SESSION['profile_image'];

// var_dump($date_id);
// exit();

//タイトル表示のための変数
$title = "fishdata input page";


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fish Input</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">

  <!-- font-awesome読み込み -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>

<body>

  <!-- ヘッダー読み込み -->
  <?php include('header.php'); ?>

  <div id="wrapper">

    <a href="main.php">登録しない</a>

    <section id="life_input_section">

      <form action="life_create.php" method="post" id=life_input_coutents enctype="multipart/form-data">
        <!-- 魚の名前 -->
        <div>
          <p>name</p>
          <input type="text" name="fishname" id="fish_name" required>
        </div>

        <!-- 水深を選択 -->
        <div>
          <p>水深</p>
          <input type="number" name="depth" min="0" max="40" value="10" required>
        </div>

        <!-- 画像を選択 -->
        <div id="select_img">
          <input type="file" id="life_pic" name="upfile" accept="image/*">
          <img src="./img/no_image.png" alt="アップロード画像" id="demo_pic">
        </div>

        <div>
          <!-- ログのIDを取得しておく部分 -->
          <input type="hidden" name="log_id" value=<?= htmlspecialchars($log_id, ENT_QUOTES) ?>>
        </div>

        <!-- 登録ボタン -->
        <button type="submit" id="life_input_btn">登録</button>
      </form>

      <div id="canvas_contents">
        <!-- canvas入力画面 -->
        色選択<input type="color" id="color">
        ペンの太さ<input type="range" id="line" min="1" max="50" value="5" step="1">
        <button id="clear_btn">クリア</button>
        <canvas id="canvas" width="480" height="360" style="border:1px solid #000;"></canvas>
      </div><!-- canvas入力画面ここまで -->

    </section><!-- input_sectionここまで -->


  </div><!-- wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- main.js読み込み -->
  <script src="./js/main.js"></script>

  <script>
    //canvasについての記述

    let canvas_mouse_event = false; //スイッチ[ true=線を引く、false=線は引かない]
    let oldX = 0; //一つ前の座標を代入するための変数
    let oldY = 0; //一つ前の座標を代入するための変数
    let bold_line = 5; //ラインの太さをここで指定
    let color = "#000"; //ラインの太さをここで指定

    const can = $('#canvas')[0]; //キャンバスそのものを変数
    const ctx = can.getContext("2d"); //canに対してgetContext関数を実行し書き込み権限を与える

    $(can).on("mousedown", function(e) {
      console.log('on');
      oldX = e.offsetX;
      oldY = e.offsetY;
      canvas_mouse_event = true;
    });


    $(can).on("mousemove", function(e) {

      if (canvas_mouse_event === true) {

        const px = e.offsetX; //時点の座標
        const py = e.offsetY; //時点の座標
        ctx.strokeStyle = color; //色
        ctx.lineWidth = bold_line; //大きさ
        ctx.lineJoin = "round";
        ctx.lineCap = "round"; //ペン先を丸く
        ctx.beginPath(); //パスの開始
        ctx.moveTo(oldX, oldY);
        ctx.lineTo(px, py);
        ctx.stroke(); //出発地点から現時点の線を描写
        oldX = px; //出発地点の入れ替え
        oldY = py; //出発地点の入れ替え
      }
    });

    $(can).on("mouseup", function(e) {
      canvas_mouse_event = false; //ボタンを上げたら
    });

    $(can).mouseleave(function() {
      canvas_mouse_event = false;
    });

    $('#clear_btn').on("click", function() {
      ctx.closePath();
      ctx.clearRect(0, 0, can.width, can.height); //canvasをクリア
    })


    //パスの開始
    ctx.beginPath();

    //色変更
    $('#color').on('change', function() {
      let sel_color = $('#color').val();
      console.log(sel_color);
      color = sel_color;
    })

    //ラインを変更
    $('#line').on('change', function() {
      let line = $('#line').val();
      console.log(line);
      console.log('change');
      bold_line = line;
    })

    //画像を送信
    $('#image_send').on('click', function() {
      console.log('click');
      const img_data = canvas.toDataURL("image/jpg");

      const data = { //データ送信用の変数
        name: "",
        text: "",
        img: img_data, //name欄に入力されたもの                
        time: serverTimestamp(), //現在時間
      };
      addDoc(collection(db, "chat"), data); //Firebaseのchatコレクションにデータを送る
      ctx.closePath();
      ctx.clearRect(0, 0, can.width, can.height);
    });

    //ダブルクリックで◯をつける
    $(can).on("dblclick", function(e) {
      console.log('click');

      pointX = e.offsetX; //位置の横軸を変数に代入
      pointY = e.offsetY; //位置の縦軸を変数に代入

      ctx.beginPath(); //パスの開始
      ctx.fillStyle = "#ff0000"; //色指定
      //Rect(座標、半径、円のスタート度、エンド度（描画）、回転)
      ctx.arc(pointX, pointY, 5, 0, Math.PI * 2, false);
      ctx.stroke(); //実際に書く関数(枠線)
      ctx.fill(); //塗りつぶし
    });
  </script>

</body>

</html>