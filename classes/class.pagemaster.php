<?php

class pagemaster
{
    public function pagefinder($get_page)
    {
        switch ($get_page) {
            //// ***** TOMATO PAGES ***** ////
            case "tomato":
                message();
                print('<p><a class="btn btn-primary hundred_percent_width" data-toggle="collapse" href="#TomatoMaker" role="button" aria-expanded="false" aria-controls="collapseExample">Create Tomato</a>');
                print('<div class="collapse" id="TomatoMaker">');
                $tomato_form = new addtomato;
                $tomato_form->upload_form_tomato();
                print('</div>');
                print('<hr/>');
                $page_display = new showtomatoes;
                $date = new DateTime();
                $week = $date->format("W");
                print('<h4><span class="badge badge-secondary">Week #'.$week.'</span></h4>');
                
               $edit_tomatos = new edittomato;
               $edit_tomatos->pull_tomatos_by_default_this_week();
                print('<hr/>');
                $page_display->pull_tomatos_this_week();

                print('<br/>');
                print('<h4><span class="badge badge-secondary">Goals</span></h4>');
                $goals = new setupgoals;
                $goals->show_goals();
                break;


                case "tomatoedit":
                    print('<a href="home.php?page=tomato" class="btn btn-primary" role="button"><< Back</a>');
                    /*
                    $show = new showtomatoes;
                    $date = $show->todaydate();
                    $show->toms_by_tomdate($date);
                    */
                    $edit = new edittomato;
                    $tomid = $edit->sanitizeTomID();
                    if(!(is_null($tomid))){
                        print('<p>TOMATO ID: '.$tomid.'</p>');
                        // return tomato from dbase
                        $tomato = $edit->return_single_tomato_based_on_tomid($tomid);
                        // make tomato edit form with values preset for tomato id
                        $edit->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
                    }
                break;

                //// ***** KEYWORDS PAGES ***** ////
                case "keywords":
                    message();
                    $keywordclass = new createKeyword;
                    $keywordclass->form_create_keyword();
                    print('<hr/>');
                    $edit = new keywordedit;
                    $edit->alphabet_accordion_with_keywords();
                break;

            case "linkcategories":
                message();
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
                message();

                $generic= new viewweek;
                // week_number_only() sets week number for object, then genreic_time_view() creates all the object properties based on that week number

                $generic->week_number_only();
                print('<p>'.$generic->week_formated_like_database.'</p>');
                $generic->generic_time_view();
        
                
               // $generic = new viewweek;
                $generic->week_number_only(1);
                print('<p>'.$generic->week_formated_like_database.'</p>');
                $generic->generic_time_view();

               // $generic = new viewweek;
                $generic->week_number_only(2);
                print('<p>'.$generic->week_formated_like_database.'</p>');
                $generic->generic_time_view();

               // $generic = new viewweek;
                $generic->week_number_only(3);
                print('<p>'.$generic->week_formated_like_database.'</p>');
                $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(4);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(5);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(6);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(7);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(8);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();

               // $generic = new viewweek;
               $generic->week_number_only(9);
               print('<p>'.$generic->week_formated_like_database.'</p>');
               $generic->generic_time_view();



                break;

            case "index":
                message();
                print('<p>Home</p>');
                /*
                print('<p><a class="btn btn-primary hundred_percent_width" data-toggle="collapse" href="#TomatoMaker" role="button" aria-expanded="false" aria-controls="collapseExample">Create Tomato</a>');
                print('<div class="collapse" id="TomatoMaker">');
                $tomato_form = new addtomato;
                $tomato_form->upload_form_tomato();
                print('</div>');
                print('<hr/>');
                $page_display = new showtomatoes;
                $date = new DateTime();
                $week = $date->format("W");
                print('<h4><span class="badge badge-secondary">Week #'.$week.'</span></h4>');
                $edit_tomatos = new edittomato;
                if (isset($_GET['tomid'])) {
                    if (filter_var($_GET['tomid'], FILTER_VALIDATE_INT) === false) {
                        print('<div class="alert alert-danger" role="alert">
                        Danger. Tomato ID not integer.</div>');
                    } else {
                        $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                        $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
                    }
                }
                $edit_tomatos->pull_tomatos_by_default_this_week();
                print('<br/>');
                print('<h4><span class="badge badge-secondary">Goals</span></h4>');
                $goals = new setupgoals;
                $goals->show_goals();
                */
                break;

    case "categories":
           // case "categoryshow";
              message();
              print('<h4>Category Show</h4>');
              $create = new createCategory;
              $create->form_create_category();
              $showcategories = new show_categories;
              $showcategories->show_categories_with_edit_delete_links();
            break;

            case "setup":
                message();
                print('<h4>Setup</h4>');
               // $this->setup();
               /*
               if (isset($_GET['function'])) {
                   print('<p>Function used in URL parameter</p>');
                   print('<p>'.$_GET['function'].'</p>');
                   if ($_GET['function']=="setupweeklygoals") {
                       $setup = new setupgoals;
                       // $setup->form_set_weekly_goals();
                       // $goals_array = $setup->make_goals_array();
                       // print('<pre>');
                       //  print_r($goals_array);
                       // print('</pre>');
                       $setup->make_goals_array();
                   } else {
                       print('<p>function not defined</p>');
                   }
               }
               */
                break;
            default:
                echo "page has not been defined";
                // $this->index_page();
        }
    }
}
