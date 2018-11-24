<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.category.create.php');
$category_add_object = new createCategory;
if(isset($_POST['category_submit'])){
        // $_SESSION['userid']
        //  $_POST['new_category']
        // $_POST['favorite']
    $new_category=$_POST['new_category'];
    $userid=$_POST['userid'];
    $favorite=$_POST['favorite'];
    $message = $category_add_object->upload_new_category($new_category, $userid=1001, $favorite);
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
header("Location: home.php?page=categories&function=categorycreate&message=$message");
?>