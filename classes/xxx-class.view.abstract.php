<?php
abstract class viewsabstract extends conn {
    public function sectmenu(){
                    $sectionmenu ='<ul>
                    <li><a href="home.php?page=views&funcion=viewtoday">Today</a></li>
                    <li><a href="home.php?page=views&funcion=viewyesterday">Yesterday</a></li>
                    <li><a href="home.php?page=views&funcion=viewthisweek">This Week</a></li>
                    <li><a href="home.php?page=views&funcion=viewlastweek">Last Week</a></li>
                    <li><a href="home.php?page=views&funcion=viewcomparisons">Comparisons</a></li>
                    <li><a href="home.php?page=views&funcion=viewcustomviews">Custom Views</a></li>
                    </ul>';
                    return $sectionmenu;
    }
}
?>