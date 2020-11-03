<?php require_once("../../resources/config.php");

if(isset($_GET['delete_slide_id'])){
$query_find_image = query("select slide_image from slides where slide_id= " . escape_string($_GET['delete_slide_id']) . " limit 1 ");
confirm($query_find_image);

$row = fetch_array($query_find_image);
$target_path = UPLOAD_DIRECTORY . DS . $row['slide_image'];
unlink($target_path);

$query = query("delete from slides where slide_id= " . escape_string($_GET['delete_slide_id']) . " ");
confirm($query);

set_message("slide Deleted");
redirect("index.php?slides");

}else{
redirect("index.php?slides");
}

?>