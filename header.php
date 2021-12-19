<!-- ハンバーガーメニューの内容 -->
<div id="menu_contents">

  <div id="my_acount">
    <img src=<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?> class="profile_img">
    <div id ="user_name"><?= htmlspecialchars($username, ENT_QUOTES) ?></div>
  </div>

  <div id="menu_list">
    <ul>
      <a href="./profile_view.php"><li>プロフィール</li></a>
      <li>お気に入り</li>
      <li>設定</li>
      <li>ヘルプ</li>
    </ul>
    <!-- ログアウトボタン -->
    <div id="logout_section">
      <a href="./user/logout.php">
        <div id="logout_btn">logout</div>
      </a>
    </div>

  </div>
</div>
<!-- menu_contentsここまで -->

<!-- ハンバーガーメニューの背景 -->
<div id="mask">
  <!-- クローズボタン -->
  <div class="fas fa-angle-double-right btn" id="close"></div>
</div>

<!-- ヘッダー部分 -->
<header>

  <!-- ヘッダー左側 -->
  <div id="header_left">
    <h1><?= htmlspecialchars($title, ENT_QUOTES) ?></h1>
  </div>

  <!-- ヘッダー右側 -->
  <div id="header_right">
    <div class="fas fa-bars btn" id="hamburger"></div>
  </div>

</header>