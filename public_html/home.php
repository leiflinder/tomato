<?php
	require_once("./includes/session.php");
	require_once("../classes/class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php
include("./includes/clean.php");
include ("../classes/config/class.conn.php");
include ("../classes/class.clean.php");
include ('../classes/class.changedtoday.php');
include ('../classes/class.tomato.show.php');
include ('../classes/class.pagemaster.php');
include ('../classes/class.form_elements.php');
include ('../classes/class.upload.php');
include ('../classes/class.set_week.php');
include ('../classes/class.keywords_and_categories.php');
include ('../classes/class.keyword.create.php');
include ('../classes/class.keyword.edit.php');
include ('../classes/class.keyword.show.php');
include ('../classes/class.keyword.delete.php');
include ('../classes/class.keyword.link_to_category.php');
include ('../classes/class.category.create.php');
include ('../classes/class.category.show.php');
include ('../classes/class.category.edit.php');
include ('../classes/class.stats.php');
include ('../classes/class.add.tomato.php');

include('./includes/header.php');
include ('./includes/navigation.php');

print('<div id="content">'); // open content

$zombie = new pagemaster;
$zombie->pagefinder($clean['get']);

print('</div>'); // close content
?>
<?php
include('includes/footer.php');
?>