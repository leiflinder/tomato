<?php
class addtomato extends conn{

    public $lastid;
    public $todaydate;
    private $existing_categories;
    private $defaultWeekNumber;
    private $week_value_from_db;
    private $datestring;
   // private $todaydate;

   private function datestring(){
    $this->datestring = date("Y-m-d",$_SERVER['REQUEST_TIME']);
   }
private function default_week_setting(){
        $currentWeekNumber = date('Y')."-W".date('W');
        $this->defaultWeekNumber=$currentWeekNumber;
}

public function today_date(){

}

function week_value_from_week_table(){{
    $currentWeekNumber = date('Y')."-W".date('W');
    $this->defaultWeekNumber=$currentWeekNumber;
}$week = $sth->fetchColumn();
    $this->week_value_from_db = $week;
}

    public function upload_form_tomato(){
        // set default "week" and send upstairs
        $this->default_week_setting();
        // reset link below to empty form fields
        print('<p><a href="home.php">Reset</a></p>');

        print('<form method="post" id="upload_form_tomato" action="bounce.tomato.create.php">');
        print('<input type="hidden" name="userid" value="'.$_SESSION['userid'].'">');
        print('<input type="hidden" name="tomato_submit" value="yes">');

    // Title
       echo'<div class="form-group">
        <label for="tomatoTitle_FormElement">Title</label>
        <input type="text" name="title" class="form-control" id="tomatoTitle_FormElement" aria-describedby="titleHelp" placeholder="Tomato Title">
        <small id="titleHelp" class="form-text text-muted">Keep it short and sweet.</small>
      </div>';

    // Description
    echo '<div class="form-group">
    <label for="tomatoDescription_FormElement">Notes</label>
     <textarea name="notes" class="form-control" id="tomatoDescription_FormElement" placeholder="Notes" rows="3"></textarea>
     <small id="notesHelp" class="form-text text-muted">Write a lot of notes.</small>
   </div>';

        // Count
        echo'<div class="form-group">
        <label for="tomatoCount_FormElement">Count</label>
        <input type="number" name="count" class="form-control" id="tomatoCount_FormElement" aria-describedby="countHelp" placeholder="Count">
        <small id="countHelp" class="form-text text-muted">Number of tomatos.</small>
      </div>';

    // Date
    // the initial value is created by Javascript
    // date value is constantly updating and alway fresh
    // date value inserted on id="MachineDate"
        echo'<div class="form-group">
        <label for="tomatoDate_FormElement">Date</label>
        <input type="date" name="date" class="form-control" id="MachineDate" aria-describedby="dateHelp" placeholder="Date">
        <small id="dateHelp" class="form-text text-muted">Enter date of tomato.</small>
      </div>';


     // Week
      echo'<div class="form-group">
      <label for="tomatoWeek_FormElement">Week</label>
      <input type="text" name="week" class="form-control" id="tomatoWeek_FormElement" aria-describedby="weekHelp" placeholder="Tomato Week" value="'.$this->defaultWeekNumber.'">
      <small id="weekHelp" class="form-text text-muted">Automatically created by default.</small>
    </div>';

         // URL
         echo'<div class="form-group">
         <label for="tomatoUrl_FormElement">URL</label>
         <input type="url" name="url" class="form-control" id="tomatoUrl_FormElement" aria-describedby="urlHelp" placeholder="Tomato URL">
         <small id="urlHelp" class="form-text text-muted">Nice but not necessary.</small>
       </div>';

    // Categories
    $this->categories();

    // Keywords
    echo '<div class="form-group"><label for="tomatoKeywords_FormElement">Keywords</label><br/>';
    ?>
    <div id="ajaxKeywords"></div>
    <?PHP
    echo '</div>';


    // Submit
       echo ' <div class="form-group">
       <button type="submit" class="btn btn-primary mb-2">Submit</button>
       </div>';
       echo '</form>';
       print('<br/><br/>');
    }

