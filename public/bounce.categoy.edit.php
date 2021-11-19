<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.category.edit.php');
/*
print('<pre>');
print_r($_POST);
print('</pre>');
*/
        $categoryclass = new editCategory;
        $categoryedit = htmlspecialchars(strip_tags($_POST['categoryedit']));
        $categoryid = htmlspecialchars(strip_tags($_POST['categoryid']));
        $return = $categoryclass->upload_edited_category($categoryid, $categoryedit);
        $alert = $return[0];
        $message = $return[1];
        header("Location: home.php?page=categories&alert=$alert&message=$message");

?>