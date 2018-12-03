<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown link
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
  </div>
</nav>


<div class="nav_div_left">
   <ul>
      <!--
      <li><a href="home.php?page=tomatoes">Tomatoes</a>
         <?php // include ('menu_tomatoes.php');?>
      </li>
      -->
      <li><a href="home.php?page=tomato">Tomatoes</a>
         <?php
            $tomato_section_menu = new tomatoaux;
            print($tomato_section_menu->tomato_section_menu());
         ?>
      </li>
      <li><a href="home.php?page=keywords&function=keywordmenu">Keywords</a>
         <?php include ('menu_keywords.php');?>
      </li>
      <li><a href="home.php?page=categories">Categories</a>
         <?php include ('menu_categories.php');?>
      </li>
      <li><a href="home.php?page=views">Views</a>
         <?php
            $view_section_menu = new viewaux;
            print($view_section_menu->view_section_menu());
         ?>
      </li>
      <li><a href="home.php?page=setup">Set Up</a>
         <?php include ('menu_setup.php');?>
      </li>
   </ul>
</div>