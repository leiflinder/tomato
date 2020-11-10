<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.edit.php');
$edit_tomato = new edittomato;

if(isset($_POST['tomid'])){
  if(filter_var($_POST['tomid'], FILTER_VALIDATE_INT)===FALSE){
    $message="Tomato ID not valid";
    $alert = "danger";
    header("Location: home.php?message=$message&alert=$alert");
  }else{
    $tomid = $_POST['tomid'];
  }
}

if(isset($_POST['userid'])){
    if(filter_var($_POST['userid'], FILTER_VALIDATE_INT)===FALSE){
      $message="User ID not valid";
      $alert = "danger";
      header("Location: home.php?message=$message&alert=$alert");
    }else{
      $userid = $_POST['userid'];
    }  
}

  if(isset($_POST['old_category_id'])){
    if(filter_var($_POST['old_category_id'], FILTER_VALIDATE_INT)===FALSE){
      $message="Previous Category Not Valid";
      $alert = "danger";
      header("Location: home.php?message=$message&alert=$alert");
    }else{
      $old_category_id = $_POST['old_category_id'];
    } 
}


  //  ****  Start changing things  ***** //

if(isset($_POST['title'])){
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $edit_tomato->update_title($tomid, $userid, $title);
}

if(isset($_POST['tomdate'])){
  $tomdate = $_POST['tomdate'];
  $tomdate = filter_var($tomdate, FILTER_SANITIZE_STRING);
   $edit_tomato->update_tomdate($tomid, $userid, $tomdate);
   // update both 'tomadate' and 'datestring'
   $edit_tomato->update_datestring($tomid, $userid, $tomdate);
}

if(isset($_POST['tomweek'])){
   $tomweek = $_POST['tomweek'];
   $tomweek = filter_var($tomweek, FILTER_SANITIZE_STRING);
    $edit_tomato->update_tomweek($tomid, $userid, $tomweek);
}

if(isset($_POST['count'])){
    if(filter_var($_POST['count'], FILTER_VALIDATE_INT)===FALSE){
      $message="Count Not integer";
      $alert = "danger";
      header("Location: home.php?message=$message&alert=$alert");
    }else{
      $count = $_POST['count'];
      $edit_tomato->update_count($tomid, $userid, $count);
    }
}

if(isset($_POST['notes'])){
  $notes = $_POST['notes'];
  $notes = filter_var($notes, FILTER_SANITIZE_STRING);
  $edit_tomato->update_notes($tomid, $userid, $notes);
}

if(isset($_POST['url'])){
  $url = $_POST['url'];
  $url = filter_var($url, FILTER_SANITIZE_STRING);
  $edit_tomato->update_url($tomid, $userid, $url);
}

if(isset($_POST['new_category'])){
        if($_POST['new_category']==22){
        // do nothing
        }else{
            if(filter_var($_POST['new_category'], FILTER_VALIDATE_INT)===FALSE){
              $message="New Category ID Not Valid";
              $alert = "danger";
             header("Location: home.php?message=$message&alert=$alert");
            }else{
              $new_category = $_POST['new_category'];
              $edit_tomato->update_new_category($tomid, $userid, $new_category);
            } 
        }
    }else{
    // do nothing, keep old category
}
 
if(isset($_POST['keywords'])){
    for($i=0;$i<sizeof($_POST['keywords']);$i++){
      $keywords[] = filter_var($_POST['keywords'][$i], FILTER_SANITIZE_STRING);
    }
        $edit_tomato->update_keywords($tomid, $userid, $keywords);
    }else{
       // do nothing
}
 header("Location: home.php?page=tomato&message=$message&alert=$alert");
 
// print('<pre>');
// print_r($_POST);
// print('</pre>');
?>


