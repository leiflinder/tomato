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
               // print('<p>'.$userid.'</p>');
            }
        }

        
        if (isset($_POST['title'])) {
            $title = $_POST['title'];
            $title = filter_var($title, FILTER_SANITIZE_STRING);
          //  print('<p>'.$title.'</p>');
        }



        // machanism to use default javascript date or manually set date in past
        if("" == trim($_POST['back_date'])){
            $date = $_POST['machine_date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);
        }else{
            $date = $_POST['back_date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            // if date in past, change week number!!!
            $ddate = $date;
            // backdate year
            $backdateYear = substr($ddate, 0, -6); 
            $dateObject = new DateTime($ddate);
            // build up tomweek value
            $_POST['week'] = $backdateYear."-W".$dateObject->format("W");
        }


        if (isset($_POST['week'])) {
            $week = $_POST['week'];
            $week = filter_var($week, FILTER_SANITIZE_STRING);
          //  print('<p>'.$tomweek.'</p>');
        }

        if (isset($_POST['count'])) {
            if (filter_var($_POST['count'], FILTER_VALIDATE_INT)===false) {
                $message="Count Not integer";
                $alert = "danger";
                header("Location: home.php?message=$message&alert=$alert");
            } else {
                $count = $_POST['count'];
              //  print('<p>'.$count.'</p>');
            }
        }


        if (isset($_POST['category'])) {
            if (filter_var($_POST['category'], FILTER_VALIDATE_INT)===false) {
                $message="Category ID Not Valid";
                $alert = "danger";
                header("Location: home.php?message=$message&alert=$alert");
            } else {
               // print('<p>'.$new_category.'</p>');
                $category = $_POST['category'];
            }
        }

        if (isset($_POST['notes'])) {
            $notes = $_POST['notes'];
            $notes = filter_var($notes, FILTER_SANITIZE_STRING);
          //  print('<p>'.$notes.'</p>');
        }

        if (isset($_POST['url'])) {
            $url = $_POST['url'];
            $url = filter_var($url, FILTER_SANITIZE_STRING);
           // print('<p>'.$url.'</p>');
        }

        
        if (!(isset($_POST['keywords']))) {
            $keywords = array();
        } else {
            // $keywords = $_POST['keywords'];
            for ($i=0;$i<sizeof($_POST['keywords']);$i++) {
                if (filter_var($_POST['keywords'][$i], FILTER_VALIDATE_INT)) {
                    $keywords[] = filter_var($_POST['keywords'][$i]);
                } else {
                    // if the value is not an integer set to NULL
                    $keywords[] = 157;
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
      //  header("Location: home.php?page=tomato&message=$message&alert=$alert");
    } else {
        $message ="There was a problem";
        $alert = "danger";
      //  header("Location: home.php?page=tomato&message=$message&alert=$alert");
    }

}

$split_date = explode('-', $date);
print('<pre>');
print_r($split_date);
print('</pre>');
// $formate_date = $_POST['machine_date'];
// $isodate = sprintf("%04d-%02d-%02d", $year, $month, $day);
print('<p>Date: '.$split_date[0].'</p>');
print('<p>Month: '.$split_date[1].'</p>');
print('<p>Year: '.$split_date[2].'</p>');
$date_string = sprintf("%04d-%02d-%02d", $split_date[0], $split_date[1], $split_date[2]);
print('<h2>Spintf Date: '.$date_string.'</h2>');

print('<pre>');
print_r($_POST);
print('</pre>');
?>