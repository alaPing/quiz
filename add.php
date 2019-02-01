<!DOCTYPE>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>QUIZ</title>
</head>
<body>
  <?php
    session_start();
    require_once 'class/user.class.php';
    require_once 'class/connect.class.php';
    require_once 'class/question.class.php';
    $q = new Question();

    $u = User::loadUserObject();

    //ログイン状態のチェック
    if ($u->status == "off") {
      echo "不正なアクセスです。";die;
    } else if ($u->status == "on") {
      echo "こんにちは、". $u->user . "さん！";
    }

    if(!empty($_POST['id'])) {
      //クイズの更新（POSTにidがセットされている場合）
      $q->updateQuestion($_POST['id'], $_POST['category_id'], $_POST['level_id'], $_POST['question'], $_POST['correct'], $_POST['wrong1'], $_POST['wrong2'], $_POST['wrong3']);
      $row = NULL;
      echo "更新しました。";
    } else if(!empty($_POST['category_id'])) {
      //クイズの追加（TOPから遷移してきた場合）
      $q->registerQuestion($_POST['category_id'], $_POST['level_id'], $_POST['question'], $_POST['correct'], $_POST['wrong1'], $_POST['wrong2'], $_POST['wrong3']);
      $row = NULL;
      echo "登録しました。";
    } else if (isset($_GET['id'])) {
      //クイズ編集画面から遷移してきたときのクイズIDに紐づいたデータの取得
      $row = $q->getQuestion($_GET['id']);
    } else {
      $row = NULL;
    }
  ?>
  <section>
    <h1>クイズ追加</h1>
  </section>
  <section>
    <a href="index.php">TOP</a>
  </section>
  <section>
    <form action="add.php" method="POST" name="Form">
      <input type="hidden" name="id" value="<?php echo $row['id'];?>">
      <p>
        カテゴリ<select name="category_id">
          <option value="1" <?php if($row['category_id'] == 1 || NULL) {echo "selected";}?>>自社</option>
          <option value="2" <?php if($row['category_id'] == 2) {echo "selected";}?>>商品</option>
          <option value="3" <?php if($row['category_id'] == 3) {echo "selected";}?>>業界</option>
        </select>
        難易度<select name="level_id">
          <option value="1" <?php if($row['level_id'] == 1 || NULL) {echo "selected";}?>>普通</option>
          <option value="2" <?php if($row['level_id'] == 2) {echo "selected";}?>>難しい</option>
        </select>
      </p>
      <p>
        問題文<textarea name="question" rows="5" cols="50" maxlength="200" required><?php echo $row['question'];?></textarea>
      </p>
      <p>
        正答<textarea name="correct" rows="3" cols="50" maxlength="100" required><?php echo $row['correct'];?></textarea>
      </p>
      <p>
        誤答1<textarea name="wrong1" rows="3" cols="50" maxlength="100" required><?php echo $row['wrong1'];?></textarea>
      </p>
      <p>
        誤答2<textarea name="wrong2" rows="3" cols="50" maxlength="100" required><?php echo $row['wrong2'];?></textarea>
      </p>
      <p>
        誤答3<textarea name="wrong3" rows="3" cols="50" maxlength="100" required><?php echo $row['wrong3'];?></textarea>
      </p>
      <input type="submit" value="登録" /><br />
      <input type="reset" value="<?php if (isset($_GET['id'])) {echo "初期状態に戻す";} else {echo "クリア";}?>" />
    </form>
  </section>
</body>
</html>
