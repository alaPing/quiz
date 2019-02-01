<!DOCTYPE>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>QUIZ</title>
</head>
<body>
  <?php
    session_start();
    require_once 'class/connect.class.php';
    require_once 'class/user.class.php';

    $u = User::loadUserObject();

    //ログイン・ログアウトボタンの制御
    if (isset($_POST['login'])) {
      $u->userLogin($_POST['user'], $_POST['password']);
    } else if (isset($_POST['logout'])) {
      $u->userLogout();
    }

    //ログイン中なら表示する
    if ($u->status == 'on') {
      echo 'こんにちは、'. $u->user . 'さん！';
    }
  ?>
  <section>
    <h1>自社・商品・業界知識クイズ</h1>
  </section>
  <section>
    <h1>自社知識クイズ</h1>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='1' name='category_id' />
      <input type='hidden' value='1' name='level_id' />
      <input type='submit' value='普通' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='1' name='category_id' />
      <input type='hidden' value='2' name='level_id' />
      <input type='submit' value='難しい' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='1' name='category_id' />
      <input type='submit' value='ランダム' />
    </form>
  </section>
  <section>
    <h1>商品知識クイズ</h1>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='2' name='category_id' />
      <input type='hidden' value='1' name='level_id' />
      <input type='submit' value='普通' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='2' name='category_id' />
      <input type='hidden' value='2' name='level_id' />
      <input type='submit' value='難しい' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='2' name='category_id' />
      <input type='submit' value='ランダム' />
    </form>
  </section>
  <section>
    <h1>業界知識クイズ</h1>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='3' name='category_id' />
      <input type='hidden' value='1' name='level_id' />
      <input type='submit' value='普通' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='3' name='category_id' />
      <input type='hidden' value='2' name='level_id' />
      <input type='submit' value='難しい' />
    </form>
    <form action='quiz.php' method='GET'>
      <input type='hidden' value='3' name='category_id' />
      <input type='submit' value='ランダム' />
    </form>
  </section>
  <section>
  <?php if ($u->status == 'on') :?>
    <a href='add.php'>クイズ追加</a><br />
    <a href='edit.php'>クイズ編集</a>
    <form action='index.php' method='POST'>
      <input type='submit' name='logout' value='ログアウト' />
    </form>
  <?php else :?>
    <form action='index.php' method='POST'>
      編集者用<br />
      ユーザー名：<input type='text' name='user' required/><br />
      パスワード：<input type='password' name='password' required/>
      <input type='submit' name='login' value='ログイン' />
    </form>
  <?php endif;?>
  </section>
  <?php $u->saveUserObject();?>
</body>
</html>
