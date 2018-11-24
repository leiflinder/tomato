<?php
class createCategory extends conn{

    function upload_new_category($new_category, $userid=1001, $favorite=1){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`category` LIKE :NEWCATEGORY AND `category`.`userid` = :USERID");
        $stm->bindParam(':NEWCATEGORY',$new_category);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        if ($stm->rowCount() > 0){
           // print('<p>Keyword "'.$new_category.'" already exists in dBase.</p>');
            $message="Redundant";
            } else {

            $stm = $this->conn->prepare("INSERT INTO `tomato220`.`category` (`category`.`id`, `category`.`userid`, `category`.`category`, `category`.`favorite`, `category`.`timestamp`) VALUES (NULL, :USERID, :NEWCATEGORY, :FAVORITE, CURRENT_TIMESTAMP)"); 
/*
            INSERT INTO `category` (`id`, `userid`, `category`, `favorite`, `timestamp`) VALUES (NULL, '1001', 'test-wwww', '0', CURRENT_TIMESTAMP);
*/

            $stm->bindParam(':USERID',$userid);
            $stm->bindParam(':NEWCATEGORY',$new_category);
            $stm->bindParam(':FAVORITE',$favorite);
            $stm->execute();
            $stm->execute();
            $count = $stm->rowCount();  
            if($count > 0){
                $message='ID: '.$categoryid.' Created';
            }else{
                $message="Problem";
            }
        }

        $this->conn=NULL;
        return $message;
    }

    function form_create_category(){ 
        // $_POST['category_submit']
        // $_SESSION['userid']
        //  $_POST['new_category']
        // $_POST['favorite']
        print('<form method="post" action="refresh.category.create.php">');
        print('<input type="hidden" name="category_submit" value="1"/>');
        print('<input type="hidden" name="userid" value="'.$_SESSION['userid'].'"/>');
        print('<input type="hidden" name="favorite" value="1"/>');
        print('<div class="form-group">');
        print('<label for="new_category">New Category</label>');
        print('<input type="text" name="new_category" class="form-control" id="new_category" aria-describedby="catHelp" placeholder="Enter Category">');
        print('<small id="catHelp" class="form-text text-muted">No Spaces. Capitalize.</small>');
        print('</div>');
        print('<button type="submit" class="btn btn-primary">Submit</button>');
        print('</form><br/>');
    }

}
?>