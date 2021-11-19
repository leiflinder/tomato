<?php

// https://thisinterestsme.com/php-timer-countdown/

//You must call the function session_start() before
//you attempt to work with sessions in PHP!
session_start();
 
//Check to see if our timer session variable
//has been set. If it hasn't been set, "initialize it".
if(!isset($_SESSION['timer'])){
    //Set the current timestamp.
    $_SESSION['timer'] = time();
}
 
//Get the current timestamp.
$now = time();
 
//Calculate how many seconds have passed.
$timeSince = $now - $_SESSION['timer'];
 
//Print out the result.
echo "$timeSince seconds have passed.";
?>

<div><a href="page02.php">Page 02</a></div>