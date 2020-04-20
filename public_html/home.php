<?PHP session_start();
$_SESSION['userid']=1001;
date_default_timezone_set('Europe/Oslo');
error_reporting(E_ALL);
?>
<?php
include ("../classes/config/class.conn.php");
include ('../classes/class.pagemaster.php');
include ('../classes/class.user.login.php');
// include ('../classes/class.form_elements.php');
// include ('../classes/class.stats.php');
// include ('../classes/class.set_week.php');
// include ('../classes/class.keywords_and_categories.php');
// include ('../classes/class.keyword.aux.php');
include ('../classes/class.keyword.create.php');
include ('../classes/class.keyword.edit.php');
include ('../classes/class.keyword.delete.php');
include ('../classes/class.keyword.show.php');
include ('../classes/class.keyword.link_to_category.php');
// include ('../classes/class.keyword.link_category.php');
// include ('../classes/class.keyword.tree.php');
// include ('../classes/class.category.aux.php');
include ('../classes/class.category.create.php');
include ('../classes/class.category.edit.php');
include ('../classes/class.category.delete.php');
include ('../classes/class.category.show.php');
// include ('../classes/class.category.tree.php');
// include ('../classes/class.setup.aux.php');
// include ('../classes/class.setup.goals.php');
include ('../classes/class.goal.show.php');
// include ('../classes/class.tomato.aux.php');
//include ('../classes/class.tomato.add.php');
include ('../classes/class.tomato.create.php');
include ('../classes/class.tomato.edit.php');
include ('../classes/class.tomato.show.php');
// include ('../classes/class.view.aux.php');
// include ('../classes/class.view.today.php');
// include ('../classes/class.view.weeks.php');
include ('../classes/class.view.day.php');
include ('../classes/class.view.week.php');

include ('./includes/header.php');
include ('./includes/navigation2.php');


print('<div id="content">'); // open content

$zombie = new pagemaster;
/* shorthand if isset else index */
$_GET['page'] = isset($_GET['page']) ? $_GET['page'] : 'index';
$zombie->pagefinder($_GET['page']);

function message(){
    if(isset($_GET['message'])&&(isset($_GET['alert']))){
        $message = filter_var($_GET['message'], FILTER_SANITIZE_STRING);
        $alert = filter_var($_GET['alert'], FILTER_SANITIZE_STRING);
        print('<div class="alert alert-'.$alert.'" role="alert">'.$message.'</div>');
    }
}

print('</div>'); // close content
?>
<?php
include('includes/footer.php');
?>