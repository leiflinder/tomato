<?php
class keyworddelete extends conn{
private $number_times_keyword_used = 0;

    function show_toms_associated_with_keyword($keyword_id){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`keyword_id` = :KEYWORDID");
        $stm->bindParam(':KEYWORDID',$keyword_id);
        $stm->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        if ($resource->rowCount() < 1){
            print('<div class="alert alert-danger" role="alert">No tomatoes have that keyword</div>');
        } else {
            $count = sizeof($resource);
            for($i=0; $i < $count; $i++ ){
                $this->get_tomatoes_by_tomatoid($resource['tomid']);
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

    function show_keywords_with_delete_button(){
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
        $stm->execute();
        $resource= $stm->fetchall(PDO::FETCH_ASSOC);
        $count = sizeof($resource);
        print('<table class="table">');
        for($i=0; $i < $count; $i++){
            print('<tr>
            <td valign="top">'.$resource[$i]['keyword'].'</td>  
            <td><button type="button" class="btn btn-light" data-toggle="modal" data-target="#'.$resource[$i]['id'].'">Delete</button>
            </td>
            </tr>'); 
            print('
                <div id="'.$resource[$i]['id'].'" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">'.$resource[$i]['keyword'].'</h4>
                      </div>
                      <div class="modal-body">
                      <h2>Really?</h2>
                      <p><span class="bigandbad">'.$resource[$i]['keyword'].'</span> is used on ['.$this->times_keyword_used($resource[$i]['id']).'] tomato entries</p>
                      <form method="post" action="refresh.deletekeyword.php">
                      <input type="hidden" name="keyid" value="'.$resource[$i]['id'].'"/>
                        <p><input type="submit" value="Delete"/></p>
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

    // helper function
    function times_keyword_used($keyid){
        $stm =$this->conn->prepare("SELECT  * FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`keyword_id` = :KEYID");
        $stm->bindParam(':KEYID',$keyid);
        $stm->execute();
        $resource = $stm->fetchall(PDO::FETCH_ASSOC);
        $rows = sizeof($resource);
        return $rows;      
    }

    function delete_tom_keyword_links($keyid){
        $stm =$this->conn->prepare("DELETE FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`keyword_id` = :KEYID");
        $stm->bindParam(':KEYID',$keyid);
        $stm->execute();        
    }
    function delete_actual_keyword($keyid){
        $stm =$this->conn->prepare("DELETE FROM `tomato220`.`keywords` WHERE `keywords`.`id` = :KEYID");
        $stm->bindParam(':KEYID',$keyid);
        $stm->execute();        
    }
}
?>