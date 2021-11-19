<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.link_to_category.php');

$link_to_category = new link_to_category;
if(isset($_POST)){
    if(isset($_POST['categories']) && isset($_POST['keyword_id'])){
        $keyword_id = $_POST['keyword_id'];
        $keyword_id = htmlspecialchars(strip_tags($keyword_id));
        foreach($_POST['categories'] AS $key => $value){
            $key = htmlspecialchars(strip_tags($key));
            $category_id = $link_to_category->get_category_id_by_category_name($value);
            // create new array
            $array_of_categories[] = $category_id;
        }
        // this powerful function first deletes everything then adds from new
       if($link_to_category->update_assoc_between_keyword_and_categories($keyword_id, $array_of_categories)==TRUE){
        $alert = "success";
        $message = "Keyword links changed";
        header("Location: home.php?page=keywords&function=keywordshow&alert=$alert&message=$message");
       }else{
        $alert = "warning";
        $message = "Problem with link change";
        header("Location: home.php?page=keywords&function=keywordshow&alert=$alert&message=$message");
       }

    }

}
?>