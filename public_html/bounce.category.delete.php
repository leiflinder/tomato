<?PHP session_start();
include ("../classes/config/class.conn.php");
include ('../classes/class.category.delete.php');
$delete = new categorydelete;

print('<pre>');
print_r($_POST);
print('</pre>');
$categoryid = $_POST['catid'];
print('<p>Replaced with NULL: '.$delete->replace_with_null($categoryid, $null=22, $_SESSION['userid']).'</p>');
print('<p>Categories Deleted: '.$delete->delete_actual_category($categoryid, $_SESSION['userid']).'</p>');
print('<p>Goals Deleted: '.$delete->delete_actual_goals($categoryid, $_SESSION['userid']).'</p>');

/*
$keywordclass = new keywordedit;
if(isset($_POST)){
    if(isset($_POST) && isset($_POST['category'])){
        $categoryedit = htmlspecialchars(strip_tags($_POST['category']));
        $categoryid = htmlspecialchars(strip_tags($_POST['categoryid']));
        $return = $categoryclass->upload_edited_keyword($categoryid, $categoryedit);
        $alert = $return[0];
        $message = $return[1];
        header("Location: home.php?page=keywords&function=categoryshow&alert=$alert&message=$message");
    }
}
*/
?>