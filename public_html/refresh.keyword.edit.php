<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.edit.php');

$keywordclass = new keywordedit;
if(isset($_POST)){
    if(isset($_POST['keywordedit']) && isset($_POST['keywordid'])){
        $keywordedit = htmlspecialchars(strip_tags($_POST['keywordedit']));
        $keywordid = htmlspecialchars(strip_tags($_POST['keywordid']));
        $return = $keywordclass->upload_edited_keyword($keywordid, $keywordedit);
        $alert = $return[0];
        $message = $return[1];
        header("Location: home.php?page=keywords&function=keywordshow&alert=$alert&message=$message");
    }
}
?>