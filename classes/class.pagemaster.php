<?PHP

class pagemaster extends clean {

    function pagefinder($get_page){
         switch ($get_page) {

            case "index":
               $frank = new changed_today;
               $newtoday = $frank->query_table_for_tomdate_today();
                $page_display = new showtomatoes;
                print('<h3>TODAY</h3>');
                $page_display->show_tomatoes($newtoday);
                // show norwegian for week
                include('../classes/class.pagefunctions.index.php');
                $page_functions = new index_page_functions;
                print('<br/>');
                print('<h3>WEEK</h3>');
                print('<table class="table">');
                print('<tr><td>Study Hours</td><td>');
                $page_functions->print_out_category_for_this_week(3);
                print('</td></tr>');
                print('<tr><td>Norsk Hours</td><td>');
                $page_functions->print_out_category_for_this_week(2);
                print('</td></tr>');
                print('<tr><td>Coding Hours</td><td>');
                $page_functions->print_out_category_for_this_week(1);
                print('</td></tr>');
                print('<tr><td>Design Hours</td><td>');
                $page_functions->print_out_category_for_this_week(9);
                print('</td></tr>');
                print('<tr><td>Job Search</td><td>');
                $page_functions->print_out_category_for_this_week(14);
                print('</td></tr>');
                print('<tr><td>Task Hours</td><td>');
                $page_functions->print_out_category_for_this_week(6);
                print('</td></tr>');
                print('<tr><td>Exercise</td><td>');
                $page_functions->print_out_category_for_this_week(7);
                print('</td></tr>');
                print('<tr><td>Guitar Hours</td><td>');
                $page_functions->print_out_category_for_this_week(5);
                print('</td></tr>');
                print('</table>');
            break;

            case "stats":
                echo "<h3>View Tomatoes</h3>";
                print('<pre>');
                print_r($_GET);  
                print('</pre>');
            break;

            case "addtomato":
                echo "<h3>Add</h3>";
                $this->add();
                break;

            case "keywords":
            // root page keywords
            // functions are keyword menu items
            if(isset($_GET['function'])){
                    if($_GET['function']=='keywordcreate'){
                        print('<div class="alert alert-info">Function Create Keyword</div>');
                        $keywordclass = new createKeyword;
                        $keywordclass->form_create_keyword();
                        if(isset($_POST['new_keyword']))
                        {
                            print('<p>New Keyword Submitted</p>');
                            $keywordclass = new createKeyword;
                            $keywordclass->upload_new_keyword($_POST['new_keyword']);
                        }
                       $show = new show_keywords;
                       $show->print_only_keywords_no_accordion();
                        
                    }elseif($_GET['function']=='keywordedit'){
                        print('<div class="alert alert-info">Function Edit Keyword</div>');
                        $edit = new keywordedit;
                        if(isset($_POST['edit_keyword'])){
                            $edit->upload_edited_keyword($_POST['keywordid'], $_POST['edit_keyword']);
                        }
                        print('<pre>');
                        print_r($_POST);
                        print('</pre>');
                    
                        $edit->show_all_keywords_with_edit_delete_links();
                        
                    }elseif($_GET['function']=='keyworddelete'){
                        print('<div class="alert alert-info">Function Delete Keyword</div>');
                    }elseif($_GET['function']=='keywordtree'){
                        print('<div class="alert alert-info">Function Keyword Tree</div>');
                    }elseif($_GET['function']=='keywordlinktocategory'){
                        print('<div class="alert alert-info">Function Keyword Link To Category</div>');
                        $categories = new link_to_category;
                            if(!isset($_POST['cats'])){
                                $_POST['cats']=NULL;
                            }
                            if(isset($_POST['keyid'])){
                                $categories->update_assoc_between_keyword_and_categories($_POST['keyid'], $_POST['cats']);
                            }
                         $categories->print_all_keywords();
                    }else{
                        print('<div class="alert alert-warning">Keyword Links</div>');
                        print('<p><a href="home.php?page=keywords&function=keywordcreate">Keyword Create</a></p>');
                        print('<p><a href="home.php?page=keywords&function=keywordedit">Keyword Edit</a></p>');
                        print('<p><a href="home.php?page=keywords&function=keyworddelete">Keyword Delete</a></p>');
                        print('<p><a href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a></p>');
                    }
                }else{
                    print('<div class="alert alert-warning">Keyword Links</div>');
                    print('<p><a href="home.php?page=keywords&function=keywordcreate">Keyword Create</a></p>');
                    print('<p><a href="home.php?page=keywords&function=keywordedit">Keyword Edit</a></p>');
                    print('<p><a href="home.php?page=keywords&function=keyworddelete">Keyword Delete</a></p>');
                    print('<p><a href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a></p>');
                }

            break;

            case "categories":
                $categoryCreatClass = new createCategory;
                // if create category form is submitted
                if(isset($_POST['new_category']))
                {
                    print('<p>New Category Submitted</p>');
                    $categoryCreatClass->upload_new_category($_POST['new_category']);
                }
                // if &function=create show create form
                if(isset($_GET['function']) & $_GET['function']=="create"){
                    $categoryCreatClass->form_create_category();
                }
                // Upload Edited Category POST value exists
                if (isset($_POST['edit_category_new_value'])){ 
                    $edit_category = new editCategory;                  
                    $edit_category->upload_edited_category($_POST['edit_category_new_value'], $_POST['edit_category_id']);
                }
                // show all categories
                $categoryShowClass = new show_categories;
                $categoryShowClass->show_all_categories();
            break;

            case "tomatoshow":
            $tomato_add_object = new addtomato;
                echo "<h3>Show single tomato</h3>";
                if(isset($_POST['tomato_submit'])){
                    $userid=$_POST['userid'];
                    $title=$_POST['title'];
                    $date=$_POST['date'];
                    $week=$_POST['week'];
                    $count=$_POST['count'];
                    $category=$_POST['categories'];
                    $notes=$_POST['notes'];
                    $url=$_POST['url'];
                        if(!(isset($_POST['keywords']))){
                            $keywords = array();
                        }else{
                            $keywords = $_POST['keywords']; 
                        }
                    print('<p>Tomato Submitted</p>');
                    $created_tomato_id = $tomato_add_object->upload_tomato_with_keyword_array(
                        $userid,
                        $title,
                        $date,
                        $week,
                        $count,
                        $category,
                        $notes,
                        $url,
                        $keywords);
                }
                print('<p>Created Tomato ID: '.$created_tomato_id.'</p>');
               $single_tomato =  new showtomatoes;
               $test= $single_tomato->show_tomato_by_tomid($created_tomato_id);
               print('<pre>');
               print_r($test);
               print('</pre>');
                break;


            case "linkkeywords":
                echo "<h3>Now link Keywords</h3>";
                $this->link_keywords_to_tomoato();
             break;

            case "setup":
                if(isset($_POST['new_keyword']))
                {
                    print('<p>New Keyword Submitted</p>');
                    $keywordclass = new createKeyword;
                    $keywordclass->upload_new_keyword($_POST['new_keyword']);
                }
                if(isset($_POST['keyid'])){
                    $process = new keywords_and_categories;
                    $process->update_assoc_between_keyword_and_categories($_POST['keyid'], $_POST['cats']);
                }

                $this->setup();
                break;
            default:
               echo "page has not been defined";
               // $this->index_page();                             
        }       
    }


