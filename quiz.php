<!DOCTYPE>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>QUIZ</title>
</head>
<body>
  <?php
    session_start();
    require_once 'class/connect.class.php';
    require_once 'class/quiz.class.php';

    if (isset($_GET['category_id']) and isset($_GET['level_id'])) {
      $q = new Quiz();
      $q->resetQuizStatus();
      $q->getQuiz($_GET['category_id'], $_GET['level_id']);
      $q->saveQuizStatus($_GET['category_id'], $_GET['level_id']);
    } else if (isset($_GET['category_id']) and empty($_GET['level_id'])) {
      $q = new Quiz();
      $q->resetQuizStatus();
      $q->getQuizRandom($_GET['category_id']);
      $q->saveQuizStatus($_GET['category_id'], '');
    } else {
      $q = Quiz::loadQuizObject();
      //ステップを1進める
      $q->stepPlus();
    }
  ?>
  <?php if ($q->step > 1) : ?>
  <section>
    第<?php echo $q->step - 1;?>問結果<br />
    <?php $q->isCorrect($q->step - 1, $_POST);?>
  </section>
  <?php endif;?>
  <section style="word-wrap: break-word; width: 600px;">
    ■第<?php echo $q->step;?>問<br />
    <?php
      //$q->step問目を取り出す
      $set = $q->toQuestion($q->step - 1);
      echo $set[0]; //set(問題文, 正解のテキスト, 選択肢配列)
    ?>
  </section>
  <section>
    <form action="<?php if ($q->step == $q->num) {echo "result.php";} else {echo "quiz.php";}?>" method="POST">
      A：<input type="submit" name="A" value="<?php echo $set[2][0];?>" /><br />
      B：<input type="submit" name="B" value="<?php echo $set[2][1];?>" /><br />
      C：<input type="submit" name="C" value="<?php echo $set[2][2];?>" /><br />
      D：<input type="submit" name="D" value="<?php echo $set[2][3];?>" />
    </form>
  </section>
  <?php $q->saveQuizObject();?>
</body>
</html>