<?PHP
class setupgoals extends conn{

    function testform(){
    print(' 
    
    <form>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  
  ');
    }

    function form_set_weekly_goals(){
        print('<form action="refresh.goals.edit.php" method="post">');
        print('<div class="form-group">');
        print('<input type="hidden" value="updategoals" id="updategoals" name="updategoals"/>');
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        for($i=0; $i < sizeof($value); $i++){
            print('<input type="hidden" name="catnames[]" value="'.$value[$i]['catname'].'">');
            print('<input type="hidden" name="catids[]" value="'.$value[$i]['categoryid'].'">');
            print('<table><tr>');
            print('<td>'.$value[$i]['catname'].'</td>');
            print('<td><input type="text" value="'.$value[$i]['hours'].'" id="'.$value[$i]['id'].'" name="goals[]"></td>');
            print('<td>');
            print('<input type="radio" name="gender" value="male"> Male');
            print('<input type="radio" name="gender" value="female"> Female');
            print('</td>');
            print('</tr></table>');
        }

        print('</div>');
        print('<button type="submit" class="btn btn-default">Submit</button>');
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