        function upload_tomato_with_keyword_array($userid,$title,$tomdate,$tomweek,$count,$category,$notes,$url, $keywords){
            $this->datestring();
            $stmt = $this->conn->prepare("INSERT INTO `tomato220`.`tomato` (
                `tomato`.`id`,
                `tomato`.`userid`,
                `tomato`.`title`,
                `tomato`.`tomdate`,
                `tomato`.`datestring`,
                `tomato`.`tomweek`,
                `tomato`.`count`,
                `tomato`.`category`,
                `tomato`.`notes`,
                `tomato`.`URL`,
                `tomato`.`timestamp`
                )VALUES (
                    NULL,
                    :userid,
                    :title,
                    :tomdate,
                    :datestring,
                    :week,
                    :count,
                    :category,
                    :notes,
                    :URL,
                    CURRENT_TIMESTAMP
                    )");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':tomdate', $tomdate, PDO::PARAM_STR);
            $stmt->bindParam(':datestring', $this->datestring, PDO::PARAM_STR);
            $stmt->bindParam(':week', $tomweek, PDO::PARAM_STR);
            $stmt->bindParam(':count', $count, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
            $stmt->bindParam(':URL', $url, PDO::PARAM_STR);
            $stmt->execute();
            $last_id = $this->conn->lastInsertId();
            $tomid=$last_id;
            $pdo = null;
            // now upload keywords array
            $stmt = $this->conn->prepare("INSERT INTO `tomato220`.`link_tom_to_keywords` (`link_tom_to_keywords`.`id`, `link_tom_to_keywords`.`userid`, `link_tom_to_keywords`.`tom_id`, `link_tom_to_keywords`.`keyword_id`, `link_tom_to_keywords`.`timestamp`) VALUES (NULL, :userid, :tomid, :keywordid, CURRENT_TIMESTAMP)");
            $keywords_for_tomato = sizeof($keywords);
            for($i=0; $i < $keywords_for_tomato; $i++ ){
                $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
                $stmt->bindParam(':tomid', $tomid, PDO::PARAM_INT);
                $stmt->bindParam(':keywordid', $keywords[$i], PDO::PARAM_INT);
                $stmt->execute();
            }
            return $tomid;
        }

        function categories(){  
            print('<div class="form-group">');
            print('<label for="categories">Categories</label>');
            print('<select class="form-control" name="category" id="category" onchange="showKeywords(this.value)">');
            print("<option value='22'>NULL</option>");
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
            $sth->execute();
            $table = $sth->fetchAll();
            // add a selected class if the category has been selected and make black background
            foreach($table as $value){
                if(isset($_GET['category'])){
                    if($_GET['category']==$value['category']){
                        $this->selected="selected";
                        $this->category=$value['category'];
                        $this->cat_id=$value['id'];
    
                    }else{
                        $this->selected="not_selected";
                    }
                }else{
                    $this->selected="not_selected";
                }
            print("<option value='".$value['id']."'>".$value['category']."</option>");
            }
           print('</select></div>');
       }
    
       function submit(){
           print("<input type='submit'>");
       }

        function keywords($category_param=1){   
            if($category_param){
                $this->category=$category_param;
            }else{
                $this->category=1;
            }
            $sth = $this->conn->prepare("SELECT tomato220.keywords.keyword AS keyword, tomato220.keywords.id AS id 
                    FROM tomato220.link_cat_to_keywords 
                    JOIN tomato220.keywords 
                    ON tomato220.link_cat_to_keywords.keyword_id = tomato220.keywords.id
                    WHERE tomato220.link_cat_to_keywords.cat_id = ".$this->category." ORDER BY `keywords`.`keyword` ASC");
                $sth->execute();
                $table = $sth->fetchAll();
                foreach($table as $value){
                    print('<div class="form-check">
                    <input class="form-check-input" name="keywords[]" type="checkbox" value="'.$value['id'].'" id="'.$value['id'].'">
                    <label class="form-check-label" for="'.$value['id'].'">
                    '.$value['keyword'].'</label>
                </div>');  
                }
        }
    }
?>