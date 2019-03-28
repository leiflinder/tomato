<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.setup.goals.php');
//check_goal_if_changed($catid, $goal)
$goals_edit_object = new setupgoals;
if(isset($_POST['updategoals'])){
    /*
    [updategoals] => updategoals
    [Norsk] => 20
    [Code] => 10
    [Design] => 6
    [Guitar] => 6
    [Task] => 10
    [Study] => 2
    [Exercise] => 2
    [Job_Search] => 14
   */
    /*
    $tomid = $_POST['tomid'];
    $userid=$_POST['userid'];
    $title=$_POST['title'];
    $tomdate=$_POST['tomdate'];
    $tomcount=$_POST['count'];
    $categoryid=$_POST['categoryid'];
    $notes=$_POST['notes'];
    $url=$_POST['url'];
    */
    /*
    $tomato_edit_object->upload_edit_query($tomid, $title, $tomdate, $tomcount, $categoryid, $notes);
    */
// header("Location: home.php?page=tomato&function=tomatoedit&tomid=$tomid");
}

print('<pre>');
print_r($_POST);
print('</pre>');
?>