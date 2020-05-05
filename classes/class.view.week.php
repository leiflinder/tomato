<?php
class viewweek extends conn
{
    public $week_number_only;
    public $week_number;
    public $week_formated_like_database;
    public $userid;
    public $week_dbase_resource;
    public $week_total_tasks;
    public $week_total_hours;
    public $total_number_of_goals;
    public $total_goals_in_hours;
    public $distinct_categories;
    public $goal_categories_array;

    public function set_userid(){
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
        }
    }

    public function week_number_only($alter=NULL)
    {
        $WeekNumber = date('W');
        $WeekNumber = $WeekNumber - $alter;
        $this->week_number = $WeekNumber;
        // format like datbase value
        $this->week_formated_like_database = date('Y')."-W".$this->week_number;
    }

    public function week_dbase_resource($week){
        $this->set_userid();
        $userid = $this->userid;
        // query todays tomatoes with userid and today date
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomweek` LIKE :WEEKVALUE");
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':WEEKVALUE', $week, PDO::PARAM_STR);
        $stmt->execute(); 
        $week_tomatoes = $stmt->fetchall(PDO::FETCH_ASSOC);
        //$this->$today_tomatoes_array = $today_tomatoes;
        $this->week_dbase_resource  = $week_tomatoes;
        $this->week_total_tasks = sizeof($week_tomatoes);
    }

    public function set_total_hours_this_week($week_number){
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomweek` = :WEEKVALUE');
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->bindParam(':WEEKVALUE', $week_number, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5); // in hours
        $this->week_total_hours = $total_tomatoes; 
    }

    public function number_of_total_goals(){
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $stmt->execute(); 
        $value = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->total_number_of_goals =  sizeof($value); 
    }

    public function get_distinct_categories($week){
        // SELECT distinct(`category`) FROM `tomato` WHERE `tomweek` LIKE '2020-W17'
        $stmt = $this->conn->prepare("SELECT distinct(`tomato`.`category`) FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :WEEKVALUE");
        $stmt->bindParam(':WEEKVALUE', $week, PDO::PARAM_STR);
        $stmt->execute(); 
        $value = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->distinct_categories = $value;
     }

     public function total_goals_in_hours($timeperiod, $userid){
        // SELECT distinct(`category`) FROM `tomato` WHERE `tomweek` LIKE '2020-W17'
        $stmt = $this->conn->prepare("SELECT sum(`goals`.`hours`) AS `totalgoals` FROM `tomato220`.`goals` WHERE `goals`.`timeperiod` LIKE :TIMEPERIOD AND `goals`.`userid` LIKE :USERID");
        $stmt->bindParam(':TIMEPERIOD', $timeperiod, PDO::PARAM_STR);
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->execute(); 
        $value = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total_goals_in_hours = $value;
     }

     public function goal_categories_array(){
        $data = $this->conn->query("SELECT `goals`.`catname`, `goals`.`hours` FROM `tomato220`.`goals`")->fetchAll(PDO::FETCH_KEY_PAIR);  
     }

     public function goals_achieved_this_week($userid){
         // create array of categories
        print('<pre>');
        print_r($this->week_dbase_resource);
        print('</pre>');
        
     }

    public function generic_time_view(){
        $this->week_dbase_resource($this->week_formated_like_database);
        $this->set_total_hours_this_week($this->week_formated_like_database);
        $this->number_of_total_goals();
        $this->get_distinct_categories($this->week_formated_like_database);
        $this->total_goals_in_hours("week", $this->userid);
        print('<table class="table" border="1">');
        print('<tr><th>Total Hrs</th><th>Goals</th><th>Categories</th></tr>');
        print('<tr>');
        print('<td>'.$this->week_total_hours.' / '.$this->total_goals_in_hours['totalgoals'].'</td>');
        print('<td>'.$this->total_number_of_goals.'</td>');
        print('<td>'.sizeof($this->distinct_categories).'</td>');
        print('</tr>');
        print('</table>');
        $this->goals_achieved_this_week($this->userid);
        /*
        print('<pre>');
        print_r($this->total_goals_in_hours);
        print('</pre>');
        */
    }
}

?>