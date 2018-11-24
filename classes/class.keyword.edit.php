<?php
class keywordedit extends conn{

    function upload_edited_keyword($keyword_id, $edited){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :EDITED");
        $stm->bindParam(':EDITED',$edited);
        $stm->execute();
        if ($stm->rowCount() > 0){
            print('<p>Opps... Keyword "'.$edited.'" already exists in dBase.</p>');
        } else {
            // since edit keyword does not exist, create it...
            $stm = $this->conn->prepare("UPDATE `tomato220`.`keywords` SET `keywords`.`keyword` = :EDITED WHERE `keywords`.`id` = :KEYWORDID;");
            $stm->bindParam(':KEYWORDID',$keyword_id);
            $stm->bindParam(':EDITED',$edited);
            if($stm->execute()==TRUE){
                print('<div class="alert alert-success" role="alert">'.$edited.' Edited</div>');
            }else{
                print('<div class="alert alert-danger" role="alert">'.$edited.' Not Edited</div>');
            }

        }

        $this->conn=NULL;
    }

    function show_all_keywords_with_edit_delete_links(){
        $sth = $this->conn->prepare("SELECT `keywords`.`keyword`, `keywords`.`id` FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $resource= $sth->fetchall(PDO::FETCH_ASSOC);
       print('<table class="table">');
        for($i=0; $i<(sizeof($resource)); $i++){
            print('<tr><td><a href=""  data-toggle="modal" data-target="#'.$resource[$i]['id'].'">'.$resource[$i]['keyword'].'</link></td><td><a href=""  data-toggle="modal" data-target="#'.$resource[$i]['id'].'">Edit</a></td></tr>');

            // code for modal pop-up box
            print('
            <div id="'.$resource[$i]['id'].'" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">'.$resource[$i]['id'].'</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="new_keyword">Edit Keyword</label>
                            <input type="text" name="edit_keyword" class="form-control" id="edit_keyword" aria-describedby="keyHelp" value="'.$resource[$i]['keyword'].'">
                            <input type="hidden" name="keywordid" value="'.$resource[$i]['id'].'"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>');
        }
        print('</table>');
    }


    function form_create_keyword($keyword_to_edit, $keyword_id){
        print('<form method="post" action="">');
        print('<input type="hidden" name="edit_keyword">');
        print('<input type="hidden" name="keyword_id" value="'.$keyword_id.'">');
        print('<input type="submit">'.$keyword_to_edit.'</input>');
        print('</form>');
        print('<br/>');
    }

}
?>