    function add(){
        // start switching to dedicated 
        // add tomato class
        $tomato_add_object = new addtomato;
        print('<p><a href="http://localhost/tomato220.com/public_html/home.php?page=addtomato">Reset</a></p>');
        $tomato_add_object->upload_form_tomato();
    }


    function tomatoshow(){
        print('<p>Tomato Show Functions</p>');
        if(isset($_POST['keywords'])){
            $keywords = $_POST['keywords'];
                for($i=0; $i < count($keywords); $i++){
                    echo "<p>".$keywords[$i]."</p>";
                }
            }else{
                print('<p>$_POST[keywords] has no value</p>');
            }
        }
        function link_keywords_to_tomoato(){
            print('<p>Keywords</p>');
            $upload = new upload;
            if(isset($_GET['keywords'])){
                $keywords = $_GET['keywords'];
                    for($i=0; $i < count($keywords); $i++){
                       // echo "<p>".$keywords[$i]." at tom id ".$_SESSION['success']."</p>";
                       print('<p>'.$upload->insertkeywords($_SESSION['success'], $keywords[$i]).'</p>');
                    }
                }else{
                    print('<p>$_GET[keywords] has no value</p>');
                }
            }

  function keywords(){
    $create_keyword = new createKeyword;
    $show_all_and_edit = new keywordedit;
    echo '<p class="function_description">Create new keyword.</p>';
    $create_keyword->form_create_keyword();
    // show all keywords with edit and delete links
  $show_all_and_edit->show_all_keywords_with_edit_delete_links();
  }  
    function setup(){
        $create_keyword = new createKeyword;
        echo '<p class="function_description">Create new keyword.</p>';
        $create_keyword->form_create_keyword();
        $categories = new keywords_and_categories;
       echo '<p class="function_description">Assign categories to keywords.</p>';
        $categories->print_all_keywords();
    }

}

?>