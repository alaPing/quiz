<!DOCTYPE>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>QUIZ</title>
</head>
<body>
  <?php
    session_start();
    require_once 'class/quiz.class.php';
    $q = Quiz::loadQuizObject();
  ?>
  <section>
    第<?php echo $q->step;?>問結果<br />
    <?php $q->isCorrect($q->step, $_POST);?>
  </section>
  <section>
    <h1>結果発表</h1>
  </section>
  <section>
  あなたの得点は、<?php $point = $q->getScore(); echo $point;?>点です！<br />
  <?php
  if ($point == 100) {
    echo '大変よくできました';
  } else if ($point > 70) {
    echo 'もう少し頑張りましょう';
  } else if ($point > 25) {
    echo '精進せよ';
  } else {
    echo '適当に選んでもこれより点数とれますよ？';
  }
  ?>
  </section>
  <section>
    <table border="1">
      <tr>
        <th></th>
        <th>問題文</th>
        <th>あなたの解答</th>
        <th>正誤</th>
        <th>正しい答え</th>
      </tr>
      <?php for ($i = 0; $i < $q->num; $i++) :?>
      <tr>
        <th>第<?php echo $q->result[$i][0];?>問</th>
        <th><?php echo $q->quizdata[$i][1];?></th>
        <th><?php echo $q->result[$i][1];?></th>
        <th><?php echo $q->result[$i][2];?></th>
        <th><?php echo $q->result[$i][3];?></th>
      </tr>
      <?php endfor;?>
      </table>
  </section>
  <section>
    <a href="index.php">TOPへ戻る</a>
    <a href="quiz.php?category_id=<?php
      echo $q->CID;
      if (isset($q->LID)) {
        echo "&level_id=".$q->LID;
      }
    ?>">もう一度チャレンジする</a>
  </section>
</body>
</html>