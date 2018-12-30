<?PHP

class tomatoaux extends conn{
    
        public function tomato_section_menu(){
            $sectionmenu ='<ul>
            <li><a href="home.php?page=tomato&function=tomatoadd">Add</a></li>
            <li><a href="home.php?page=tomato&function=tomatoedit">Edit</a></li>
            <li><a href="home.php?page=tomato&function=tomatodelete">Delete</a></li>
            <li><a href="home.php?page=tomato&function=tomatofind">Find</a></li>
            </ul>';
            return $sectionmenu;
    }
    public function tomato_section_menu_anchors(){
        $sectionmenu ='
        <a class="dropdown-item" href="home.php?page=tomato&function=tomatoadd">Add</a>
        <a class="dropdown-item" href="home.php?page=tomato&function=tomatoedit">Edit</a>
        <a class="dropdown-item" href="home.php?page=tomato&function=tomatodelete">Delete</a>
        <a class="dropdown-item" href="home.php?page=tomato&function=tomatofind">Find</a>
        <a class="dropdown-item" href="home.php?page=tomato&function=linktocategory">Link To Category</a>
        ';
        return $sectionmenu;
}
}
?>