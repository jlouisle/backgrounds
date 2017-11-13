<?php
require 'database.php';

if(!isset($_GET['service_id'])){
  echo "no service selected";
  exit;
}
$service_id = $mysqli->escape_string($_GET['service_id']);
if($mysqli->query("SELECT * FROM service where id = $service_id")->num_rows == 0){
  echo "service doesn't exist";
  exit;
}

add_song($mysqli, $service_id);
$all_songs = $mysqli->query("SELECT * FROM song");
$service_songs = $mysqli->query("SELECT * FROM song_in_service sis left join song s on s.id = sis.song_id where service_id = $service_id");
?>

<h1>SERVICE_ID: <?= $service_id ?> </h1>

<?php if($service_songs->num_rows === 0): ?>
  <form method="post">
    <input type="submit" value="generate" name="generate service">
  </form>
<?php endif; ?>



<form method="post">
  <input type="text" name="part_of_service" placeholder="Part of Service">
  <select name="song_id">
      <?php while ($song = $all_songs->fetch_assoc()): ?>
          <option value="<?= $song['id'] ?>" > <?= $song['name'] ?> </option>
      <?php endwhile; ?>
  </select>
  <input type="submit" name="add_song_to_service" value="add new song">
</form>


<h3>songs</h3>

<?php
if($service_songs->num_rows):
  while ($song = $service_songs->fetch_assoc()): ?>
    <?= $song['part_of_service'] . " - " . $song['name'] ?> <br/>
<?php endwhile;
else: ?>
  <p>no songs</p>
<?php endif; ?>

<?php

function add_song($mysqli, $service_id){
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['add_song_to_service']))
        return;

    $song_id = $mysqli->escape_string($_POST['song_id']);
    $part_of_service = $mysqli->escape_string($_POST['part_of_service']);

    if (empty($part_of_service)) {
        echo "Please provide the part of the service";
        return;
    }

    $mysqli->query("INSERT INTO song_in_service (service_id,song_id,part_of_service) VALUES(\"$service_id\",\"$song_id\",\"$part_of_service\");");
    if ($mysqli->errno) {
        echo "Error adding entry: (" . $mysqli->errno . ") " . $mysqli->error;
    }
}
