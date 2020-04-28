<?php
class viewweek extends conn{
    public $thisweek; // this week number
  //  public $yesterday; // date
    public $WeekNumber;
    public $total_number_of_goals;
    public $userid; // userid
    public $week_dbase_resource = array();
    public $last_week_dbase_resource = array();
    public $number_of_tomatoes_today;
    public $time_in_hours_this_week; // sum of all tomatoes this week in hours
  //  public $time_in_hours_yesterday; // sum of all tomatoes today in hours
    public $week_total_tasks; // all of the indiviudal tasks (not tomatoes)
  //  public $tasks_yesterday;
    public $defaultWeekNumber;
    public $distinct_categories_for_specific_week;

    public function number_of_total_goals(){
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $stmt->execute(); 
        $value = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->total_number_of_goals =  sizeof($value); 
    }

    public function thisweek(){
        $currentWeekNumber = "W".date('W');
        $this->thisweek=$currentWeekNumber;
}

public function default_week_number($value=0){
    $WeekNumber = date('Y')."-W".date('W');
    $this->WeekNumber=$WeekNumber;
}

public function default_week_setting(){
    $currentWeekNumber = date('Y')."-W".date('W');
    $this->defaultWeekNumber=$currentWeekNumber;
}
   
/*  public function yesterday(){
        $this->yesterday = date("Y-m-d", strtotime("yesterday")); 
    }
*/
    public function set_userid(){
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
        }
    }

    public function week_dbase_resource($week){
        $userid = $this->userid;
        $defaultWeekNumber = $this->defaultWeekNumber;
        // query todays tomatoes with userid and today date
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomweek` LIKE :WEEKVALUE");
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':WEEKVALUE', $defaultWeekNumber, PDO::PARAM_STR);
        $stmt->execute(); 
        $week_tomatoes = $stmt->fetchall(PDO::FETCH_ASSOC);
        //$this->$today_tomatoes_array = $today_tomatoes;
        $this->week_dbase_resource  = $week_tomatoes;
        $this->week_total_tasks = sizeof($week_tomatoes);
    }

    /*
    public function yesterday_tomatoes(){
        $userid = $this->userid;
        $datevalue = $this->yesterday;
        // query todays tomatoes with userid and today date
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomdate` LIKE :DATEYESTERDAY");
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':DATEYESTERDAY', $datevalue, PDO::PARAM_STR);
        $stmt->execute(); 
        $yesterday_tomatoes = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->yesterday_tomatoes_dbase_resource  = $yesterday_tomatoes;
        $this->tasks_yesterday = sizeof($yesterday_tomatoes);
    }

*/
    public function set_total_hours_this_week($week_number){
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomweek` = :WEEKVALUE');
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->bindParam(':WEEKVALUE', $week_number, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5); // in hours
        $this->time_in_hours_this_week = $total_tomatoes; 
    }

/*
    public function set_total_hours_yesterday(){
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomdate` = :DATEVALUE');
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->bindParam(':DATEVALUE', $this->yesterday, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5); // in hours
        $this->time_in_hours_yesterday = $total_tomatoes; 
    }

*/
    public function generic_time_view(){
        print('<table class="table" border="1">');
        print('<tr><th>Total Hrs</th><th>Goals</th><th>Categories</th></tr>');
        print('<tr>');
        print('<td>'.$this->time_in_hours_this_week.'</td>');
        print('<td>'.$this->total_number_of_goals.'</td>');
        print('<td>'.$this->time_in_hours_this_week.'</td>');
        print('</tr>');
        print('</table>');
    }

    /*
    public function this_view(){
        print('<table class="table" border="1">');
        print('<tr><td>Date</td><td>'.$this->thisweek.'</td></tr>');
        print('<tr><td>User ID</td><td>'.$this->userid.'</td></tr>');
        print('<tr><td>Tasks</td><td>'.$this->this_week_total_tasks.'</td></tr>');
        print('<tr><td>Total Time (hrs)</td><td>'.$this->time_in_hours_today.'</td></tr>');
        print('</table>');
    }
*/
    /*
    public function day_view_yesterday(){
        print('<table class="table">');
        print('<tr><td>Date</td><td>'.$this->yesterday.'</td></tr>');
        print('<tr><td>User ID</td><td>'.$this->userid.'</td></tr>');
        print('<tr><td>Tasks</td><td>'.$this->tasks_yesterday.'</td></tr>');
        print('<tr><td>Total Time (hrs)</td><td>'.$this->time_in_hours_yesterday.'</td></tr>');
        print('</table>');
    }
    */

    public function get_distinct_categories_for_specific_week($week){
       // SELECT distinct(`category`) FROM `tomato` WHERE `tomweek` LIKE '2020-W17'
       $stmt = $this->conn->prepare("SELECT distinct(`tomato`.`category`) FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :WEEKVALUE");
       $stmt->bindParam(':WEEKVALUE', $week, PDO::PARAM_STR);
       $stmt->execute(); 
       $value = $stmt->fetchall(PDO::FETCH_ASSOC);
       $this->distinct_categories_for_specific_week = $value;
    }
}
?>