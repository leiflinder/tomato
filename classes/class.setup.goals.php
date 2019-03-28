<?PHP
class setupgoals extends conn{

    function form_set_weekly_goals(){
        print('<form action="refresh.goals.edit.php" method="post">');
        print('<div class="form-group">');
        print('<input type="hidden" value="updategoals" id="updategoals" name="updategoals"/>');
        /*
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`weeklygoals`");
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        for($i=0; $i < sizeof($value); $i++){
            print('<label for="'.$value[$i]['categorytitle'].'">'.$value[$i]['categorytitle'].'</label>');
            print('<input type="text" value="'.$value[$i]['targethours'].'" class="form-control" id="'.$value[$i]['categorytitle'].'" name="'.$value[$i]['categorytitle'].'"/>');
        }*/


        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $sth->execute();
        $value = $sth->fetchall(PDO::FETCH_ASSOC);
        for($i=0; $i < sizeof($value); $i++){
            print('<label for="'.$value[$i]['id'].'">'.$value[$i]['catname'].'</label>');
            print('<input type="text" value="'.$value[$i]['hours'].'" class="form-control" id="'.$value[$i]['id'].'" name="'.$value[$i]['catname'].'"/>');
        }

        print('</div>');
        print('<button type="submit" class="btn btn-default">Submit</button>');
        print('</form>');
        /*
        print('<form action="/action_page.php">');
        print('<div class="form-group">');
        print('<label for="email">Email address:</label>');
        print('<input type="email" class="form-control" id="email">');
        print('</div>');
        print('<div class="form-group">');
        print('<label for="pwd">Password:</label>');
        print('<input type="password" class="form-control" id="pwd">');
        print('</div>');
        print('<button type="submit" class="btn btn-default">Submit</button>');
        print('</form>');
        */

    }

   function check_goal_if_changed($catid, $goal){
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`weeklygoals` WHERE `weeklygoals`.`categoryid` = :CATID AND `weeklygoals`.`targethours` = :GOAL");
    $sth->execute();
    $value = $sth->fetchall(PDO::FETCH_ASSOC);
        if(sizeof($value)>0){
            print('<p>This goal already exists</p>');
        }else{
            print('<p>This is new goal</p>');
        }
   }
}

?>