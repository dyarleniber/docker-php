<?php
  class Message extends User{
    function __construct($pdo) {
      $this->pdo = $pdo;
    }
    //Added new query to get recent messages
    public function recentMessages($user_ID){
      $stmt = $this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN users ON `messageFrom` = `user_ID` AND `messageID` IN (SELECT max(`messageID`) FROM `messages` WHERE `messageFrom` = `user_ID`) WHERE `messageTo` = :user_ID and `messageFrom` = user_ID GROUP BY `user_ID` ORDER BY `messageID` DESC ");
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

     public function getMessages($messageFrom, $user_ID){
      $stmt = $this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom` = `user_ID` WHERE `messageFrom` =:messageFrom AND `messageTo` =:user_ID OR `messageTo` =:messageFrom AND `messageFrom` =:user_ID");
      $stmt->bindParam(":messageFrom", $messageFrom, PDO::PARAM_INT);
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
      $messages = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach ($messages as $message) {
        if ($message->messageFrom === $user_ID) {
          echo '<div class="main-msg-body-right">
              <div class="main-msg">
                <div class="msg-img">
                  <a href="#"><img src="'.BASE_URL.$message->profileImage.'"/></a>
                </div>
                <div class="msg">'.$message->message.'
                  <div class="msg-time">
                    '.$this->timeAgo($message->messageOn).'
                  </div>
                </div>
                <div class="msg-btn">
                  <a><i class="fa fa-ban" aria-hidden="true"></i></a>
                  <a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </div>
              </div>
            </div>';
        }else{
          echo '<div class="main-msg-body-left">
            <div class="main-msg-l">
              <div class="msg-img-l">
                <a href="#"><img src="'.BASE_URL.$message->profileImage.'"/></a>
              </div>
              <div class="msg-l">'.$message->message.'
                <div class="msg-time-l">
                    '.$this->timeAgo($message->messageOn).'
                </div>
              </div>
              <div class="msg-btn-l">
                <a><i class="fa fa-ban" aria-hidden="true"></i></a>
                <a class="deleteMsg" data-message="'.$message->messageID.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </div>
            </div>
          </div> ';
        }
      }
    }

    public function deleteMsg($messageID, $user_ID){
      $stmt = $this->pdo->prepare("DELETE FROM `messages` WHERE `messageID` =:messageID AND `messageFrom` =:user_ID OR `messageID` =:messageID AND `messageTo` =:user_ID");
      $stmt->bindParam(":messageID", $messageID, PDO::PARAM_INT);
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
    }


    public function getNotificationCount($user_ID){
      $stmt = $this->pdo->prepare("SELECT COUNT(`messageID`) AS `totalM`, (SELECT COUNT(`ID`) FROM `notification` WHERE `notificationFor` = :user_ID AND `status` = '0') AS `totalN` FROM `messages` WHERE `messageTo` = :user_ID AND `status` = '0'");
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function messagesViewed($user_ID){
      $stmt = $this->pdo->prepare("UPDATE `messages` SET `status` = '1' WHERE `messageTo` = :user_ID AND `status` = '0'");
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function notificationViewed($user_ID){
      $stmt = $this->pdo->prepare("UPDATE `notification` SET `status` = '1' WHERE `notificationFor` = :user_ID");
      $stmt->bindParam(":user_ID", $user_ID, PDO::PARAM_INT);
      $stmt->execute();
    }

    public function notification($user_ID){
      $stmt = $this->pdo->prepare("SELECT * FROM `notification` N LEFT JOIN `users` U ON N.`notificationFrom` = U.`user_ID` LEFT JOIN `posts` T ON N.`target` = T.`postID` LEFT JOIN `likes` L ON N.`target` = L.`likeOn` LEFT JOIN `follow` F ON N.`notificationFrom` = F.`sender` AND N.`notificationFor` = F.`receiver` WHERE N.`notificationFor` = :user_ID AND N.`notificationFrom` != :user_ID GROUP BY `ID` ");
      $stmt->execute(array("user_ID" => $user_ID));
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function sendNotification($get_id, $user_ID, $target, $type){
     $this->create('notification', array('notificationFor' => $get_id, 'notificationFrom' => $user_ID, 'target' => $target, 'type' => $type, 'time' => date('Y-m-d H:i:s')));
    }
  }

?>
