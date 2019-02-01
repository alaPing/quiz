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

    if(!empty($_POST['category_id'])) {
      //カテゴリIDと難易度IDで絞り込んだリストを表示する
      $row = $q->getQuestionList($_POST['category_id'], $_POST['level_id']);
    } else if(!empty($_GET['delete'])) {
      //IDを指定して削除する
      $q->deleteQuestion($_GET['id']);
      echo "削除しました。";
    }
  ?>
  <section>
    <h1>クイズ編集</h1>
  </section>
  <section>
    <a href="index.php">TOP</a>
  </section>
  <section>
    <form action="edit.php" method="POST">
      <p>
        カテゴリ<select name="category_id">
          <option value="1" selected="selected">自社</option>
          <option value="2">商品</option>
          <option value="3">業界</option>
        </select>
        難易度<select name="level_id">
          <option value="1" selected="selected">普通</option>
          <option value="2">難しい</option>
        </select>
        <input type="submit" value="検索" />
      </p>
    </form>
    <?php
      if (isset($_POST['category_id'])) {
        switch ($_POST['category_id']) {
          case 1 :
            echo "カテゴリ：自社";
            break;
          case 2 :
            echo "カテゴリ：商品";
            break;
          case 3 :
            echo "カテゴリ：業界";
            break;
          case 4 : //将来加えたい
            echo "カテゴリ：IT";
            break;
          default :
            echo "";
            break;
        }
        switch ($_POST['level_id']) {
          case 1 :
            echo "　難易度：普通";
            break;
          case 2 :
            echo "　難易度：難しい";
            break;
          case 3 :
            echo "　難易度：非常に難しい";
            break;
          default :
            echo "";
            break;
        }
      }
    ?>
    <table border="1">
      <tr>
        <th></th>
        <th>クイズID</th>
        <th>問題文</th>
        <th>正答</th>
        <th>誤答1</th>
        <th>誤答2</th>
        <th>誤答3</th>
        <th></th>
      </tr>
      <?php
        if(empty($_POST['category_id'])) :
          $row = array();
        else :
          foreach ($row as $value) :
      ?>
      <tr>
        <td><form action="add.php" method="GET"><input type="submit" name="edit" value="編集"><input type="hidden" name="id" value="<?php echo $value['id']; ?>" /></form></td>
        <td><?php echo $value['id']; ?></td>
        <td><?php echo $value['question']; ?></td>
        <td><?php echo $value['correct']; ?></td>
        <td><?php echo $value['wrong1']; ?></td>
        <td><?php echo $value['wrong2']; ?></td>
        <td><?php echo $value['wrong3']; ?></td>
        <?php if ($u->status2 == "on") :?>
        <td><form action="edit.php" method="GET"><input type="submit" name="delete" value="削除"><input type="hidden" name="id" value="<?php echo $value['id']; ?>" /></form></td>
        <?php endif;?>
      </tr>
      <?php
          endforeach;
        endif;
      ?>
    </table>
  </section>
</body>
</html>
