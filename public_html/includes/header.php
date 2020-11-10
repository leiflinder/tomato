<!DOCTYPE html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->   
      <!-- bootstrap and jQuery -->  
      <title>Tomato221</title>
      <link rel="stylesheet" type="text/css" href="./styles/styles.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!-- endbuild -->
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <script>
function Populate_Description_Function() {
  var x = document.getElementById("tomatoTitle_FormElement").value;
  document.getElementById("tomatoDescription_FormElement").innerHTML = x;
}
</script>
<!--
   <script>
   function tomato_timer(){
      document.getElementById("tomato_timer_div");
      if(document.getElementById("tomato_timer_div").style.display === "none";
      ){
         document.getElementById("tomato_timer_div").style.display = "block";
         <?PHP $_SESSION['timer_window']="block"; ?>
      }else{
         document.getElementById("tomato_timer_div").style.display = "none";
         <?PHP $_SESSION['timer_window']="none"; ?>
      }
   }
   </script>
-->
   <body class="modal-open-noscroll" onload="updateCalendar(); setInterval('updateCalendar()', 1000 )">
   
   <div id="tomato_timer_div">Something</div>

<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-4"></div>
  <div class="col-sm-4">.col-sm-4</div>
</div>