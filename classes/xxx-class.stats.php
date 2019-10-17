<?PHP
class stats extends conn{
    public $stats_total_goal_hours_per_week=1;

    function stats_total_goal_hours_per_week(){
        $sth = $this->conn->prepare("SELECT sum(targethours) FROM `tomato220`.`weeklygoals`");
        $sth->execute();
        $result = $sth->fetchColumn();
        // send upstairs
         $this->$stats_total_goal_hours_per_week = $result;
        }

}
/*

*/

?>