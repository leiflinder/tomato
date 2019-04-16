
<!DOCTYPE html>
<html ng-app="app" lang="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head 
         content must come *after* these tags -->   
<!-- bootstrap and jQuery -->


    
    <title>Tomato220 Time Managment Software</title>

    <link rel="stylesheet" type="text/css" href="./styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- endbuild -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="modal-open-noscroll">

   <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=tomato&function=tomatalanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tomato
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoshow">Show</a>
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoadd">Add</a>
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoedit">Edit</a>
                        </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=keywords&function=keywordlanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Keywords
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordshow">Show</a> 
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordcreate">Add</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordedit">Edit</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keyworddelete">Delete</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordtree">Keyword Tree</a>
                         </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=category&function=categorylanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
        <a class="dropdown-item" href="home.php?page=categories&function=categorycreate">Category Create</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorydedit">Category Edit</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorydelete">Category Delete</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorytree">Category Tree</a>
                 </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=views&function=viewslanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Views
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
        <a class="dropdown-item" href="home.php?page=views&function=viewtoday">Today</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewyesterday">Yesterday</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewweeks">Weeks</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewcomparisons">Comparisons</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewcustomviews">Custom Views</a>
                 </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=setup&function=setuplanding"" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Set Up
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
        <a class="dropdown-item" href="home.php?page=setup&function=setupweeklygoals">Weekly Goals</a>
        <a class="dropdown-item" href="home.php?page=setup&function=setupmonthgoals">Month Goals</a>
        <a class="dropdown-item" href="home.php?page=setup&function=setupcategorypriority">Category Priority</a>
                 </div>

      </li>
    </ul>
  </div>
</nav>
<br/>
<div id="content">



<h2>This Week</h2><p class="no-padding">Thursday the 11th</p><ul class="list-group tomatolist"><li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="?page=tomato&function=tomatoedit&tomid=1130"   data-target="#1130">Guitar</a><span class="badge badge-primary badge-pill">0.5 hrs</span></li><li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="?page=tomato&function=tomatoedit&tomid=1131"   data-target="#1131">Business</a><span class="badge badge-primary badge-pill">0.5 hrs</span></li><li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="?page=tomato&function=tomatoedit&tomid=1132"   data-target="#1132">Task</a><span class="badge badge-primary badge-pill">0.5 hrs</span></li></ul><p class="no-padding">Wednesday the 10th</p><ul class="list-group tomatolist"><li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="?page=tomato&function=tomatoedit&tomid=1129"   data-target="#1129">Code</a><span class="badge badge-primary badge-pill">5 hrs</span></li></ul><h3>Weekly Goals</h3><p>Code 10</p><p>Norsk 20</p><p>Study 2</p><p>Guitar 6</p><p>Task 10</p><p>Exercise 2</p><p>Drawing 0</p><p>Design 6</p><p>Job Search 14</p><p>Business 0</p><p>test205 0</p></div><footer>

</footer>


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