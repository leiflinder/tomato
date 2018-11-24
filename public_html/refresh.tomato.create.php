<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.add.php');
$tomato_add_object = new addtomato;
if(isset($_POST['tomato_submit'])){
    $userid=$_POST['userid'];
    $title=$_POST['title'];
    $date=$_POST['date'];
    $week=$_POST['week'];
    $count=$_POST['count'];
    $category=$_POST['categories'];
    $notes=$_POST['notes'];
    $url=$_POST['url'];
        if(!(isset($_POST['keywords']))){
            $keywords = array();
        }else{
            $keywords = $_POST['keywords']; 
        }
    //print('<p>Tomato Submitted</p>');
    $created_tomato_id = $tomato_add_object->upload_tomato_with_keyword_array(
        $userid,
        $title,
        $date,
        $week,
        $count,
        $category,
        $notes,
        $url,
        $keywords);
}
/*
print('<p>Created Tomato ID: '.$created_tomato_id.'</p>');
$single_tomato =  new showtomatoes;
$test = $single_tomato->show_tomato_by_tomid($created_tomato_id);
*/
/*
print('<table class="table table-sm">');
print('<tr><td>ID:</td><td>'.$test['id'].'</td></tr>');
print('<tr><td>USER ID:</td><td>'.$test['userid'].'</td></tr>');
print('<tr><td>TOMDATE:</td><td>'.$test['tomdate'].'</td></tr>');
print('<tr><td>TOMWEEK:</td><td>'.$test['tomweek'].'</td></tr>');
print('<tr><td>COUNT:</td><td>'.$test['count'].'</td></tr>');
print('<tr><td>NOTES:</td><td>'.$test['notes'].'</td></tr>');
print('<tr><td>URL:</td><td>'.$test['URL'].'</td></tr>');
print('<tr><td>TIMESTAMP:</td><td>'.$test['timestamp'].'</td></tr>');
print('</table>');
*/
header("Location: home.php?newkeyid=$created_tomato_id");
?>