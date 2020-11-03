<?php require_once("../../resources/config.php");

if(isset($_GET['delete_order_id'])){

$query = query("delete from orders where order_id= " . escape_string($_GET['delete_order_id']) . " ");
confirm($query);

set_message("Order Deleted");
redirect("index.php?orders");

}else{
redirect("index.php?orders");
}

?>