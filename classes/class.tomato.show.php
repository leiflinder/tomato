<?php
class showtomatoes extends conn
{
    public function todaydate()
    {
        return date("Y-m-d");
    }

    private function toms_by_tomdate($tomdate)
    {
        /*
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomdate` LIKE :TOMDATE");
        */
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`datestring` LIKE :TOMDATE");

        $sth->bindParam(':TOMDATE', $tomdate);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        $size = sizeof($resource);
       // print('<pre>Something');
       // print_r($resource);
      //  print('</pre>');
        
        print('<ul class="list-group tomatolist">');
        for ($i = 0; $i < $size; $i++) {
            print('<li class="list-group-item d-flex justify-content-between align-items-center border-0"><a data-toggle="collapse" href="#collapseExample'.$resource[$i]['id'].'" role="button" 
            aria-expanded="false" aria-controls="collapseExample"><div class="titleBox">'.$resource[$i]['title'].'</div></a>'.$this->return_category_name_from_catid($resource[$i]['category']).'<span class="badge badge-primary badge-pill">' . ($resource[$i]['count'] / 2).' hrs</span></li>
        <div class="collapse margin-bottom" id="collapseExample'.$resource[$i]['id'].'">
        <div class="card card-body">');
            $tomato = $this->return_single_tomato_based_on_tomid($resource[$i]['id']);
            $this->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
        print('</div>');
      print('</div>');
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
}
