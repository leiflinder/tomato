<?php
class goal_create extends conn {

    // helper
    private function get_latest_goal_from_catid($catid){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`categoryid` LIKE :CATID ORDER BY (`goals`.`timestamp`) DESC LIMIT 1");
        $sth->bindParam(':CATID',$catid);
        $sth->execute();
        $value = $sth->fetch(PDO::FETCH_ASSOC);
        return ($value['hours']);
      }

    //helper
    public function get_catid_by_catname($catname){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`category` LIKE :CATNAME");
        $sth->bindParam(':CATNAME',$catname);
        $sth->execute();
        $value = $sth->fetch(PDO::FETCH_ASSOC);
        return ($value['id']);
      }

    public function create_goal($goal, $catname, $userid, $active=1, $timeperiod="week"){
        // use helper function to get cat id by cat name
        $catid = $this->get_catid_by_catname($catname);
        // determine if this is this new goal
        // get current weekly goal value
        $current_weekly_goal = $this->get_latest_goal_from_catid($catid);
        // if the current weekly goal is different, than update
        if($current_weekly_goal !== $goal ){
                $sth = $this->conn->prepare("INSERT INTO `tomato220`.`goals` (`goals`.`id`, `goals`.`userid`, `goals`.`categoryid`, `goals`.`catname`, `goals`.`hours`, `goals`.`active`, `goals`.`timeperiod`, `goals`.`timestamp`) VALUES (NULL, :USERID, :CATID, :CATNAME, :GOAL, :ACTIVE, :TIMEPERIOD, CURRENT_TIMESTAMP)");
                $sth->bindParam(':GOAL',$goal);
                $sth->bindParam(':CATID',$catid);
                $sth->bindParam(':CATNAME',$catname);
                $sth->bindParam(':USERID',$userid);
                $sth->bindParam(':ACTIVE',$active);
                $sth->bindParam(':TIMEPERIOD',$timeperiod);
                $sth->execute();
            }
        }

        public function delete_and_then_create($goal, $catname, $userid, $active=1, $timeperiod="week"){
          $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`catname` LIKE :CATNAME AND `goals`.`userid` LIKE :USERID");
          $sth->bindParam(':CATNAME',$catname);
          $sth->bindParam(':USERID',$userid);
          $sth->execute();
          $value = $sth->fetch(PDO::FETCH_ASSOC);
          if($value){
            $this->delete_on_catname($catname);
            print('<p>'.$catname.' Deleted</p>');
          }else{
            print('<p>Create</p>');
        }
      }

      public function delete_on_catname($catname){
        $sth = $this->conn->prepare("DELETE FROM `tomato220`.`goals` WHERE `goals`.`catname` LIKE :CATNAME");
        $sth->bindParam(':CATNAME',$catname);
        $sth->execute();
    }
   public function create_from_new($goal, $catname, $userid, $active=1, $timeperiod="week"){
    $sth = $this->conn->prepare("INSERT INTO `goals` (`id`, `userid`, `categoryid`, `catname`, `hours`, `active`, `timeperiod`, `timestamp`) VALUES (NULL, :USERID, :CATID, :CATNAME, :GOAL, '1', 'week', CURRENT_TIMESTAMP");
    $sth->bindParam(':GOAL',$goal);
    $sth->bindParam(':CATID',$catid);
    $sth->bindParam(':CATNAME',$catname);
    $sth->bindParam(':USERID',$userid);
    $sth->bindParam(':ACTIVE',$active);
    $sth->bindParam(':TIMEPERIOD',$timeperiod);
    $sth->execute();
   }
}

?>