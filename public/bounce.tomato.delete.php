<?PHP session_start();
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.delete.php');
$delete = new deletetomato;

print('<pre>');
print_r($_POST);
print('</pre>');


if (isset($_POST['tomatoid'])) {
    $tomatoid = $_POST['tomatoid'];
    $int = (int)$_POST['tomatoid'];
    print('<p>POST tomato id '.$tomatoid.'</p>');
    print('<p>POST tomato id as INT '.$int.'</p>');

    /*
    if (isset($_POST['tomatoid'])) {
        $tomatoid = (int)$_POST['tomatoid'];
        if ($delete->delete_tomato($tomatoid)>1) {
            $alert="success";
            $message="Tomato deleted";
            header("Location: home.php?page=tomato&message=$message&alert=$alert");
        } else {
            $alert="danger";
            $message="Query not successful";
            header("Location: home.php?page=tomato&message=$message&alert=$alert");
        }
        $alert="danger";
        $message="No tomato ID supplied";
        header("Location: home.php?page=tomato&message=$message&alert=$alert");
        */
    } else {
        print('<p>No tomatoid </p>');
       // $alert="danger";
       // $message="No POST variable supplied";
      //  header("Location: home.php?page=tomato&message=$message&alert=$alert");
    }
?>