<?php
class editCategory extends conn{

    function upload_edited_category($category_id, $new_category_value){
        $stm =$this->conn->prepare("UPDATE `tomato220`.`category` SET `category`.`category` = :NEW_CATEGORY_VALUE WHERE `category`.`id` = :CATEGORY_ID");
        $stm->bindParam(':NEW_CATEGORY_VALUE', $new_category_value);
        $stm->bindParam(':CATEGORY_ID', $category_id);
        $stm->execute();
        $this->conn=NULL;
    }
/*
    function show_categories_with_edit(){
        print('<table class="table">');
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                    print('<tr><td>'.$value[$i]['category'].'</td><td><a href data-toggle="modal" data-target="#'.$value[$i]['id'].'">Edit</a></td></tr>');

                    print('
                    <div id="'.$value[$i]['id'].'" class="modal fade" role="dialog">
                      <div class="modal-dialog">                 
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">'.$value[$i]['category'].'</h4>
                          </div>
                          <div class="modal-body">
                           <p>Edit: '.$value[$i]['category'].'</p>
                           <div>
                            <form method="post" action="home.php?page=categories">
                                <input type="text" name="edit_category_new_value" value="'.$value[$i]['category'].'">
                                <input type="hidden" name="edit_category_id" value="'.$value[$i]['id'].'"/>
                                <input type="submit">
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>');
                }
            }
            print('</table>');
    }
*/
}
?>