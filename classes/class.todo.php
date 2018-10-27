<?PHP
class todo_all_for_tomato220 extends conn{


    // helper function: selects tables changed today
    function get_all_todos(){
        $sth = $this->conn->prepare("SELECT * FROM `lindercreative`.`siteupdates` WHERE `siteupdates`.`site` = 'tomato220' ORDER BY  `siteupdates`.`complete` ASC, `siteupdates`.`date` DESC;");
		$sth->execute();
		$result = $sth->fetchAll();
       // $result = $sth->fetch(PDO::FETCH_ASSOC);
       if(isset($result)){
           foreach($result as $key => $value){
               print('<tr>');
               print('<td>'.$value['date'].'</td>');
               print('<td>'.$value['updatetitle'].'</td>');
               print('<td>'.$value['siteupdate'].'</td>');
               print('<td>'.$value['complete'].'</td>');
               print('<td>'.$value['donedate'].'</td>');
               print('</tr>');
           }

       }
    }

    
}
?>