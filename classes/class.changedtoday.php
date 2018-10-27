<?PHP
class changed_today extends conn{

    function todaydate(){
        return date("Y-m-d");
    }  

    function worked_at_job_today(){
        $sth = $this->conn->prepare("SELECT *
        FROM lifebase.activity
        WHERE lifebase.activity.timestamp 
        LIKE '".$this->todaydate()."%'");
    $sth->execute();
    //$result = $sth->fetchAll();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $result_print = $result['activity']." today ".$result['hours']." Hours";
    return $result_print;
}


    // helper function: selects tables that changed today
    function query_table_for_tomdate_today(){
            $sth = $this->conn->prepare("SELECT tomato220.category.id, tomato220.category.category, tomato220.tomato.count, tomato220.tomato.notes, tomato220.tomato.id AS 'tom_id', tomato220.tomato.timestamp
            FROM tomato220.category
            JOIN tomato220.tomato
            ON tomato220.category.id = tomato220.tomato.category
            WHERE tomato220.tomato.tomdate
            LIKE '".$this->todaydate()."%'");

		$sth->execute();
		$result = $sth->fetchAll();
        //$result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
}
?>