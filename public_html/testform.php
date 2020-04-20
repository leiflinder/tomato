<style>
    body {
        background:#ccc;
        font-family:sans-serif;
    }
    table td, input {
        padding:5px;
    }
    table {
        border-collapse: collapse;
    }
    p {
        padding:3px;
        background:white;
        margin:9px 3px;
        border:solid 1px #999;
    }
</style>
<body>
<br/>
<table style="display:block; width:700px; margin:0px auto;">
   <!-- <form method="post" action="bounce.tomato.edit.php"> -->
    <form method="post" action="bounce.tomato.create.php">
    <tr><td>Tom ID</td><td><input type="text" name="tomid"></td></tr>
    <tr><td>User ID</td><td><input type="text" name="userid"></td></tr>
    <tr><td>Old Cat ID</td><td><input type="text" name="old_category_id"></td></tr>
    <tr><td>Title</td><td><input type="text" name="title"></td></tr>
    <tr><td>Tom Date</td><td><input type="text" value="2020-04-11" name="tomdate"></td></tr>
   <tr><td>Tom Week</td><td><input type="text" value="2020-W15" name="tomweek"></td></tr>
    <tr><td>Tom Count</td><td><input type="text" name="count"></td></tr>
    <tr><td>Notes</td><td><textarea name="notes" rows="3" cols="21"></textarea></td></tr>
    <tr><td>URL</td><td><input type="text" name="url"></td></tr>
    <tr><td>New Category</td><td><input type="text" name="new_category"></td></tr>
    <tr><td valign="top">Keywords</td><td>
       <p>Text1 <input type="checkbox" name="keywords[]" value="text1"></p>
       <p>Text2 <input type="checkbox" name="keywords[]" value="text2"></p>
       <p>Text3 <input type="checkbox" name="keywords[]" value="<p>text3</p>"></p>
       <p>Text4 <input type="checkbox" name="keywords[]" value="text4"></p>
       <p>Text5 <input type="checkbox" name="keywords[]" value="text5"></p>
    </td></tr>
    <tr><td colspan="2"><input type="submit" value="submit"></td></tr>
</form>
</table>
</body>
