<?php
class showtomatoes extends conn
{
    private $defaultWeekNumber;
    
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
            /*
            print('<p class="no-padding">' . date('l \t\h\e jS', strtotime($resource[$i]['tomdate'])) . '</p>');
            $this->toms_by_tomdate($resource[$i]['tomdate']);
            */
            print('<p>'.date('l \t\h\e jS', strtotime($resource[$i]['datestring'])) .' </p>');
            $this->toms_with_same_tomdate($resource[$i]['datestring']);
        }
    }
    private function toms_with_same_tomdate($tomdate)
    {

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
}