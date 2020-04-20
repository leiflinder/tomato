<?php
include ("../classes/config/class.conn.php");
// include ('../classes/class.form_elements.php');
include ('../classes/class.tomato.create.php');
$form_elements_object = new addtomato;
// get all keywords associated with category
// and create a lot of check boxes
$catid = htmlspecialchars(strip_tags($_GET['categoryid']));
$form_elements_object->keywords($catid);
?>