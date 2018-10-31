<?PHP
    class edittomato extends conn{

            function edit_tomato_count($tomcount, $tomid){
            $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`count` = :TOMCOUNT WHERE `tomato`.`id` = :TOMID;");
            $sth->bindParam(':TOMCOUNT', $tomcount);
            $sth->bindParam(':TOMID', $tomid);
            $sth->execute();
            $number_effected_rows = $sth->rowCount();
                return $number_effected_rows;
        }
    }
?>