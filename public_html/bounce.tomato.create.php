<?php
include("../classes/config/class.conn.php");
include('../classes/class.tomato.create.php');
$tomato_add_object = new addtomato;
if (isset($_POST)) {
    if (isset($_POST['tomato_submit'])) {
        if (isset($_POST['userid'])) {
            if (filter_var($_POST['userid'], FILTER_VALIDATE_INT)===false) {
                $message="User ID not valid";
                $alert = "danger";
                header("Location: home.php?message=$message&alert=$alert");
            } else {
                $userid = $_POST['userid'];
                //  print('<p>'.$userid.'</p>');
            }
        }

        
        if (isset($_POST['title'])) {
            $title = $_POST['title'];
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            // print('<p>'.$title.'</p>' );
        }

        if (isset($_POST['date'])) {
            $date = $_POST['date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            // print('<p>'.$tomdate.'</p>' );
        }

        if (isset($_POST['week'])) {
            $week = $_POST['week'];
            $week = filter_var($week, FILTER_SANITIZE_STRING);
            //  print('<p>'.$tomweek.'</p>' );
        }

        if (isset($_POST['count'])) {
            if (filter_var($_POST['count'], FILTER_VALIDATE_INT)===false) {
                $message="Count Not integer";
                $alert = "danger";
                header("Location: home.php?message=$message&alert=$alert");
            } else {
                $count = $_POST['count'];
                // print('<p>'.$count.'</p>' );
            }
        }


        if (isset($_POST['category'])) {
            if (filter_var($_POST['category'], FILTER_VALIDATE_INT)===false) {
                $message="Category ID Not Valid";
                $alert = "danger";
                header("Location: home.php?message=$message&alert=$alert");
            } else {
                // print('<p>'.$new_category.'</p>' );
                $category = $_POST['category'];
            }
        }

        if (isset($_POST['notes'])) {
            $notes = $_POST['notes'];
            $notes = filter_var($notes, FILTER_SANITIZE_STRING);
            //  print('<p>'.$notes.'</p>' );
        }

        if (isset($_POST['url'])) {
            $url = $_POST['url'];
            $url = filter_var($url, FILTER_SANITIZE_STRING);
            //  print('<p>'.$url.'</p>' );
        }

        if (!(isset($_POST['keywords']))) {
            $keywords = array();
        } else {
            // $keywords = $_POST['keywords'];
            for ($i=0;$i<sizeof($_POST['keywords']);$i++) {
                $keyword[] = filter_var($_POST['keywords'][$i], FILTER_SANITIZE_STRING);
            }
        }

        $created_tomato_id = $tomato_add_object->upload_tomato_with_keyword_array(
            $userid,
            $title,
            $date,
            $week,
            $count,
            $category,
            $notes,
            $url,
            $keywords
        );
    }

    if ($created_tomato_id) {
        $message ="Tomato was created";
        $alert = "success";
    } else {
        $message ="Tomato was not created";
        $alert = "danger";
    }
    header("Location: home.php?page=tomato&message=$message&alert=$alert");
} else {
    $message ="There was a problem";
    $alert = "danger";
    header("Location: home.php?page=tomato&message=$message&alert=$alert");
}
