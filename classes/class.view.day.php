<?php
class viewday extends conn{
    public $today; //date
    public $userid; // userid
    public $today_tomatoes_dbase_resource = array();
    public $number_of_tomatoes_today;
    public $time_in_hours; // sum of all tomatoes today in hours
    public $tasks_today;

    public function today(){
        $this->today = date("Y-m-d");
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

    public function total_tomatoes_today($dbase_resultset=0){
        if($dbase_resultset==0){
            throw new Exception("<p>Resultset has no value</p>");
        }
            return sizeof($dbase_resultset);
    }

    public function set_total_tomato_hours(){
        /*
        $stmt = $this->conn->prepare("SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = :USERID AND `tomato`.`tomdate` = :DATEVALUE");
        */
        $stmt = $this->conn->prepare('SELECT sum(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`userid` = 1001 AND `tomato`.`tomdate` = "2020-04-05"');

        $stmt->bindParam(':USERID', $userid, PDO::PARAM_INT);
        $stmt->bindParam(':DATEVALUE', $datevalue, PDO::PARAM_STR);
        $stmt->execute(); 
        $total_tomatoes = $stmt->fetch();
        $total_tomatoes = $total_tomatoes[0];
        $total_tomatoes = ($total_tomatoes)*(.5);
        $this->time_in_hours = $total_tomatoes; 
    }

    public function day_view(){
        print('<table class="table">');
        print('<tr><td>Date</td><td>'.$this->today.'</td></tr>');
        print('<tr><td>User ID</td><td>'.$this->userid.'</td></tr>');
        print('<tr><td>Tasks</td><td>'.$this->tasks_today.'</td></tr>');
        print('<tr><td>Total Time (hrs)</td><td>'.$this->time_in_hours.'</td></tr>');
        print('</table>');
    }

}
?>