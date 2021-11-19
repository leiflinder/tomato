<!DOCTYPE html>
<html>
<body>

<p>Write something in the text field to trigger a function.</p>

<input type="text" id="myInput" oninput="myFunction()">

<table>
<form>
<tr><td>
<div class="form-group">
    <label for="tomatoDescription_FormElement">Notes</label>
     <textarea name="notes" class="form-control" id="tomatoDescription_FormElement" placeholder="Notes" rows="3"></textarea>
   </div>
</td></tr>
</form>
</table>


<script>
function myFunction() {
  var x = document.getElementById("myInput").value;
  document.getElementById("tomatoDescription_FormElement").innerHTML = x;
}
</script>

</body>
</html>

  
