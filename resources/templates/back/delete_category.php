<?php require_once("../../resources/config.php");

if(isset($_GET['delete_category_id'])){

$query = query("delete from categories where cat_id= " . escape_string($_GET['delete_category_id']) . " ");
confirm($query);

set_message("category Deleted");
redirect("index.php?categories");

}else{
redirect("index.php?categories");
}

?>