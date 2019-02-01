<?php

class Quiz {

  //問題数をセットする
  public $num = 10;
  public $quizdata;
  private $statement;
  private $correct_choice;
  private $choices;
  private $set;
  public $result;
  public $CID;
  public $LID;
  public $step;

  //1セット($num)問のクイズをセットする
  public function getQuiz($category_id, $level_id) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('SELECT id, question, correct, wrong1, wrong2, wrong3 FROM quiz
        WHERE category_id = :category_id AND level_id = :level_id
        ORDER BY RAND() LIMIT :num');
      $stt->bindValue(':category_id', $category_id);
      $stt->bindValue(':level_id', $level_id);
      $stt->bindValue(':num', $this->num, PDO::PARAM_INT);
      $stt->execute();
      for ($i = 0; $i < $this->num; $i++) {
        $row = $stt->fetch(PDO::FETCH_ASSOC);
        $this->quizdata[] = array($row['id'], $row['question'], $row['correct'], $row['wrong1'], $row['wrong2'], $row['wrong3']);
      }
      $db = NULL;
    } catch (PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }

  //1セット($num)問の難易度不問クイズをセットする
  public function getQuizRandom($category_id) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('SELECT id, question, correct, wrong1, wrong2, wrong3 FROM quiz
        WHERE category_id = :category_id ORDER BY RAND() LIMIT :num');
      $stt->bindValue(':category_id', $category_id);
      $stt->bindValue(':num', $this->num, PDO::PARAM_INT);
      $stt->execute();
      for ($i = 0; $i < $this->num; $i++) {
        $row = $stt->fetch(PDO::FETCH_ASSOC);
        $this->quizdata[] = array($row['id'], $row['question'], $row['correct'], $row['wrong1'], $row['wrong2'], $row['wrong3']);
      }
      $db = NULL;
    } catch (PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }

  //セットしたクイズから1問取り出す
  public function toQuestion($step) {
    $this->statement = $this->quizdata["$step"][1];
    $this->correct_choice = $this->quizdata["$step"][2];
    $this->choices = array($this->quizdata["$step"][2], $this->quizdata["$step"][3], $this->quizdata["$step"][4], $this->quizdata["$step"][5]);

    shuffle($this->choices);
    $this->set = array($this->statement, $this->correct_choice, $this->choices);
    return $this->set;
  }

  //解答の正誤を判定し、結果配列を返す
  public function isCorrect($step, $answer) {
    $temp = array_values($answer);
    switch ($temp[0]) {
      case $this->correct_choice :
        echo "○";
        $this->result[] = array($step, $temp[0], '○', 'ー');
        break;
      default :
        echo "×";
        $this->result[] = array($step, $temp[0], '×', $this->correct_choice);
        break;
    }
  }

  //クイズの得点を返す
  public function getScore() {
    $temp = 0;
    foreach ($this->result as $value) {
      if ($value[2] == '○') {
        $temp++;
      }
    }
    $point = 100 * $temp / $this->num;
    return $point;
  }

  //クイズオブジェクトをセッションに保存する
  public function saveQuizObject() {
    $_SESSION['object_q'] = serialize($this);
  }

  //クイズオブジェクトを読み込む
  public static function loadQuizObject() {
    $q = unserialize($_SESSION['object_q']);
    return $q;
  }

  //クイズに関する情報をセーブする
  public function saveQuizStatus($CID, $LID) {
    $this->CID = $CID;
    $this->LID = $LID;
  }

  //クイズに関する情報を初期化する
  public function resetQuizStatus() {
    $this->step = 1;
    unset($this->CID);
    unset($this->LID);
  }

  //step管理
  public function stepPlus() {
    $this->step++;
  }
}
