<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.category.edit.php');

print('<pre>');
print_r($_POST);
print('</pre>');
/*
$keywordclass = new keywordedit;
if(isset($_POST)){
    if(isset($_POST) && isset($_POST['category'])){
        $categoryedit = htmlspecialchars(strip_tags($_POST['category']));
        $categoryid = htmlspecialchars(strip_tags($_POST['categoryid']));
        $return = $categoryclass->upload_edited_keyword($categoryid, $categoryedit);
        $alert = $return[0];
        $message = $return[1];
        header("Location: home.php?page=keywords&function=categoryshow&alert=$alert&message=$message");
    }
}
*/
?>