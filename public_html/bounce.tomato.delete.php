<?PHP session_start();
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.delete.php');
$delete = new deletetomato;

print('<pre>');
print_r($_POST);
print('</pre>');

?>