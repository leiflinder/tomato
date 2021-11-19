<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.delete.php');

$keywordclass = new keyworddelete;
if(isset($_POST)){
        /*
        print('<pre>');
        print_r($_POST);
        print('</pre>');
        */
        $delete_keyword = new  keyworddelete;
        $keyid = htmlspecialchars(strip_tags($_POST['keyid']));
        $delete_keyword->delete_tom_keyword_links($keyid);
        $return = $delete_keyword->delete_actual_keyword($keyid);
        $alert = $return[0];
        $message = $return[1];
        header("Location: home.php?page=keywords&function=keywordshow&alert=$alert&message=$message");
    }
?>