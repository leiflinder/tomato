<?php
class setup extends conn{

function set_timestamp_by_datestring(){
    $sth = $this->conn->prepare("SELECT `tomato`.`id`,`tomato`.`datestring` FROM `tomato220`.`tomato`");
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $size = sizeof($resource);
    for ($i = 0; $i < $size; $i++){
        $timestamp = strtotime($resource[$i]['datestring']);
        $integer = idate('w', $timestamp);
      //   print('<p>ID '.$resource[$i]['id'].'</p>');
      //   print('<p>Datestring:  '.$resource[$i]['datestring'].'</p>');
      //   print('<p>Timestamp: '.$timestamp.'</p>');
      //   print('<p>DOW '.$integer.'</p>');
      $this->upload_values($resource[$i]['id'], $timestamp, $integer);
    }
}

    function upload_values($tomid, $datestringstamp, $dow){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`timestamp` = :DATESTRINGSTAMP, `tomato`.`weekdayno` = :DOW WHERE `tomato`.`id` = :TOMATOID");
        $sth->bindParam(':TOMATOID', $tomid);
        $sth->bindParam(':DATESTRINGSTAMP', $datestringstamp);
        $sth->bindParam(':DOW', $dow);
        $sth->execute();
    }

}
?>