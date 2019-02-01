<?php

class User {

  public $user = 'guest';
  public $status = 'off';
  public $status2 = 'off';

  //ログイン制御
  public function userLogin($user, $password) {
    try {
      $db = QuizDatabase::getDb();
      $stt = $db->prepare('SELECT authority_id, user FROM user WHERE user = :user AND password = :password');
      $stt->bindValue(':user', $user);
      $stt->bindValue(':password', $password);
      $stt->execute();
      $row = $stt->fetch(PDO::FETCH_ASSOC);
      $authority_id = $row['authority_id'];
      $this->user = $row['user'];
      if (!empty($authority_id) && !empty($this->user)) {
        if ($authority_id == 1) {
          $this->status = 'on';
          $this->status2 = 'on';
        } else {
          $this->status = 'on';
          $this->status2 = 'off';
        }
      } else {
        $this->status = 'off';
        $this->status2 = 'off';
      }
      $db = NULL;
    } catch (PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }

  //ログアウト制御
  public function userLogout() {
    $this->user = '';
    $this->status = 'off';
    $this->status = 'off';
  }

  //ユーザオブジェクトをセッションに保存する
  public function saveUserObject() {
    $_SESSION['object_u'] = serialize($this);
  }

  //ユーザオブジェクトを読み込む
  public static function loadUserObject() {
    //オブジェクトの作成またはロード
    if (isset($_SESSION['object_u'])) {
      $u = unserialize($_SESSION['object_u']);
    } else {
      $u = new User();
    }
    return $u;
  }
}
