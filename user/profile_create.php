<?php

// セッションの開始
session_start();
//関数読み込み
include('../functions.php');
//セッション状態の確認の関数
check_session_id();

// var_dump($_POST);
// exit();

$username = $_POST['username'];
$card_rank = $_POST['card_rank'];
$dive_count = $_POST['dive_count'];
$user_id = $_SESSION['user_id'];



?>