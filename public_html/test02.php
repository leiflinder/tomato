<?php
print('<pre>');
print_r($_POST);
print('</pre>');
?>

<?php
if("" == trim($_POST['back_date'])){
    $date = $_POST['machine_date'];
}else{
    $date = $_POST['back_date'];
}

print('<h2>'.$date.'</h2>');
?>