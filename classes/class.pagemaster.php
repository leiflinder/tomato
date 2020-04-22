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
                if (isset($_GET['tomid'])) {
                    // santitize GET value
                    if (filter_var($_GET['tomid'], FILTER_VALIDATE_INT) === false) {
                        print('<div class="alert alert-danger" role="alert">
                        Danger. Tomato ID not integer.</div>');
                    } else {
                        $tomid = $_GET['tomid'];
                        $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($tomid);
                        $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
                    }
                }
                $edit_tomatos->pull_tomatos_by_default_this_week();
                print('<br/>');
                print('<h4><span class="badge badge-secondary">Goals</span></h4>');
                $goals = new setupgoals;
                $goals->show_goals();
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
               // print('<h3>Today</h3>');
               // $viewtoday = new viewday;
                // create date object property
               // $viewtoday->today(); // set date value in object
               // $userid = filter_var($_SESSION['userid'], FILTER_SANITIZE_STRING);
              //  $viewtoday->set_userid(); // set userid in object
              //  $values = $viewtoday->today_tomatoes(); // get all today values using date and userid
              //  $viewtoday->set_total_hours_today(); // set total hrs of today tomatos
              //  $viewtoday->day_view(); // display overview of today for userid and date today
               // print('<h3>Yesterday</h3>');
               // $viewtoday->yesterday(); // set yesterday date property
               // $viewtoday->yesterday_tomatoes(); // set yesterday array property
              //  $viewtoday->set_total_hours_yesterday(); // set total hrs of yesterday tomatos
              //  $viewtoday->day_view_yesterday(); // display overview of yesterday for userid and date today
                $viewthisweek = new viewweek;
                $viewthisweek->userid = $_SESSION['userid'];
                $viewthisweek->default_week_setting();
                $viewthisweek->this_week_dbase_resource();
                print('<h4>Week '.$viewthisweek->defaultWeekNumber.'</h4>');
                $viewthisweek->generic_time_view();
                print('<p>'.$viewthisweek->defaultWeekNumber.'</p>');
                print('<p>'.$viewthisweek->userid.'</p>');
                print('<pre>');
                print_r($viewthisweek->this_week_dbase_resource);
                print('</pre>');
               // print('<h4>Last Week</h4>');
               // print('<h4>Current Month</h4>');
               // print('<h4>Last Month</h4>');
                break;

            case "index":
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
/*
            case "linkkeywords":
                message();
                echo "<h3>Now link Keywords</h3>";
                $this->link_keywords_to_tomoato();
                break;
 */
            case "setup":
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
