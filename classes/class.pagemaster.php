<?php

class pagemaster
{
    public function pagefinder($get_page)
    {
        switch ($get_page) {
            //// ***** TOMATO PAGES ***** ////
            case "tomato":
                message();
                print('<p align="right"><a href="#TomatoMaker" aria-controls="collapseExample" data-toggle="collapse">+ Add Tomato</a></p>');
                print('<div class="collapse" id="TomatoMaker">');
                $tomato_form = new addtomato;
                $tomato_form->upload_form_tomato();
                print('</div>');
                print('<hr/>');
                $page_display = new showtomatoes;
                $page_display->today_values();

                $page_display->job_search_daily_goal();
                print('<p class="'.$page_display->jobsearch_goal_div_class.'">Jobsearch: &nbsp;'.$page_display->jobsearch_day_hours.' Hours</p>');

                $date = new DateTime();
                $week = $date->format("W");
                print('<h4><span class="badge badge-secondary">Week #'.$week.'</span></h4>');
                $page_display->show_days_of_week();  
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
            //    $generic= new viewweek;
                // week_number_only() sets week number for object, then genreic_time_view() creates all the object properties based on that week number
               // $generic->testsvg(200);
               // $generic->sixtytoms();
               // $generic->week_number_only();
              //  print('<p>'.$generic->week_formated_like_database.'</p>');
              //  $generic->generic_time_view();
               // $generic = new viewweek;
              //  $generic->week_number_only(1);
             //   print('<p>'.$generic->week_formated_like_database.'</p>');
             //   $generic->generic_time_view();
                break;

            case "index":
                message();
                print('<p>Home</p>');
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
                $set = new setup;
                $set->set_timestamp_by_datestring();
                break;
            default:
                echo "<p>page has not been defined</p>";
                // $this->index_page();
        }
    }
}
