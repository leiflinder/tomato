<?php
class deletetomato extends conn
{
    public function delete_tomato($tomid){
            $sth = $this->conn->prepare("DELETE FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID LIMIT 1");
            $sth->bindParam(':TOMID', $tomid);
            $sth->execute();
            $sth = $this->conn->prepare("DELETE FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`tom_id`  = :TOMID LIMIT 10");
            $sth->bindParam(':TOMID', $tomid);
            $sth->execute();
            $number_effected_rows = $sth->rowCount();
            return $number_effected_rows;
        }
}
?>