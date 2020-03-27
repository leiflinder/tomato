<?php
class keywordedit extends conn
{

  var $categories_array;

    private function number_keyword_used($keyid){
        $times_used = new keyworddelete;
        $rows = $times_used->times_keyword_used($keyid);
        return $rows;
    }

  public function all_catetories_form(){
      $stm = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
      $stm->execute();
      $resource = $stm->fetchall(PDO::FETCH_ASSOC);
      for ($i = 0; $i < (sizeof($resource)); $i++) {
          $this->categories_array[$resource[$i]['id']] = $resource[$i]['category'];
      }
  }
    

   protected $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    
   public function upload_edited_keyword($keyword_id, $edited)
    {
        // first check if keyword exists already
        $stm = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :EDITED");
        $stm->bindParam(':EDITED', $edited);
        $stm->execute();
        if ($stm->rowCount() > 0) {
           // print('<p>Opps... Keyword "' . $edited . '" already exists in dBase.</p>');
            $alert='warning';
            $message='Opps... Keyword "' . $edited . '" already exists in dBase';
            $return_value = array($alert,$message);
            return $return_value;
            return;
        } else {
            // since edit keyword does not exist, create it...
            $stm = $this->conn->prepare("UPDATE `tomato220`.`keywords` SET `keywords`.`keyword` = :EDITED WHERE `keywords`.`id` = :KEYWORDID;");
            $stm->bindParam(':KEYWORDID', $keyword_id);
            $stm->bindParam(':EDITED', $edited);
            if ($stm->execute() == TRUE) {
              $alert='success';
              $message=$edited.' successfuly edited';
              $return_value = array($alert,$message);
              return $return_value;
              //  print('<div class="alert alert-success" role="alert">' . $edited . ' Edited</div>');
            } else {
                // print('<div class="alert alert-danger" role="alert">' . $edited . ' Not Edited</div>');
                $alert='warning';
                $message='fail.. '.$edited.' not edited';
                $return_value = array($alert,$message);
                return $return_value;
            }
            
        }
        
        $this->conn = NULL;
    }
     
  // use this function inside alphabet_accordion_with_keywords()
    function show_keywords_by_first_letter_with_edit_delete_links($firstleter="a")
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :FIRSTLETTER ORDER BY `keywords`.`keyword` ASC");
        // its so crazy that you have to add wildcard to the variable, not the bound parameter
        // bound parametes will not take wild card % symbol.
        // see php.net https://www.php.net/manual/en/pdostatement.bindparam.php
        $firstleter = $firstleter."%";
        $sth->bindParam(':FIRSTLETTER', $firstleter, PDO::PARAM_STR);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        print('<table class="table keywordtable">');
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            print('<tr>
            <td class="keywordcolumn"><span class="keywordlabel">'.$resource[$i]['keyword'].'</span></td>
            <td class="linkkeyword"><a href="home.php?page=linkcategories&keywordid='.$resource[$i]['id'].'">Link</a></td>
            <td><a href="" data-toggle="modal" data-target="#edit'.$resource[$i]['id'].'"><img src="./images/edit1001.png"/></a></td>
            <td><a href="" data-toggle="modal" data-target="#delete'.$resource[$i]['id'].'" class="delete_label"><img src="./images/delete1001.png"/></a></td>
            </tr>');

            print('<div class="modal fade keyword_edit_modal" id="edit'.$resource[$i]['id'].'" tabindex="-1" role="dialog" aria-labelledby="EditKeyword" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form method="post" action="refresh.keyword.edit.php">
                    <div class="form-group">
                        <input type="text" class="form-control" value="'.$resource[$i]['keyword'].'" id="keywordedit" name="keywordedit">
                        <input type="hidden" name="keywordid" value="'.$resource[$i]['id'].'"/>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
              </div>
            </div>
          </div>');


          // delete keyword modal
          print('
          <div id="delete' . $resource[$i]['id'] . '" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <h2>Really?</h2>
                <p><span class="bigandbad">' . $resource[$i]['keyword'] . '</span> is used on '.$this->number_keyword_used($resource[$i]['id']).' tomato entries</p>
                <form method="post" action="refresh.keyword.delete.php">
                <input type="hidden" name="keyid" value="' . $resource[$i]['id'] . '"/>
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



    function form_create_keyword($keyword_to_edit, $keyword_id)
    {
        print('<form method="post" action="">');
        print('<input type="hidden" name="edit_keyword">');
        print('<input type="hidden" name="keyword_id" value="' . $keyword_id . '">');
        print('<input type="submit">' . $keyword_to_edit . '</input>');
        print('</form>');
        print('<br/>');
    }
    
    
    function keywords_edit_with_current_selected($category_param = 1)
    {
        if ($category_param) {
            $this->category = $category_param;
        } else {
            $this->category = 1;
        }
        $sth = $this->conn->prepare("SELECT tomato220.keywords.keyword AS keyword, tomato220.keywords.id AS id 
                FROM tomato220.link_cat_to_keywords 
                JOIN tomato220.keywords 
                ON tomato220.link_cat_to_keywords.keyword_id = tomato220.keywords.id
                WHERE tomato220.link_cat_to_keywords.cat_id = " . $this->category . " ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $table = $sth->fetchAll();
        foreach ($table as $value) {
            print('<div class="form-check">
                <input class="form-check-input" name="keywords[]" type="checkbox" value="' . $value['id'] . '" id="' . $value['id'] . '">
                <label class="form-check-label" for="' . $value['id'] . '">
                ' . $value['keyword'] . '</label>
              </div>');
        }
    }
    

    // helper function
    private function get_first_char_of_string($string){
        $first_letter = substr($string, 0, 1);
      return $first_letter;
    }

    // helper function
    private function check_array_index_for_value($value, $array){
      $truefalse = array_key_exists($value, $array);
      return $truefalse;
    }


    public function alphabet_accordion_with_keywords(){
        $letter = $this->alphabet;
        for($i=0;$i<sizeof($letter);$i++){
            $letter[$i];
        print('<p><a class="btn btn-primary hundred_percent_width" data-toggle="collapse" href="#'.$letter[$i].'" role="button" aria-expanded="false" aria-controls="collapseExample">'.$letter[$i].'</a>');
        print('<div class="collapse" id="'.$letter[$i].'">');
        // use this function to print out all keywords that start with the leter
        print($this->show_keywords_by_first_letter_with_edit_delete_links($letter[$i]));
        print('</div>');
        }
    }
}
?>