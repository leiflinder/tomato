<?php
class viewday extends conn{
    public $today; //date
    public $yesterday; // date
    public $userid; // userid
    public $today_tomatoes_dbase_resource = array();
    public $yesterday_tomatoes_dbase_resource = array();
    public $number_of_tomatoes_today;
    public $time_in_hours_today; // sum of all tomatoes today in hours
    public $time_in_hours_yesterday; // sum of all tomatoes today in hours
    public $tasks_today;
    public $tasks_yesterday;


    public function today(){
        $this->today = date("Y-m-d");
    }

    public function yesterday(){
        $this->yesterday = date("Y-m-d", strtotime("yesterday")); 
    }

    public function set_userid(){
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
        }
    }
    public function today_tomatoes(){
        $userid = $this->userid;
        $datevalue = $this->today;
        // query todays tomatoes with userid and today date
        $stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomdate` LIKE :DATEVALUE");
        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':DATEVALUE', $datevalue, PDO::PARAM_STR);
        $stmt->execute(); 
        $today_tomatoes = $stmt->fetchall(PDO::FETCH_ASSOC);
        //$this->$today_tomatoes_array = $today_tomatoes;
        $this->today_tomatoes_dbase_resource  = $today_tomatoes;
        $this->tasks_today = sizeof($today_tomatoes);
    }

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

    /*
    public function total_tomatoes_today($dbase_resultset=0){
        if($dbase_resultset==0){
            throw new Exception("<p>Resultset has no value</p>");
        }
            return sizeof($dbase_resultset);
    }
*/

    public function set_total_hours_today(){
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomdate` = :DATEVALUE');
        
        $stmt->bindParam(':USERID', $this->userid, PDO::PARAM_INT);
        $stmt->bindParam(':DATEVALUE', $this->today, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5); // in hours
        $this->time_in_hours_today = $total_tomatoes; 
    }

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

    public function day_view(){
        print('<table class="table">');
        print('<tr><td>Date</td><td>'.$this->today.'</td></tr>');
        print('<tr><td>User ID</td><td>'.$this->userid.'</td></tr>');
        print('<tr><td>Tasks</td><td>'.$this->tasks_today.'</td></tr>');
        print('<tr><td>Total Time (hrs)</td><td>'.$this->time_in_hours_today.'</td></tr>');
        print('</table>');
    }

    public function day_view_yesterday(){
        print('<table class="table">');
        print('<tr><td>Date</td><td>'.$this->yesterday.'</td></tr>');
        print('<tr><td>User ID</td><td>'.$this->userid.'</td></tr>');
        print('<tr><td>Tasks</td><td>'.$this->tasks_yesterday.'</td></tr>');
        print('<tr><td>Total Time (hrs)</td><td>'.$this->time_in_hours_yesterday.'</td></tr>');
        print('</table>');
    }

}
?>