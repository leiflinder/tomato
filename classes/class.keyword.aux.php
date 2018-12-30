<?PHP

class keywordaux extends conn{
    
        public function keyword_section_menu(){
            $keywordmenu ='              <ul>
            <li><a href="home.php?page=keywords&function=keywordcreate">Keyword Create</a></li>
              <li><a href="home.php?page=keywords&function=keywordedit">Keyword Edit</a></li>
              <li><a href="home.php?page=keywords&function=keyworddelete">Keyword Delete</a></li>
              <li><a href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a></li>
              <li><a href="home.php?page=keywords&function=keywordtree">Keyword Tree</a></li>
            </ul>';
            return $keywordmenu;
    }
    
    public function keyword_section_menu_anchors(){
        $keywordmenu ='        
        <a class="dropdown-item" href="home.php?page=keywords&function=keywordcreate">Keyword Create</a>
        <a class="dropdown-item" href="home.php?page=keywords&function=keywordedit">Keyword Edit</a>
        <a class="dropdown-item" href="home.php?page=keywords&function=keyworddelete">Keyword Delete</a>
        <a class="dropdown-item" href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a>
        <a class="dropdown-item" href="home.php?page=keywords&function=keywordtree">Keyword Tree</a>
        ';
        return $keywordmenu;
}
}
?>