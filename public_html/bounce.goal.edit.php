<?PHP
SESSION_START();
include ("../classes/config/class.conn.php");
include ('../classes/class.goal.create.php');
include ('../classes/class.goal.show.php');
$create_goal = new goal_create;
$show_goal = new setupgoals;

$goal = $_POST['goal_week_value'];
$catname = $_POST['goal_title'];
$userid = $_SESSION['userid'];
$catid = $create_goal->get_catid_by_catname($catname);

$create_goal->delete_and_then_create($goal, $catname, $userid, $active=1, $timeperiod="week");
$message ="Goal was changed";
$alert = "success";
/*
    print('<p>'.$create_goal->goal.'</p>');
    print('<p>'.$create_goal->catname.'</p>');
    print('<p>'.$create_goal->userid.'</p>');
    print('<p>'.$create_goal->active.'</p>');
*/
  header("Location: home.php?message=$message&alert=$alert");

?>