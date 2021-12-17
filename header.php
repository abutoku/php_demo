<!-- ヘッダー部分 -->
<header>

  <!-- ヘッダー左側 -->
  <div id="header_left">
    <h1><?= htmlspecialchars($title, ENT_QUOTES) ?></h1>
  </div>

  <!-- ヘッダー右側 -->
  <div id="header_right">
    <img src=<?= htmlspecialchars($image["profile_image"],ENT_QUOTES) ?> id="profile_image">
    <div id="user_name"><?= htmlspecialchars($_SESSION['username'],ENT_QUOTES)?></div>
    <a href="logout.php" id="logout_btn" class="btn">logout</a>
    <a href="profile_input.php">プロフィール画像を登録</a>
  </div>

</header>