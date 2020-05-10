<?PHP
SESSION_START();
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.create.php');
$keyword_create = new createKeyword;

if(isset($_SESSION['userid'])){
    if(filter_var($_SESSION['userid'], FILTER_VALIDATE_INT)===FALSE){
      $message="User ID not Valid. Try again.";
      $alert = "danger";
      header("Location: home.php?page=login&message=$message&alert=$alert");
    }else{
      $userid = $_SESSION['userid'];
    } 
}

if(isset($_POST)){
        if(isset($_POST['new_keyword'])){
            $keyword = $_POST['new_keyword'];
            $keyword = filter_var($keyword, FILTER_SANITIZE_STRING);
            //print('<p>'.$keyword.'</p>' );
         }
    }

if ($keyword && $userid) {
    // first check if keyword already exists
    if ($keyword_create->check_if_exists_keyword($keyword, $userid)==TRUE){
        /*
        $alert="danger";
        $message="Keyword already exists";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");
        */
        print('<p>Keyword already exists</p>');
        print('<p>Row Count: &nbsp;'.$keyword_create->check_if_exists_keyword($keyword, $userid).'</p>');
    } 
}

print('<p>Keyword already exists</p>');
print('<p>Row Count'.$keyword_create->check_if_exists_keyword($keyword, $userid).'</p>');
    /*
    // if it does not exist, create...
    if($keyword_create->create_keyword($keyword, $userid)==TRUE){
        $alert="success";
        $message="Keyword Created";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");
    }else{
        $alert="danger";
        $message="Problem with upload";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");      
    }
}else{
    $alart="danger";
    $message="Problem with values";
    header("Location: home.php?page=keywords&message=$message&alert=$alert");  
}
*/

print('<pre>');
print_r($_POST);
print('</pre>');
print('<pre>');
print_r($_SESSION);
print('</pre>'); 
 
?>