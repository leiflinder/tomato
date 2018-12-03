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
}
?>