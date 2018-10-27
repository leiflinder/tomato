<?php
class keyworddelete extends conn{

    function show_toms_associated_with_keyword($keyword_id){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`keyword_id` = :KEYWORDID");
        $stm->bindParam(':KEYWORDID',$keyword_id);
        $stm->execute();
        $resource= $sth->fetchall(PDO::FETCH_ASSOC);
        if ($stm->rowCount() < 1){
            print('<div class="alert alert-danger" role="alert">No tomatoes have that keyword</div>');
        } else {
            $count = sizeof($stm);
            for($i=0; $i < $count; $i++ ){

            }
        }
        $this->conn=NULL;
    }

 function get_tomatoes_by_tomatoid($tomid){
    $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID LIMIT 1");
    $stm->bindParam(':TOMID',$tomid);
    $stm->execute();
    $resource= $sth->fetch(PDO::FETCH_ASSOC);
    print('<p>'.$resource['title'].' ID: '.$resource['id'].'</p>');
 }

}
?>