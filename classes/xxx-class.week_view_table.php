<?php
class week_view_table extends conn

	{
	/*
	*/
   public $table_name_property;
   public $week_start_propery;
   public $week_end_propery;
   public $week_total;



    function week_view_table($table_name, $week_start, $week_end){
		$sth = $this->conn->prepare("SELECT * FROM `".$table_name."` WHERE `timestamp` BETWEEN '".$week_start."%' AND '".$week_end."%' ORDER BY `id` DESC");
		$sth->execute();
		$table = $sth->fetchAll();
        foreach($table as $value){
        print('<p>'.$value['tablename'].' '.$value['tomato'].' '.$value['value'].'</p>');
        }
       // return $table;
    }

    function week_view_table_sum($table_name, $week_start, $week_end){
        $sth = $this->conn->prepare("SELECT sum(tomato*.5) AS 'tomsum' FROM `norwegian` WHERE `timestamp` BETWEEN '2017-11-27' AND '2017-12-03'");
        $sth->execute();
        $table = $sth->fetchAll();
        foreach($table as $value){
        print('<p>'.$value['tomsum'].'</p>');
        }
       // return $table;
    }

   // SELECT sum(tomato*.5) FROM `norwegian` WHERE `timestamp` BETWEEN '2017-11-27' AND '2017-12-03'
 


}