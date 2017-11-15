<?php
require 'database.php';

add_song($mysqli);
$all_songs = $mysqli->query("SELECT * FROM song");
?>

<form method="post">
  <input type="text" name="song_name" placeholder="Song name">
  <input type="text" name="song_bpm" placeholder="BPM">

  <input type="submit" name="add_song" value="add new song">
</form>

<?php
function add_song($mysqli){
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['add_song']))
        return;

    $song_name = $mysqli->escape_string($_POST['song_name']);
    $song_bpm = $mysqli->escape_string($_POST['song_bpm']);

    if (empty($song_name)) {
        echo "Please provide a song name";
        return;
    }

    if (empty($song_bpm)) {
        $song_bpm = "null";
    }

    $mysqli->query("INSERT INTO song (name,bpm) VALUES(\"$song_name\",$song_bpm);");
    if ($mysqli->errno) {
        echo "Error adding entry: (" . $mysqli->errno . ") " . $mysqli->error;
    }
}
 ?>
