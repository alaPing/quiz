<?php

class QuizDatabase {

  //DBへの接続を確立する
  public static function getDb() {
    $dsn = 'mysql:dbname=QUIZ; host=127.0.0.1';
    $usr = 'quizusr';
    $passwd = 'quizpass';

    try {
      //データベースへの接続を確立する
      $db = new PDO($dsn, $usr,$passwd);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //データベース接続時に使用する文字コードを設定する
      $db->exec('SET NAMES utf8');
    } catch (PDOException $e) {
      die("ERROR:{$e->getMessage()}");
    }
    return $db;
  }
}