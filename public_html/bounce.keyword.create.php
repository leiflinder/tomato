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
           // print('<p>'.$keyword.'</p>' );
         }
    }

if($keyword && $userid){
    if($keyword_create->upload_new_keyword($new_keyword, $userid)==TRUE){
        $alart="sucess";
        $message="Keyword Created";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");
    }else{
        $alart="danger";
        $message="There Was A Problem";
        header("Location: home.php?page=keywords&message=$message&alert=$alert");      
    }
}else{
    $alart="danger";
    $message="There Was A Problem";
    header("Location: home.php?page=keywords&message=$message&alert=$alert");  
}
?>