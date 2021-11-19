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
     <small id="notesHelp" class="form-text text-muted">Write a lot of notes.</small>
   </div>
</td></tr>
</form>
</table>
<p id="demo"></p>

<script>
function myFunction() {
  var x = document.getElementById("myInput").value;
  document.getElementById("demo").innerHTML = "You wrote: " + x;
}
</script>

</body>
</html>

  
