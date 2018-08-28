<?php include("includes/includedFiles.php");
 

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header("Location: index.php");
}


$playlist = new Playlists($con, $playlistId); //playlist object
$owner = new User($con, $playlist->getOwner());

?>

<div class="entityInfo">
	<div class="leftSection">
		<img src="assets/images/icons/playlistRed2.png">
	</div>
	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<a role="link" class="usernameText"><span>By</span> <?php echo $playlist->getOwner(); ?></a>
		<p><?php echo $playlist->getNumberOfSongs() ?> songs</p>
		<button class="button">DELET PLAYLIST</button>
	</div>
</div>



<div class="tracklistContainer">
	<ul class="tracklist">
		<?php  

		$songIdArray = array();//$album->getSongsIds();
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


