<?PHP

class pagemaster
{
    function pagefinder($get_page)
    {
        switch ($get_page) {
            //// ***** TOMATO PAGES ***** ////
            case "tomato":
                print('<p><a class="btn btn-primary hundred_percent_width" data-toggle="collapse" href="#TomatoMaker" role="button" aria-expanded="false" aria-controls="collapseExample">Create Tomato</a>');
                print('<div class="collapse" id="TomatoMaker">');
                // use this function to print out all keywords that start with the leter
                $tomato_form = new addtomato;
                $tomato_form->upload_form_tomato();
                print('</div>');
                print('<hr/>');
                $edit_tomatos = new edittomato;
                $edit_tomatos->pull_tomatos_by_default_this_week();
                break;

                //// ***** KEYWORDS PAGES ***** ////
                case "keywords":
                        $keywordclass = new createKeyword;
                        $keywordclass->form_create_keyword();
                        print('<hr/>');
                        $edit = new keywordedit;
                        $edit->alphabet_accordion_with_keywords();       
                break;
            case "linkcategories":
                if (isset($_GET['keywordid'])) {
                    $keywordid = htmlspecialchars(strip_tags($_GET['keywordid']));
                    $link_to_cat = new link_to_category;
                    $link_to_cat->return_name_of_keyword_id($keywordid);
                    print('<h2>'.$link_to_cat->keyword_title.'</h2><br/>');
                    $cat_list = new link_to_category;
                    // create object array
                    $cat_list->all_cats_associated_with_keyid($keywordid);
                    // show the list of checkboxes
                    $cat_list->category_form($cat_list->array_of_categories_with_catid_as_index, $cat_list->category_titles_linked_to_this_keyword, $keywordid);
                }
            break;
            //// ***** VIEWS PAGES ***** ////
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
                

                //// ***** INDEX PAGE ***** ////
                break;
            case "index":
                // uses file class.tomato.show.php
                $page_display = new showtomatoes;
                $date = new DateTime();
                $week = $date->format("W");
                print('<h4><span class="badge badge-secondary">Week #'.$week.'</span></h4>');
                $edit_tomatos = new edittomato;
                if (isset($_GET['tomid'])) {
                    $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                    $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);                   
                }
                $edit_tomatos->pull_tomatos_by_default_this_week();
                print('<br/>');
                print('<h4><span class="badge badge-secondary">Goals</span></h4>');
                $goals = new setupgoals;
                $goals->show_goals();
                break;

            //// ***** CATEGORIES PAGES ***** ////
            case "categories":
                $categoryCreatClass = new createCategory;

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
                   // include('includes/menu.category.functions.html');
                   $create = new createCategory;
                   $create->form_create_category();
                   $showcategories = new show_categories;
                   $showcategories->show_categories_with_edit_delete_links();
                }
                // show all categories
                $categoryShowClass = new show_categories;
                // $categoryShowClass->show_all_categories();
                break;

            case "categoryshow";
              print('<h4>Category Show</h4>');
              $showcategories = new show_categories;
              $showcategories->show_categories_with_edit_delete_links();
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
                     // $setup->form_set_weekly_goals();
                    // $goals_array = $setup->make_goals_array();
                    // print('<pre>');
                   //  print_r($goals_array);
                    // print('</pre>');
                    $setup->make_goals_array();
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

}

?>