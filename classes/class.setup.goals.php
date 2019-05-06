<?PHP
class setupgoals extends conn{

  function ifActive($active){
    if($active==0){
     print("");
    }elseif($active==1){
      print('Select');
    }else{
      print(0);
    }

  }

  // helper function
  // What is happening? Use this function to help build multi dimensional array
  // make_goals_array() creates array that has categories and their 'latest' hours
  // Requires two queries first to get all categories and then to get their lastest
  // goal hours
   private function get_latest_goal_from_catid($catid){
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`categoryid` LIKE :CATID ORDER BY (`goals`.`timestamp`) DESC LIMIT 1");
    $sth->bindParam(':CATID',$catid);
    $sth->execute();
    $value = $sth->fetch(PDO::FETCH_ASSOC);
    return ($value['hours']);
  }

  function make_goals_array(){
    $sth = $this->conn->prepare("SELECT DISTINCT(`tomato220`.`goals`.`categoryid`),`tomato220`.`goals`.`catname` FROM `tomato220`.`goals`");
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
    $category_goals = array();
    for($i=0;$i<sizeof($value);$i++){
     // $category_goals[$value[$i]]=array($value[$i]['catname'], $value[$i]['categoryid']);
     $lastest_hours = $this->get_latest_goal_from_catid($value[$i]['categoryid']);
     $category_goals[]= array($value[$i]['categoryid'],$value[$i]['catname'],$lastest_hours);
    }
    // Now take the $category_goals array and print out as a form
    for($i=0;$i<sizeof($category_goals);$i++){
     // print('<pre>');
     // print_r($category_goals[$i]);
     // print('</pre>');
      print('<form method="post" action="refresh.goals.edit.php" id="update_goal">');
        print('<div class="form-group">');
          print('<label for="WeeklyGoal'.$category_goals[$i][1].'">'.$category_goals[$i][1].'</label>');
          print('<input type="text" class="form-control" id="WeeklyGoal'.$category_goals[$i][1].'" value="'.$category_goals[$i][2].'" name="hours">');
          print('<input type="hidden" value="'.$category_goals[$i][0].'" name="categoryid">');
          print('<input type="hidden" value="'.$category_goals[$i][1].'" name="categoryname">');
        print('</div>');
        print('<button type="submit" class="btn btn-primary">Submit</button>');
      print('</form>');
      print('<p>&nbsp;</p>');
      /*
      print('<p><input type="text" value="'.$category_goals[].'" name="category" value="'..'"/></p>');
      */
    }
    /*
      for($i=0;$i<sizeof($value);$i++){
        $q= $this->conn->query("SELECT `hours` FROM `goals` WHERE `catname` LIKE ".$value[$i]," ORDER BY (`timestamp`) DESC LIMIT 1");
        $hours = $q->fetchColumn();
        $category_goals[$value[$i]]=$hours;
      }
    */
      return $category_goals;
  }
/*
  function array_of_latest_goals(){
    $sth = $this->conn->prepare("SELECT DISTINCT(`tomato220`.`goals`.`catname`) FROM `tomato220`.`goals`");
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
    $category_goals = array();
    for($i=0;$i<sizeof($value);$i++){
      $q= $this->conn->query("SELECT `hours` FROM `goals` WHERE `catname` LIKE ".$value[$i]," ORDER BY (`timestamp`) DESC LIMIT 1");
      $hours = $q->fetchColumn();
      $category_goals[$value[$i]]=$hours;
    }
    return $category_goals;
  }
*/

    function form_set_weekly_goals(){
        print('<form action="refresh.goals.edit.php" method="post">');
        print('<div class="form-group">');
        print('<input type="hidden" value="updategoals" id="updategoals" name="updategoals"/>');
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        print('<form>');
        for($i=0; $i < sizeof($value); $i++){
          print('<p>Lexicon</p>');
/*
          print('<div class="form-group" id="weeklygoalsform">
          <label for="weeklyGoal">'.$value[$i]['catname'].'</label>
          <input type="hidden" name="catnames[]" value="'.$value[$i]['catname'].'"/>
          <input type="hidden" name="catids[]" value="'.$value[$i]['categoryid'].'"/>
          <input type="hidden" name="active[]" value="'.$value[$i]['active'].'"/>
            <input type="weeklyGoal" name="goals[]" value="'.$value[$i]['hours'].'" class="form-control" id="Goals" aria-describedby="Weekly Goal" placeholder="Weekly Gal">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="active">
            <label class="form-check-label" for="active">Active</label>
          </div><br/>');
    */
        }
        print('<button type="submit" class="btn btn-primary">Submit</button>');
        print('</form>');
        print('<p>&nbsp;<br/>&nbsp;<br/></p>');
    }

    public function show_goals($timeperiod){
        /*
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`weeklygoals` WHERE `weeklygoals`.`timeperiod` = :TIMEPERIOD");
        */

        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`timeperiod` = 'week' GROUP BY(`categoryid`)
        ");
        $sth->bindParam(':TIMEPERIOD',$timeperiod);
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        for($i=0;$i<sizeof($value);$i++){
            print('<p>'.$value[$i]['catname'].' '.$value[$i]['hours'].'</p>');
        }
    }

   function check_goal_if_changed($catid, $goal){
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals` WHERE `goals`.`categoryid` = :CATID AND `goals`.`hours` = :GOAL");
    $sth->bindParam(':GOAL',$goal);
    $sth->bindParam(':CATID',$catid);
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
        if(sizeof($value)>0){
        return 1;
        }else{
        return 0;
      }
   }

   function create_new_goal($catid, $goal, $catname, $userid, $active=1, $timeperiod="week"){
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

?>