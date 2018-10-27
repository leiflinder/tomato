<?php
class editCategory extends conn{

    function upload_edited_category($new_category_value, $category_id){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`category` LIKE :new_category");
        $stm =$this->conn->prepare("UPDATE `tomato220`.`category` SET `category`.`category` = :NEW_CATEGORY_VALUE WHERE `category`.`id` = :CATEGORY_ID");
        $stm->bindParam(':NEW_CATEGORY_VALUE', $new_category_value);
        $stm->bindParam(':CATEGORY_ID', $category_id);
        if($stm->execute()){
            print('<p>Category was updated successfuly.</p>');
        }else{
            print('<p>Oops. Execute() did not work.</p>');
        }
        $this->conn=NULL;
    }

}
?>