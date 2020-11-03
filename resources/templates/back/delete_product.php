<?php require_once("../../resources/config.php");

if(isset($_GET['delete_product_id'])){

$query = query("delete from products where product_id= " . escape_string($_GET['delete_product_id']) . " ");
confirm($query);

set_message("product Deleted");
redirect("index.php?products");

}else{
redirect("index.php?products");
}

?>