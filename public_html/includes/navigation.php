<?PHP
if(isset($_GET['page'])){
  $_GET['page']=$_GET['page'];
}else{
  $_GET['page']='index';
}
switch ($_GET['page']) {
  case "home":
  $chosen_index="active";
  $chosen_addtomato="notactive";
  $chosen_view="notactive";
  $chosen_set="notactive";
  break;
	case "index":
		$chosen_index="active";
		$chosen_addtomato="notactive";
		$chosen_view="notactive";
    $chosen_set="notactive";
        break;
    case "addtomato":
		$chosen_index="notactive";
		$chosen_addtomato="active";
		$chosen_view="notactive";
    $chosen_set="notactive";
    break;
    case "setup":
		$chosen_index="notactive";
		$chosen_addtomato="notactive";
		$chosen_view="notactive";
    $chosen_set="active";
    break;
    case "view":
		$chosen_index="notactive";
		$chosen_addtomato="notactive";
		$chosen_view="active";
    $chosen_set="notactive";
    break;
    default:
		$chosen_index="active";
		$chosen_addtomato="notactive";
		$chosen_view="notactive";
		$chosen_set="notactive";
}
?>
	<style>
	#chosen{
		background-color:black;
	}
	#not_chosen{
		text-decoration: initial;
	}
	</style>





<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Home </a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">

          <!--
          <ul class="nav navbar-nav">
            <li class="<?php 	print($chosen_addtomato); ?>"><a href="home.php?page=addtomato">Add</a></li>
            <li class="<?php 	print($chosen_set); ?>"><a href="home.php?page=setup">Set Up</a></li>
          </ul>
          -->
          <ul class="nav navbar-nav navbar-left">     
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Page Functions<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li class="<?php 	print($chosen_addtomato); ?>"><a href="home.php?page=addtomato">Add</a></li>
              <li class="<?php 	print($chosen_set); ?>"><a href="home.php?page=setup">Set Up</a></li>
              <li><a href="home.php?page=stats">Stats</a></li>
              <li><a href="home.php?page=keywords">Keywords</a></li>
              <li><a href="home.php?page=tomatoshow">Show single tomato</a></li>
              <li><a href="home.php?page=linkkeywords">Now link Keywords</a></li>
              <li><a href="home.php?page=setup">Set Up</a></li> 
              <li><a href="home.php">Default</a></li>       
              </ul>
            </li>
          </ul>


          <ul class="nav navbar-nav navbar-right">     
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div style="float:left; width:300px;">
              <ul>     
              <li><a href="home.php?page=addtomato">Add</a></li>
              <li><a href="home.php?page=stats">Stats</a></li>
              <ul>
              <li><a href="home.php?page=keywords&function=keywordmenu">Keywords</a>
                <ul>
                <li><a href="home.php?page=keywords&function=keywordcreate">Keyword Create</a></li>
                  <li><a href="home.php?page=keywords&function=keywordedit">Keyword Edit</a></li>
                  <li><a href="home.php?page=keywords&function=keyworddelete">Keyword Delete</a></li>
                  <li><a href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a></li>
                  <li><a href="home.php?page=keywords">Keyword Tree</a></li>
                </ul>
              </li>
              <li><a href="home.php?page=categories">Categories</a>
                <ul>
                  <li><a href="home.php?page=categories&function=create">Category Create</a></li>
                  <li><a href="home.php?page=categories&function=edit">Category Edit</a></li>
                  <li><a href="home.php?page=categories&function=delete">Category Delete</a></li>
                </ul>
              </li>
              <li><a href="home.php?page=tomatoshow">Show single tomato</a></li>
              <li><a href="home.php?page=linkkeywords">Now link Keywords</a></li>
              <li><a href="home.php?page=setup">Set Up</a></li> 
              <li><a href="home.php">Default</a></li>       
              </ul>
  </div>