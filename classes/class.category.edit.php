<?php
class editCategory extends conn{

    function upload_edited_category($category_id, $new_category_value){
        $stm =$this->conn->prepare("UPDATE `tomato220`.`category` SET `category`.`category` = :NEW_CATEGORY_VALUE WHERE `category`.`id` = :CATEGORY_ID");
        $stm->bindParam(':NEW_CATEGORY_VALUE', $new_category_value);
        $stm->bindParam(':CATEGORY_ID', $category_id);
        $stm->execute();
        $this->conn=NULL;
    }
}
?>