<?PHP session_start();
include ("../classes/config/class.conn.php");
include ('../classes/class.category.delete.php');
$delete = new categorydelete;

if(isset($_POST['catid'])){
    $categoryid = htmlspecialchars(strip_tags($_POST['catid']));
    $delete->replace_with_null($categoryid, $null=22, $_SESSION['userid']);
    $delete->delete_actual_category($categoryid, $_SESSION['userid']);
    $delete->delete_actual_goals($categoryid, $_SESSION['userid']);
    $message = "Category Deleted";
    $alert = "success";
    header("Location: home.php?page=categories&alert=$alert&message=$message");
}


?>