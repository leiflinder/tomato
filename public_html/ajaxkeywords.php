<?php
include ("../classes/config/class.conn.php");
// include ('../classes/class.form_elements.php');
include ('../classes/class.tomato.add.php');
$form_elements_object = new addtomato;
// get all keywords associated with category
// and create a lot of check boxes
$form_elements_object->keywords($_GET['categoryid']);
?>