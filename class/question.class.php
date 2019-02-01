<?php

class Question {

  //問題を登録する
  public function registerQuestion($category_id, $level_id, $question, $correct, $wrong1, $wrong2, $wrong3) {
    try {
      $now = new Datetime();
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('INSERT INTO quiz(category_id, level_id, question, correct, wrong1, wrong2, wrong3, created_at, updated_at)
        VALUES(:category_id, :level_id, :question, :correct, :wrong1, :wrong2, :wrong3, :created_at, :updated_at)');
      $stt->bindValue(':category_id', $category_id);
      $stt->bindValue(':level_id', $level_id);
      $stt->bindValue(':question', $question);
      $stt->bindValue(':correct', $correct);
      $stt->bindValue(':wrong1', $wrong1);
      $stt->bindValue(':wrong2', $wrong2);
      $stt->bindValue(':wrong3', $wrong3);
      $stt->bindValue(':created_at', $now->format('Y-m-d H:i:s'));
      $stt->bindValue(':updated_at', $now->format('Y-m-d H:i:s'));
      $stt->execute();
      $db = NULL;
    } catch (PDOException $e) {
      die("ERROR!!:{$e->getMessage()}");
    }
  }

  //問題の一覧を取得する
  public function getQuestionList($category_id, $level_id) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('SELECT * FROM quiz WHERE category_id = :category_id AND level_id = :level_id');
      $stt->bindValue(':category_id', $category_id);
      $stt->bindValue(':level_id', $level_id);
      $stt->execute();
      while ($temp = $stt->fetch(PDO::FETCH_ASSOC)) {
        $row[] = $temp;
      }
      $db = NULL;
    } catch (PDOException $e) {
      die("ERROR!!:{$e->getMessage()}");
    }
    return $row;
  }

  //問題を取得する
  public function getQuestion($id) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('SELECT * FROM quiz WHERE id = :id');
      $stt->bindValue(':id', $id);
      $stt->execute();
      $row = $stt->fetch(PDO::FETCH_ASSOC);
      $db = NULL;
    } catch (PDOException $e) {
      die("ERROR!!:{$e->getMessage()}");
    }
    return $row;
  }

  //問題を削除する
  public function deleteQuestion($id) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('DELETE FROM quiz WHERE id = :id');
      $stt->bindValue(':id', $id);
      $stt->execute();
      $db = NULL;
    } catch(PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }

  //問題を更新する
  public function updateQuestion($id, $category_id, $level_id, $question, $correct, $wrong1, $wrong2, $wrong3) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('UPDATE quiz SET category_id = :category_id, level_id = :level_id, question = :question, correct = :correct, wrong1 = :wrong1, wrong2 = :wrong2, wrong3 = :wrong3 WHERE id = :id');
      $stt->bindValue(':id', $id);
      $stt->bindValue(':category_id', $category_id);
      $stt->bindValue(':level_id', $level_id);
      $stt->bindValue(':question', $question);
      $stt->bindValue(':correct', $correct);
      $stt->bindValue(':wrong1', $wrong1);
      $stt->bindValue(':wrong2', $wrong2);
      $stt->bindValue(':wrong3', $wrong3);
      $stt->execute();
      $db = NULL;
    } catch(PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }
}
