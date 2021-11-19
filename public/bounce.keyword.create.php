<?php
SESSION_START();
include("../classes/config/class.conn.php");
include('../classes/class.keyword.create.php');
$keyword_create = new createKeyword;

if (isset($_SESSION['userid'])) {
    if (filter_var($_SESSION['userid'], FILTER_VALIDATE_INT)===false) {
        $message="User ID not Valid. Try again.";
        $alert = "danger";
        header("Location: home.php?page=login&message=$message&alert=$alert");
    } else {
        $userid = $_SESSION['userid'];
    }
}

    if (isset($_POST['new_keyword'])) {
        $keyword = $_POST['new_keyword'];
        $keyword = filter_var($keyword, FILTER_SANITIZE_STRING);
    } else {
        $alert="danger";
        $message="No Keyword Value";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");
    }

if ($keyword && $userid) {
    if ($keyword_create->check_if_exists_keyword($keyword, $userid)>0) {
        //print('<h4>Keyword Exists</h4>');
        $alert="danger";
        $message="Keyword already exists";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");
    } else {
        if ($keyword_create->create_keyword($keyword, $userid)==1) {
            $alert="success";
            $message="Keyword Created";
            header("Location: home.php?page=keywords&message=$message&alert=$alert");
        } else {
            $alert="danger";
            $message="Problem with upload";
            header("Location: home.php?page=keywords&message=$message&alert=$alert");
        }
    }
} else {
    $alert="danger";
    $message="Problem with value";
    header("Location: home.php?page=keywords&message=$message&alert=$alert");
}
