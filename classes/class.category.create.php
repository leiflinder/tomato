<?php
class createCategory extends conn{

    function upload_new_category($new_category){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`category` LIKE :new_category");
        $stm->bindParam(':new_category',$new_category);
        $stm->execute();
        if ($stm->rowCount() > 0){
            print('<p>Keyword "'.$new_category.'" already exists in dBase.</p>');
        } else {
            // since keyword does not exist, create it...
            $stm = $this->conn->prepare("INSERT INTO `tomato220`.`category` (`category`.`id`, `category`.`category`, `category`.`timestamp`) VALUES (NULL, :new_category, CURRENT_TIMESTAMP);");
            $stm->bindParam(':new_category',$new_category);
            if($stm->execute()==TRUE){
                print("<p><span class='greeny'>".$new_category."</span> category added.</p>");
            }else{
                print("<p><span class='greeny'>".$new_category."</span> category does NOT exist. Did NOT upload.</p>");
            }

        }

        $this->conn=NULL;
    }

    function form_create_category(){
        print('<h3>Create Category</h3>');
        print('<form method="post" action="">');
        print('<input type="text" name="new_category">');
        print('<input type="submit">');
        print('</form>');
        print('<br/>');
    }

}
?>