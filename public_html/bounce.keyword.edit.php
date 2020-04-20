<?php
SESSION_START();
include("../classes/config/class.conn.php");
include("../classes/class.keyword.edit.php");
/*
print('<pre>');
print_r($_POST);
print('</pre>');
print('<hr>');
print('<pre>');
print_r($_SESSION);
print('</pre>');
*/

if(isset($_SESSION['userid'])){
 $userid = $_SESSION['userid'];
}else{
    $alert="warning";
    $message = "Please log in";
    header("Location: home.php?page=index&alert=$alert&message=$message");   
}
$keywordclass = new keywordedit;
if (isset($_POST)) {
    if (isset($_POST['keywordedit']) && isset($_POST['keywordid'])) {
        $keywordedit = htmlspecialchars(strip_tags($_POST['keywordedit']));
        $keywordid = htmlspecialchars(strip_tags($_POST['keywordid']));
        $return = $keywordclass->upload_edited_keyword($keywordid, $keywordedit, $userid);
            if ($return == true) {
                $alert="success";
                $message = "Keyword edited";
                header("Location: home.php?page=keywords&alert=$alert&message=$message");
            }else{
                $alert="danger";
                $message = "Keyword not edited";
                header("Location: home.php?page=keywords&alert=$alert&message=$message");
            }
        } else {
            $alert="danger";
            $message = "No Keyword Supplied";
            header("Location: home.php?page=keywords&alert=$alert&message=$message");
        }
    }

