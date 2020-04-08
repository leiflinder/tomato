<?php
class goal_create extends conn {

  public $goal=0;
  public $catname;
  public $userid;
  public $active=1;
  public $timeperiod="week";

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
          // push properties upstairs
          $this->goal = $goal;
          $this->catname = $catname;
          $this->userid = $userid;
          $this->active = $active;
          $this->timeperiod = $timeperiod;
          $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`catname` LIKE :CATNAME AND `goals`.`userid` LIKE :USERID");
          $sth->bindParam(':CATNAME',$catname);
          $sth->bindParam(':USERID',$userid);
          $sth->execute();
          $value = $sth->fetch(PDO::FETCH_ASSOC);
          if($value){
            // if this goal exists, then delete
            $this->delete_on_catname($catname);
            print('<p>'.$catname.' Deleted</p>');
            // now create from new
            $this->create_from_new($goal, $catname, $userid);
          }else{
            print('<p>Create</p>');
            $this->create_from_new($goal, $catname, $userid);
        }
      }

      public function delete_on_catname($catname){
        $sth = $this->conn->prepare("DELETE FROM `tomato220`.`goals` WHERE `goals`.`catname` LIKE :CATNAME");
        $sth->bindParam(':CATNAME',$catname);
        $sth->execute();
    }
   public function create_from_new($goal=0, $catname, $userid, $active=1, $timeperiod="week"){
    $this->catid = $this->get_catid_by_catname($catname);
    $sth = $this->conn->prepare("INSERT INTO `tomato220`.`goals` (`goals`.`userid`, `goals`.`categoryid`, `goals`.`catname`, `goals`.`hours`) VALUES (:USERID, :CATID, :CATNAME, :GOAL)");
    $sth->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
    $sth->bindParam(':CATID', $this->catid, PDO::PARAM_INT);
    $sth->bindParam(':CATNAME', $this->catname, PDO::PARAM_STR);
    $sth->bindParam(':GOAL', $this->goal, PDO::PARAM_INT);
    $sth->execute();
   }
}

?>