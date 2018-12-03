<?php
$clean = array();

if(isset($_GET['page'])){
    $get = $_GET['page'];
    $clean['get'] = $get;
}else{
	$clean['get'] = 'index';
}

if(isset($_GET['category'])){
    $category = $_GET['category'];
    $clean['category'] = $category;
}else{
	$clean['category'] = 1;
}

if(isset($_GET['sub_category'])){
    $sub_category = $_GET['sub_category'];
    $clean['sub_category'] = $sub_category;
}else{
	$clean['sub_category'] = NULL;
}

?>