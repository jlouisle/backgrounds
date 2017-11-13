<?php
require 'database.php';
?>

<form method="post">
  <input type="text" name="new_service_name">
  <input type="submit" name="save_new_service" value="add new service">
</form>

<?php
add_service($mysqli);


echo "<br>services:</br>";

$res = $mysqli->query("SELECT * FROM service ORDER BY id desc");
// $res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    //echo "<input type = 'button' value = '$id'> " .
    echo "<a href=/service.php?service_id=$id>".$row['name']."</a><br/>";
}

function add_service($mysqli){
  if($_SERVER['REQUEST_METHOD'] != 'POST')
    return;
  if(!isset($_POST['save_new_service']) && !isset($_POST['new_service_name']))
    return;

  $new_service_name = $mysqli->escape_string($_POST['new_service_name']);

  if(empty($new_service_name)){
    echo "Please provide a service name";
    return;
  }
  $mysqli->query("INSERT INTO service (name) VALUES(\"$new_service_name\");");
  if ($mysqli->errno) {
      echo "Error adding entry: (" . $mysqli->errno . ") " . $mysqli->error;
  }
}


?>
