<?PHP
SESSION_START();
include ("../classes/config/class.conn.php");
include ('../classes/class.goal.create.php');
include ('../classes/class.goal.show.php');
$create_goal = new goal_create;
$show_goal = new setupgoals;
/*
print('<pre>');
print_r($_POST);
print('</pre>');
*/
//print('<hr/>');
$goal = $_POST['goal_week_value'];
$catname = $_POST['goal_title'];
$userid = $_SESSION['userid'];
$catid = $create_goal->get_catid_by_catname($catname);
/*
print('<p>Goal: '.$goal.'</p>');
print('<p>Cat Name: '.$catname.'</p>');
print('<p>User ID: '.$userid.'</p>');
print('<p>Cat ID: '.$catid.'</p>');
*/
// $create_goal->create_goal($goal, $catname, $userid);

/*
$update = $show_goal->check_goal_if_changed($catid, $goal);
print('<p>Update = '.$update.'</p>');
if($update == 0){
  $create_goal->create_goal($goal, $catname, $userid);
  $message ="Goal Changed";
  $alert = "success";
}else{
  $message ="Goal not Changed";
  $alert = "secondary";
}
*/
$create_goal->delete_and_then_create($goal, $catname, $userid, $active=1, $timeperiod="week")
 // header("Location: home.php?message=$message&alert=$alert");

?>