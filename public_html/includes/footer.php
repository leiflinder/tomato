<footer>

</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>

<script>
function showKeywords(str) {
    if (str.length == 0) { 
        document.getElementById("ajaxKeywords").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajaxKeywords").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "ajaxkeywords.php?categoryid="+str, true);
        xmlhttp.send();
    }
}
function showKeywordsEdit(str, tomidkeywords=3) {
    if (str.length == 0) { 
        document.getElementById("ajaxKeywordsEdit").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajaxKeywordsEdit").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "ajax.tomato.edit.keywords.php?categoryid="+str, true);
        xmlhttp.send();
    }
}
</script>