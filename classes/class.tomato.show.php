<?php
class showtomatoes extends conn
{
    public $jobsearch_day_hours = 0;
    public $jobsearch_goal_div_class = 'Undefined';
    private $defaultWeekNumber;
    private $daynumber = array(1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday');
    
    public function job_search_daily_goal(){
        $today = date("Y-m-d");
        $sth = $this->conn->prepare("SELECT sum(count) FROM `tomato220`.`tomato` WHERE `tomato`.`tomdate` = '".$today."' AND `category` = 14");
        $sth->execute();
        if($resource = $sth->fetchColumn()){
            $resource = $resource*.5;
            if($resource > 4.9){
                $this->jobsearch_day_hours = $resource;
                $this->jobsearch_goal_div_class = "jobsearch_success";
            }else{
                $this->jobsearch_day_hours = $resource;
                $this->jobsearch_goal_div_class = "jobsearch_not_yet";
            }
        }    
    }

    public function default_week_setting()
    {
        $currentWeekNumber = date('Y') . "-W" . date('W');
        $this->defaultWeekNumber = $currentWeekNumber;
    }

    public function todaydate()
    {
        return date("Y-m-d");
    }

    public function pull_tomatos_this_week()
    {
        $this->default_week_setting();
        $sth = $this->conn->prepare("SELECT distinct(`tomato`.`datestring`) FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :TOMWEEK ORDER BY(`tomato`.`datestring`) DESC");
        $sth->bindParam(':TOMWEEK', $this->defaultWeekNumber);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $size = sizeof($resource);
        for ($i = 0; $i < $size; $i++) {
            print('<p>'.date('l \t\h\e jS', strtotime($resource[$i]['datestring'])) .' </p>');
            $this->toms_with_same_tomdate($resource[$i]['datestring']);
        }
    }
    private function toms_with_same_tomdate($tomdate){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`datestring` LIKE :TOMDATE");
        $sth->bindParam(':TOMDATE', $tomdate);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $size = sizeof($resource);
        /*
        print('<pre>');
        print_r($resource);
        print('</pre>');
        */
        print('<ul class="list-group tomatolist">');
        for ($i = 0; $i < $size; $i++) {
            print('<li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="home.php?page=tomatoedit&tomid='.$resource[$i]['id'].'" role="button" 
            aria-expanded="false" aria-controls="collapseExample"><div class="titleBox">'.$resource[$i]['title'].'</div></a>'.$this->return_category_name_from_catid($resource[$i]['category']).'<span class="badge badge-primary badge-pill">' . ($resource[$i]['count'] / 2).' hrs</span></li>');
        }
        print('</ul>');
    }


    public function get_keywords_for_tom_id($tom_id)
    {
        $sth = $this->conn->prepare("SELECT tomato220.keywords.keyword 
        AS 'keyword'
        FROM  tomato220.link_tom_to_keywords
        JOIN tomato220.keywords
        ON tomato220.link_tom_to_keywords.keyword_id = tomato220.keywords.id
        WHERE tomato220.link_tom_to_keywords.tom_id= ".$tom_id."");
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function show_keywords_by_link_id($dbase_resource)
    {
        $return_string="";
        for ($i=0; $i < sizeof($dbase_resource); $i++) {
            $return_string = $return_string.($dbase_resource[$i]['keyword']).'<br/>';
        }
        return $return_string;
    }


    public function show_tomato_by_tomid($tom_id=1)
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` =:id");
        $sth->bindParam(':id', $tom_id, PDO::PARAM_INT);
        $sth->execute();
        $value = $sth->fetch(PDO::FETCH_ASSOC);
        return $value;
    }

    public function query_table_for_tomdate_today()
    {
        $sth = $this->conn->prepare("SELECT tomato220.tomato.title AS 'title', tomato220.category.category, tomato220.tomato.count, tomato220.tomato.notes, tomato220.tomato.id AS 'tom_id', tomato220.tomato.timestamp
        FROM tomato220.category
        JOIN tomato220.tomato
        ON tomato220.category.id = tomato220.tomato.category
        WHERE tomato220.tomato.tomdate
        LIKE '".$this->todaydate()."%'");
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function return_category_name_from_catid($catid)
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`id` = :CATID ORDER BY `id` DESC");
        $sth->bindParam(':CATID', $catid);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $categorytitle = $resource[0]['category'];
        return $categorytitle;
    }
    public function return_single_tomato($tomid)
    {

        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    
        $resource_array['id'] = $resource[0]['id'];
        $resource_array['userid'] = $resource[0]['userid'];
        $resource_array['title'] = $resource[0]['title'];
        $resource_array['tomdate'] = $resource[0]['tomdate'];
        $resource_array['tomweek'] = $resource[0]['tomweek'];
        $resource_array['count'] = $resource[0]['count'];
        $resource_array['category_id'] = $resource[0]['category'];
        $resource_array['category_title'] = $this->return_category_name_by_catid($resource[0]['category']);
        $resource_array['notes'] = $resource[0]['notes'];
        $resource_array['url'] = $resource[0]['URL'];
    
        $resource_array['keywords'] = $this->return_keywords_on_tomid($resource[0]['id']);
        return $resource_array;
    }

    public function return_category_name_by_catid($catid)
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`id` = :CATID ORDER BY `id` DESC");
        $sth->bindParam(':CATID', $catid);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $categorytitle = $resource[0]['category'];
        return $categorytitle;
    }

    public function return_keywords_on_tomid($tomid)
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`tom_id` = :TOMID ORDER BY `link_tom_to_keywords`.`timestamp` DESC");
        $sth->bindParam(':TOMID', $tomid);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        return $resource;
    }

    private function get_toms_by_DOW_and_weekno($DOW, $weekno){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`weekdayno` = :WEEKDAYNO AND `tomato`.`tomweek` LIKE :TOMWEEK ORDER BY `id` DESC");
        $sth->bindParam(':TOMWEEK', $weekno);
        $sth->bindParam(':WEEKDAYNO', $DOW);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $size = sizeof($resource);
        print('<div class="days">');
        print('<table class="table">');
        for($i = 0; $i < $size; $i++) {
            $title = $resource[$i]['title'];
            $category = $resource[$i]['category'];
            $count = $resource[$i]['count'];
            $id = $resource[$i]['id'];
           print('<tr>');
          print('<td><span><a href="home.php?page=tomatoedit&tomid='.$id.'">'.$title.'</a></span></td>');
           print('<td class="category_td"><span>'.$this->return_category_name_by_catid($category).'</span></td>');
           print('<td class="tomcount_td"><span>'.$resource[$i]['count'].'</span></td>');
           print('</tr>');
        }
          $total_in_hours = .5*$this->day_totals($DOW, $weekno);
           print('<tr><td>&nbsp;</td><td class="category_td"><span>Hours</span></td><td class="tomcount_td"><span>'.$total_in_hours.'<span></td></tr>');
           print('</table>');
           print('</div>');   ;
    }

    public function show_days_of_week(){
        $this->default_week_setting();
        $size = sizeof($this->daynumber);
        for($i=1;$i<=$size;$i++){
            $daynumber = $this->daynumber[$i];
            $thisweek = $this->defaultWeekNumber;
            print('<h3>'.$daynumber.'</h3>');
            $this->get_toms_by_DOW_and_weekno($i, $thisweek);
        }
    }

    private function day_totals($DOW, $weekno){
        $sth = $this->conn->prepare("SELECT SUM(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`weekdayno` = :WEEKDAYNO AND `tomato`.`tomweek` LIKE :TOMWEEK");
        $sth->bindParam(':TOMWEEK', $weekno);
        $sth->bindParam(':WEEKDAYNO', $DOW);
        $sth->execute();
        $resource = $sth->fetch();
        return $resource[0];
    }

    private function today_totals($datestring){
        $sth = $this->conn->prepare("SELECT SUM(`tomato`.`count`) FROM `tomato220`.`tomato` WHERE `tomato`.`datestring` = :DATESTRING");
        $sth->bindParam(':DATESTRING', $datestring);
        $sth->execute();
        $resource = $sth->fetch();
        return $resource[0];
    }

    public function today_values(){
       // $datestring = $this->todaydate();
       $datestring = $this->todaydate();
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`datestring` LIKE :DATESTRING ORDER BY `id` DESC");
        $sth->bindParam(':DATESTRING', $datestring);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $size = sizeof($resource);
        // run seperate query to get total toms
        $totaltoms = $this->today_totals($datestring);
        print('<h3>Today '.$this->todaydate().'</h3>');
        print('<div class="days today_day">');
        print('<table class="table">');
        for($i = 0; $i < $size; $i++) {
            $title = $resource[$i]['title'];
            $category = $resource[$i]['category'];
            $count = $resource[$i]['count'];
            $id = $resource[$i]['id'];
           print('<tr>');
          print('<td><span><a href="home.php?page=tomatoedit&tomid='.$id.'">'.$title.'</a></span></td>');
           print('<td class="category_td"><span>'.$this->return_category_name_by_catid($category).'</span></td>');
           print('<td class="tomcount_td"><span>'.$resource[$i]['count'].'</span></td>');
           print('</tr>');
        }
            //$total_in_hours = .5*$this->day_totals($DOW, $weekno);
           $toms_in_hours = (.5)*($totaltoms);
           print('<tr><td>&nbsp;</td><td class="category_td"><span>Hours</span></td><td class="tomcount_td"><span>'.$toms_in_hours.'<span></td></tr>');
           print('</table>');
           print('</div>'); 
    }
}