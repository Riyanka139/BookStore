<?php require_once("../../resources/config.php");

if(isset($_GET['delete_user_id'])){

$query = query("delete from users where user_id= " . escape_string($_GET['delete_user_id']) . " ");
confirm($query);

set_message("user Deleted");
redirect("index.php?users");

}else{
redirect("index.php?users");
}

?>