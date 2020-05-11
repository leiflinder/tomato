<table border=1>
    <form method=GET action=""/>
    <tr><input type="text" value="<script> now(); </script>"/><td>Javascript Now</td><td></td></tr>
    <tr><input type="text" value="<?PHP NOW(); ?>"/><td>PHP Now</td><td></td></tr>
    <tr><td colspan="2">PHP Now</td></tr>
</form>
</table>

<?php
echo date("m-d-Y",$_SERVER['REQUEST_TIME']);
print('<br/>');
echo date("Y-m-d",$_SERVER['REQUEST_TIME']);
?>
