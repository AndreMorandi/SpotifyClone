<?php include("includes/includedFiles.php");
 

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header("Location: index.php");
}

/*$albumQuery = mysqli_query($con, "SELECT * FROM albums where id='$albumId'");
$album = mysqli_fetch_array($albumQuery); // converts the result of the mysql query to an array*/

$album = new Album($con, $albumId); //album object
$artist = $album->getArtist();
//$artist = new Artist($con, $album['artist']); //now we don't have to create a query for every single artist. We can just create artist by passing an id into the artist object.

?>

<div class="entityInfo">
	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>
	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<a role="link" class="artistNameText"><span>By</span> <?php echo $artist->getName(); ?></a>
		<p><?php echo $album->getNumberOfSongs() ?> songs</p>
	</div>
</div>



<div class="tracklistContainer">
	<ul class="tracklist">
		<?php  

		$songIdArray = $album->getSongsIds();
		$i = 1;
		foreach($songIdArray as $songId) {
			// loop over $songIdArray and each item will gonna be $songId

			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist(); //the album artist might not be the same as the song artist for all songs on the album. 

			//echoes the whole track list row (number of the song on the album, name, artist, duration and more button)
			echo "<li class='tracklistRow'> 

					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<img class='optionsButton' src='assets/images/icons/more.png'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>

				</li>";

			$i++; //trackCount

		}



		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds); //transforms in an obejct so we can access 
		</script>


	</ul>
</div>


