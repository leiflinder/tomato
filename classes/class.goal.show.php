<?PHP
class setupgoals extends conn{

  var $category_goals2 = array();
  var $goals_total_hours=0;
  var $week_number_current = 0;
  var $goals_so_far_this_week = 0;
  var $toms_needed = 0;
  var $toms_needed_per_day = 0;

  function ifActive($active){
    if($active==0){
     print("");
    }elseif($active==1){
      print('Select');
    }else{
      print(0);
    }

  }

  function get_catid_by_catname($catname){
    $sth = $this->conn->prepare("SELECT `category`.`id` FROM `tomato220`.`category` WHERE `category`.`category` LIKE :CATNAME LIMIT 1");
    $sth->bindParam(':CATNAME',$catname);
    $sth->execute();
    $value = $sth->fetch(PDO::FETCH_ASSOC);
    return ($value['id']);
  }
  
  
 function check_hours_this_week_by_category($categryname){
    $week = date('Y')."-W".date('W');
    $catid = $this->get_catid_by_catname($categryname);
    $sth = $this->conn->prepare("SELECT sum(`tomato`.`count`) AS `hours` FROM `tomato220`.`tomato` WHERE `tomato`.`category` = :CATID AND `tomato`.`tomweek` LIKE :WEEK LIMIT 1");
    $sth->bindParam(':CATID',$catid);
    $sth->bindParam(':WEEK',$week);
    $sth->execute();
    $value = $sth->fetch(PDO::FETCH_ASSOC);
    $toms_in_hours= (.5)*$value['hours'];
    return ($toms_in_hours);
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
    $sth = $this->conn->prepare("SELECT DISTINCT(`tomato220`.`goals`.`categoryid`),`tomato220`.`goals`.`catname`, `tomato220`.`goals`.`active` FROM `tomato220`.`goals`");
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
    $category_goals = array();
    for($i=0;$i<sizeof($value);$i++){
     // $category_goals[$value[$i]]=array($value[$i]['catname'], $value[$i]['categoryid']);
     $lastest_hours = $this->get_latest_goal_from_catid($value[$i]['categoryid']);
     $category_goals[]= array($value[$i]['categoryid'],$value[$i]['catname'],$lastest_hours);
     $this->category_goals2[] = $category_goals;
    }
    
    // Now take the $category_goals array and print out as a form
    for($i=0;$i<sizeof($category_goals);$i++){
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

    }
      return $category_goals;
  }


  // helper function
  private function array_of_latest_goals(){
    $sth = $this->conn->prepare("SELECT DISTINCT(`tomato220`.`goals`.`catname`) FROM `tomato220`.`goals` ORDER BY(`catname`) ASC");
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
    $category_goals = array();
    for($i=0;$i<sizeof($value);$i++){
      $q = $this->conn->query('SELECT `tomato220`.`goals`.`hours` FROM `tomato220`.`goals` WHERE `goals`.`catname` LIKE "'.$value[$i]['catname'].'" ORDER BY (`timestamp`) DESC LIMIT 1');
      $hours = $q->fetchColumn();
      $category_goals[$value[$i]['catname']]=$hours;
    }
    return $category_goals;
  }


  public function show_goals(){
  $weekly_goals = $this->array_of_latest_goals();
 // for($i=0;$i<(sizeof($weekly_goals));$i++){
   print('<table class="table2">');
   foreach($weekly_goals AS $index => $value){
    $thisweek = $this->check_hours_this_week_by_category($index);
    // change CSS if goal is fulfilled
    if($thisweek >= $value){
      $message = 'Success';
      $success_style ="aqua";
    }else{
      $success_style ="not_yet";
    }
     
        print('<form method="post" action="bounce.goal.edit.php">');
        print('<tr>');
        print('<td><div class="titleBox2 '.$success_style.'"><a href="">'.$index.'</a></div></td>');
        print('<td><input type="submit" value="Set Goal"/></td>');
        print('<td>
        <input type="text" value="'.$value.'" class="form-control"   name="goal_week_value">
        </td>');
        print('<input type="hidden" value="'.$index.'" name="goal_title">');
        print('<input type="hidden" value="'.$index.'" name="goal_id">');
        print('</form>');
        print('<td><input type="text" value="'.$thisweek.'" class="form-control"/></td>');
        print('</tr>');
      
  }
  print('</table>');
}

    function form_set_weekly_goals(){
        print('<form action="bounce.goals.edit.php" method="post">');
        print('<div class="form-group">');
        print('<input type="hidden" value="updategoals" id="updategoals" name="updategoals"/>');
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        print('<form>');
        for($i=0; $i < sizeof($value); $i++){
          print('<p>Lexicon</p>');

        }
        print('<button type="submit" class="btn btn-primary">Submit</button>');
        print('</form>');
        print('<p>&nbsp;<br/>&nbsp;<br/></p>');
    }

/*
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
*/
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

   function goals_total_hours(){
     // this function 'sets' the total
     // hours worth of goals and create member 
     // property $goals_total_hours
      try {
        $sth = $this->conn->prepare("SELECT sum(hours) FROM tomato220.goals where active = 1");
        $sth->execute();
        $result = $sth->fetchColumn();
        // send upstairs
        $this->goals_total_hours = $result;

      } catch (Exception $e){
        echo 'Caught exception:', $e->getMessage(), '/n';
      }
   }

   public function goals_so_far_this_week(){
     // (1) build up this week week number
    $date = new DateTime();
    $week_no = $date->format("W");
    $year = date("Y");
    $week = $year.'-W'.$week_no;
    // send upstairs
    $this->week_number_current = $week;
    // (2) query dbase for toms by weeknunmber
    $sth = $this->conn->prepare("SELECT sum(count) FROM tomato220.tomato WHERE tomato.tomweek like :WEEKNO");
    $sth->bindParam(':WEEKNO',$this->week_number_current);
    $sth->execute();
    $hours = $sth->fetchColumn();
    // send upstairs
    $this->goals_so_far_this_week = $hours*(.5);
   }

   public function goals_toms_needed_this_week($toms_achieved=0, $toms_goal=0){
    $toms_needed = $toms_goal - $toms_achieved;
    $this->toms_needed = $toms_needed;
   }

   public function goals_toms_per_day_needed($toms_achieved=0, $toms_goal=0){
    $toms_needed = $toms_goal - $toms_achieved;
    // this code find nunmber of days left in week
    $days_left_in_week = 7-(date('w'));
    // divide toms needed by number of remaining days in week
    $needed_per_day2 = $toms_needed/($days_left_in_week);
    // send upstares
    $this->toms_needed_per_day = round($needed_per_day2);
   }

   public function goals_info_table($goals_total_hours=0, $goals_so_far_this_week=0, $toms_needed=0, $per_day=0){
      print('<table class="table table-bordered" id="goals_table">
      <thead>
        <tr>
          <th scope="col">Target</th>
          <th scope="col">So Far</th>
          <th scope="col">Left</th>
          <th scope="col">Per Day</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>'.$goals_total_hours.'</th>
          <td>'.$goals_so_far_this_week.'</td>
          <td>'.$toms_needed.'</td>
          <td>'.$per_day.'</td>
        </tr>
      </tbody>
    </table>');
   }
}

?>