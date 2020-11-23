<?php
class viewweek extends conn
{
    private $week_number_only;
    private $week_number;
    public $week_formated_like_database;
    private $userid;
    private $week_dbase_resource;
    private $week_total_tasks;
    private $week_total_hours;
    private $total_number_of_goals;
    private $total_goals_in_hours;
    private $distinct_categories;
    private $goal_categories_array;
    private $goals_achieved_this_week;
    private $today_date;
    private $four_weeks_ago;
    private $twelves_weeks_ago;

    private function set_userid(){
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
        }
    }

    private function set_today_date(){
        print('<p>Hex</p>');
    }
    public function week_number_only($alter=0)
    {
        $WeekNumber = date('W');
        $WeekNumber = $WeekNumber - $alter;
        $this->week_number = $WeekNumber;
        // format like datbase value
        $this->week_formated_like_database = date('Y')."-W".$this->week_number;
    }


    private function week_dbase_resource($week){
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

    private function set_total_hours_this_week($week_number){
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomweek` = :WEEKVALUE');
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->bindParam(':WEEKVALUE', $week_number, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5); // in hours
        $this->week_total_hours = $total_tomatoes; 
    }

    private function number_of_total_goals(){
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`goals`");
        $stmt->execute(); 
        $value = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->total_number_of_goals =  sizeof($value); 
    }

    private function get_distinct_categories($week){
        // SELECT distinct(`category`) FROM `tomato` WHERE `tomweek` LIKE '2020-W17'
        $stmt = $this->conn->prepare("SELECT distinct(`tomato`.`category`) FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :WEEKVALUE");
        $stmt->bindParam(':WEEKVALUE', $week, PDO::PARAM_STR);
        $stmt->execute(); 
        $value = $stmt->fetchall(PDO::FETCH_ASSOC);
        $this->distinct_categories = $value;
     }

     private function total_goals_in_hours($timeperiod, $userid){
        // SELECT distinct(`category`) FROM `tomato` WHERE `tomweek` LIKE '2020-W17'
        $stmt = $this->conn->prepare("SELECT sum(`goals`.`hours`) AS `totalgoals` FROM `tomato220`.`goals` WHERE `goals`.`timeperiod` LIKE :TIMEPERIOD AND `goals`.`userid` LIKE :USERID");
        $stmt->bindParam(':TIMEPERIOD', $timeperiod, PDO::PARAM_STR);
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->execute(); 
        $value = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total_goals_in_hours = $value;
     }

     private function goal_categories_array(){
        $data = $this->conn->query("SELECT `goals`.`catname`, `goals`.`hours` FROM `tomato220`.`goals`")->fetchAll(PDO::FETCH_KEY_PAIR);  
     }

     public function goals_achieved_this_week($timeperiod){
         //create goals array
        $stmt = $this->conn->prepare("SELECT `goals`.`categoryid` AS 'catid', `goals`.`hours` AS 'hours', `goals`.`catname` AS 'catname' FROM `tomato220`.`goals` WHERE `goals`.`userid` = :USERID AND `goals`.`timeperiod` LIKE :TIMEPERIOD");
        $stmt->bindParam(':TIMEPERIOD', $timeperiod, PDO::PARAM_STR);
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->execute(); 
        $value = $stmt->fetch(PDO::FETCH_ASSOC);
     }

    public function generic_time_view(){
        // first set values for this object using class functions
        $this->week_dbase_resource($this->week_formated_like_database);
        $this->set_total_hours_this_week($this->week_formated_like_database);
        $this->number_of_total_goals();
        $this->get_distinct_categories($this->week_formated_like_database);
        $this->total_goals_in_hours("week", $this->userid);
        /*
        print('<table class="table" border="1">');
        print('<tr><th>Total Hrs</th><th>Goals</th><th>Categories</th></tr>');
        print('<tr>');
        print('<td>'.$this->week_total_hours.' / '.$this->total_goals_in_hours['totalgoals'].'</td>');
        print('<td>'.$this->total_number_of_goals.'</td>');
        print('<td>'.sizeof($this->distinct_categories).'</td>');
        print('</tr>');
        print('</table>');
        */
        
        print('<table class="table" border="1">');
        print('<tr><td>Tomatoes achieved</td><td>'.$this->week_total_hours.'</td></tr>');
        print('<tr><td>Tomatoes expected</td><td>'.$this->total_goals_in_hours['totalgoals'].'</td></tr>');
        print('<tr><td>Number of goals</td><td>'.$this->total_number_of_goals.'</td></tr>');
        print('<tr><td>Number of goals achieved</td><td>'.$this->total_number_of_goals.'</td></tr>');
        print('</table>');
        
        //$this->goals_achieved_this_week($this->userid);
        /*
        print('<pre>');
        print_r($this->total_goals_in_hours);
        print('</pre>');
        */
    }

    // list of last 4 weeks
    // list of last 12 weeks
    // graph of last 4 weeks date->toms
    // graph of last 12 weeks date->toms

    public function list_last_weeks($no_of_weeks, $userid){
        $today = "value";
        $date_four_weeks_ago = "value";
        $date_twelve_weeks_ago = "value";
        $date_ago = "value";
        /*
        $stmt = $this->conn->prepare("SELECT `goals`.`categoryid` AS 'catid', `goals`.`hours` AS 'hours', `goals`.`catname` AS 'catname' FROM `tomato220`.`goals` WHERE `goals`.`userid` = :USERID AND `goals`.`timeperiod` LIKE :TIMEPERIOD");
        */
        $stmt = $this->conn->prepare("SELECT `goals`.`categoryid` AS 'catid', `goals`.`hours` AS 'hours', `goals`.`catname` AS 'catname' FROM `tomato220`.`goals` WHERE `goals`.`userid` = :USERID AND `goals`.`timeperiod` LIKE :TIMEPERIOD");

        $stmt->bindParam(':DATEAGO', $date_ago, PDO::PARAM_STR);
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->execute(); 
        $value = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function testsvg($svgwidth=100){
        ?>
          <svg xmlns="http://www.w3.org/2000/svg">
            <g>
            <rect x="0" y="0" width="<?php print($svgwidth)?>" height="100" fill="red"></rect>
            <text x="0" y="50" font-family="Verdana" font-size="35" fill="blue">Hello</text>
            </g>
        </svg>
        <?php
    }

    public function sixtytoms(){
        include('../public_html/SVG/sixtytoms.svg');
    }
}

?>