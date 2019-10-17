<?PHP
class setweek extends conn{

    function set_week($week){
            $sth = $this->conn->prepare("UPDATE `tomato220`.`week` SET `week`.`week` = :week, `week`.`timestamp` = NOW() WHERE `week`.`id` = 1");
        $sth->bindParam(':week', $week, PDO::PARAM_STR);
        $sth->execute();
    }
        function get_week(){
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`week` WHERE `week`.`id` = 1");
        $sth->execute();
        $value = $sth->fetch(PDO::FETCH_ASSOC);
      //  return $value;
      print('<p>'.$value['week'].'</p>');
    }
}

?>