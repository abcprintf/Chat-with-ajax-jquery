<?php
  Class Auth {

    public function getIP () {
       foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
        {
            if (array_key_exists($key, $_SERVER) === true)
            {
                foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
                {
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                    {
                        return $ip;
                    }
                }
            }
        }
    }

    public function create_member ($name,$session_id,$pdo) {
      $ip = self::getIP();
      $long = ip2long($ip);
      try {
        $sql = "INSERT INTO
        `abcprint_demo`.`member` (
          `member_name`,
          `date_time`,
          `session_id`,
          `ip`
        ) VALUES (?, CURRENT_TIMESTAMP, ?, ?);";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$session_id,$long));
        $lastid = $pdo->lastInsertId();
        return $lastid;
      } catch (Exception $e) {
        return $e->getMessage();
      }
    }

    public function find_member ($session_id,$pdo) {

      $sql = "SELECT * FROM `member` WHERE `session_id` = ?;";
      $q = $pdo->prepare($sql);
      $q->execute(array($session_id));
      $data_array = $q->fetch(PDO::FETCH_ASSOC);

      if($data_array){
        return $data_array;
      }else{
        return 0;
      }
    }
  }

Class Chat{

  public function show_chat ($member_id,$pdo) {

    $sql = "SELECT
    `chat`.`chat_id`,
    `chat`.`message`,
    `chat`.`date_time`,
    `member`.`member_id`,
    `member`.`member_name`

    FROM `chat`

    LEFT JOIN `member`
    	ON (`chat`.`member_id` = `member`.`member_id`)

    WHERE DATE_FORMAT(`chat`.`date_time`, '%e%c%Y') = DATE_FORMAT(NOW(), '%e%c%Y') 

    ORDER BY `chat`.`chat_id` ASC";
    $q = $pdo->prepare($sql);
    $q->execute(array());
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {

      if($row['member_id'] == $member_id){
        $fixed = 'right';
        $pull = 'pull-right';
        $img = "http://placehold.it/50/FA6F57/fff&text=ME";
      }else{
        $fixed = 'left';
        $pull = 'pull-left';
        $img = "http://placehold.it/50/55C1E7/fff&text=U";
      }
      echo '<li id="chat-s" class="'.$fixed.' clearfix"><span class="chat-img pull-'.$fixed.'">';
      echo '<img src="'.$img.'" class="img-circle" />';
      echo '</span>';
      echo '<div class="chat-body clearfix">';
      echo '<div class="header">';
      echo '<strong class="'.$pull.' primary-font">'.$row['member_name'].'</strong>';
      echo '<small class="'.$pull.' text-muted time-pad"><span class="glyphicon glyphicon-time"></span>'.$row['date_time'].'</small>';
      echo '<br>';
      echo '</div>';
      echo '<p class="'.$pull.'">';
      echo $row['message'];
      echo '</p>';
      echo '</div>';
      echo '</li>';
    }
  }

  public function save_chat ($chat,$member_id,$pdo) {

    $sql = "INSERT INTO `abcprint_demo`.`chat` (`message`, `member_id`, `date_time`) VALUES (?, ?, CURRENT_TIMESTAMP);";
    $q = $pdo->prepare($sql);
    $q->execute(array($chat,$member_id));
  }
}
 ?>
