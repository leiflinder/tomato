<?PHP

class pagemaster
{
    function pagefinder($get_page)
    {
        switch ($get_page) {
            case "tomato":
                if (isset($_GET['function'])) {
                    switch ($_GET['function']) {
                        case "tomatoadd":
                            print('<p>Add</p>');
                            $tomato_form = new addtomato;
                            $tomato_form->upload_form_tomato();
                            break;
                        case "tomatoedit":
                            print('<p>Edit</p>');
                            $edit_tomatos = new edittomato;
                            if (isset($_GET['tomid'])) {
                                $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                                /*
                                print('<pre>');
                                print_r($tomato);
                                print('</pre>');
                                */
                                $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
                                
                            }
                            $edit_tomatos->pull_tomatos_by_default_this_week();
                            break;
                        case "tomatodelete";
                            print('<p>Delete</p>');
                            break;
                        case "tomatofind":
                            print('<p>Find</p>');
                            break;
                        case "linktocategory";
                            print('<p>Link To Category');
                            break;
                        case "tomatoweeks";
                            print('<p>Tomato Weeks</p>');
                            $weeks = new tomatoweeks;
                            // set instance variable;
                            $weeks->distinct_tomweek_values(8);
                            // show html
                            $weeks->view_weeks_html();
                            break;
                    }
                } else {
                    print('<p>No Function</p>');
                }
                
                break;
            case "views":
                if (isset($_GET['function'])) {
                    switch ($_GET['function']) {
                        case "viewtoday":
                            print('<p>viewtoday</p>');
                            break;
                        case "viewyesterday":
                            print('<p>viewyesterday</p>');
                            break;
                        case "viewweeks";
                            print('<p>viewweeks</p>');
                            $weeks = new viewweeks;
                            $weeks->view_weeks_html();
                            break;
                        case "viewcomparisons":
                            print('<p>viewcomparisons</p>');
                            break;
                        case "viewcustomviews";
                            print('<p>viewcustomviews</p>');
                            break;
                    }
                } else {
                    print('<p>No Function</p>');
                }
                
                break;
            case "index":
                // uses file class.tomato.show.php
                $page_display = new showtomatoes;
                print('<h3>RECENT</h3>');
                $edit_tomatos = new edittomato;
                if (isset($_GET['tomid'])) {
                    $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                    $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);                   
                }
                $edit_tomatos->pull_tomatos_by_default_this_week();
        // $debase_resource_today_changed = $page_display->query_table_for_tomdate_today();
        // $page_display->show_tomatoes($debase_resource_today_changed);
        // uses file class.pagefunctions.index.php
                
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
                echo "<h3>Stats</h3>";
                break;
            
            case "addtomato":
                print('<div class="alert alert-warning" role="alert">Add Tomato</div>');
                // file: class.tomato.add.php
                $tomato_add_object = new addtomato;
                $tomato_add_object->upload_form_tomato();
                break;
            
            case "keywords":
                // root page keywords
                // functions are keyword menu items
                if (isset($_GET['function'])) {
                    if ($_GET['function'] == 'keywordcreate') {
                        print('<div class="alert alert-info">Function Create Keyword</div>');
                        $keywordclass = new createKeyword;
                        $keywordclass->form_create_keyword();
                        if (isset($_POST['new_keyword'])) {
                            print('<p>New Keyword Submitted</p>');
                            $keywordclass = new createKeyword;
                            $keywordclass->upload_new_keyword($_POST['new_keyword']);
                        }
                        $show = new show_keywords;
                        $show->print_only_keywords_no_accordion();
                        
                    } elseif ($_GET['function'] == 'keywordedit') {
                        print('<div class="alert alert-info">Function Edit Keyword</div>');
                        $edit = new keywordedit;
                        if (isset($_POST['edit_keyword'])) {
                            $edit->upload_edited_keyword($_POST['keywordid'], $_POST['edit_keyword']);
                        }
                        
                        $edit->show_all_keywords_with_edit_delete_links();
                        
                    } elseif ($_GET['function'] == 'keyworddelete') {
                        print('<div class="alert alert-info">Function Delete Keyword</div>');
                        if (isset($_GET['deletemessage'])) {
                            print("<p><span class='success'>Keyword Deleted</span></p>");
                        }
                        $delete = new keyworddelete;
                        $delete->show_keywords_with_delete_button();
                        
                    } elseif ($_GET['function'] == 'keywordtree') {
                        $keywordtree = new keywordtree;
                        $keywordtree->show_categories_with_associated_keywords();
                    } elseif ($_GET['function'] == 'keywordlinktocategory') {
                        print('<div class="alert alert-info">Function Keyword Link To Category</div>');
                        $categories = new link_to_category;
                        if (!isset($_POST['cats'])) {
                            $_POST['cats'] = NULL;
                        }
                        if (isset($_POST['keyid'])) {
                            $categories->update_assoc_between_keyword_and_categories($_POST['keyid'], $_POST['cats']);
                        }
                        $categories->print_all_keywords();
                    } else {
                        include('includes/menu.keyword.functions.html');
                    }
                } else {
                    include('includes/menu.keyword.functions.html');
                }
                break;
            
            case "categories":
                $categoryCreatClass = new createCategory;
                if (isset($_GET['message'])) {
                    print('<p><span style="color:green;">' . $_GET['message'] . '</span></p>');
                }
                if (isset($_GET['function'])) {
                    if ($_GET['function'] == "categorycreate") {
                        print('<h2>Category Create</h2>');
                        $create = new createCategory;
                        $create->form_create_category();
                        $show = new show_categories;
                        $show->show_categories_no_extras();
                        // $categoryCreatClass->form_create_category();
                    } elseif ($_GET['function'] == "categorydedit") {
                        print('<h2>Category Edit</h2>');
                        $edit = new editCategory;
                        $edit->show_categories_with_edit();
                        if (isset($_POST['edit_category_new_value'])) {
                            $edit->upload_edited_category($_POST['edit_category_new_value'], $_POST['edit_category_id']);
                            $edit->show_categories_with_edit();
                        }
                    } elseif ($_GET['function'] == "categorydelete") {
                        $delete = new categorydelete;
                        $delete->show_categories_with_delete_button();
                    } elseif ($_GET['function'] == "categorytree") {
                        $showcategytree = new categorytree;
                        $showcategytree->show_categories_with_associated_keywords();
                    } else {
                        print('<h2>No Function Defined</h2>');
                        $edit = new editCategory;
                        $edit->show_categories_with_edit();
                    }
                } else {
                    include('includes/menu.category.functions.html');
                    $show = new show_categories;
                    $show->show_categories_no_extras();
                }
                // Upload Edited Category POST value exists
                if (isset($_POST['edit_category_new_value'])) {
                    $edit_category = new editCategory;
                    $edit_category->upload_edited_category($_POST['edit_category_new_value'], $_POST['edit_category_id']);
                }
                // show all categories
                $categoryShowClass = new show_categories;
                // $categoryShowClass->show_all_categories();
                break;
            
            case "tomatoshow":
                print('<p>Edit Single Tomato</p>');
                break;
            
            case "findtomato":
                print('<p>Find Tomato</p>');
                $findtomato = new findtomato;
                //$findtomato->fix_null_titles();
                //$findtomato->fix_null_dates();
                // $findtomato->fix_null_week_number();
                $findtomato->find_tomato_form();
                break;
            
            case "linkkeywords":
                echo "<h3>Now link Keywords</h3>";
                $this->link_keywords_to_tomoato();
                break;
            
            
            
            case "setup":
               // $this->setup();
               if (isset($_GET['function'])) {
                   print('<p>Function used in URL parameter</p>');
                   print('<p>'.$_GET['function'].'</p>');
                   if($_GET['function']=="setupweeklygoals"){
                       $setup = new setupgoals;
                       $setup->form_set_weekly_goals();
                   }else{
                       print('<p>function not defined</p>');
                   }
               }
                break;
            default:
                echo "page has not been defined";
                // $this->index_page();                             
        }
    }
    
    function tomatoshow()
    {
        print('<p>Tomato Show Functions</p>');
        if (isset($_POST['keywords'])) {
            $keywords = $_POST['keywords'];
            for ($i = 0; $i < count($keywords); $i++) {
                echo "<p>" . $keywords[$i] . "</p>";
            }
        } else {
            print('<p>$_POST[keywords] has no value</p>');
        }
    }
    function link_keywords_to_tomoato()
    {
        print('<p>Keywords</p>');
        $upload = new upload;
        if (isset($_GET['keywords'])) {
            $keywords = $_GET['keywords'];
            for ($i = 0; $i < count($keywords); $i++) {
                // echo "<p>".$keywords[$i]." at tom id ".$_SESSION['success']."</p>";
                print('<p>' . $upload->insertkeywords($_SESSION['success'], $keywords[$i]) . '</p>');
            }
        } else {
            print('<p>$_GET[keywords] has no value</p>');
        }
    }
    
    function setup()
    {
        $create_keyword = new createKeyword;
        echo '<p class="function_description">Create Weekly Goal</p>';
        $create_keyword->form_create_keyword();
        $categories = new keywords_and_categories;
        echo '<p class="function_description">Assign categories to keywords.</p>';
        $categories->print_all_keywords();
    }
    
}

?>