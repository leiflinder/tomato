<footer>
    <p align="center">&copy;LinderCreative 2018</p>
</footer>
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
</script>