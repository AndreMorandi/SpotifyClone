<?php 

include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$artist = new Artist($con, $artistId);

?>

<script>
	$(".button.btn-green").click(function() {
		playFirstSong();
	});
	
</script>

<div class="entityInfo borderBottom">
	<div class="centerSection">
		<div class="artistInfo">
			<img class="image-circle" src="<?php echo $artist->getArtistProfilePic(); ?>" alt="<?php echo $artist->getName(); ?>" >
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>
			<div>
				<button class="button btn-green">PLAY</button>
			</div>
			
		</div>
	</div>
</div>

<div class="tracklistContainer borderBottom">
	<ul class="tracklist">
		<h2>MOST PLAYED SONGS</h2>
		<?php  

		$songIdArray = $artist->getSongsIds();
		$i = 1;
		foreach($songIdArray as $songId) {
			// loop over $songIdArray and each item will gonna be $songId

			if($i > 5){
				break;
			}//will only display the top 5 songs

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

<div class="gridViewContainer">
	<h2>ALBUMS</h2>

<?php

	$albumQuery = mysqli_query($con /*variável de conexão com a database*/, "SELECT * FROM albums WHERE artist='$artistId'");  

	while($row = mysqli_fetch_array($albumQuery)) {

		/*The while is gonna loop over every single result. Converts the results
		in an array(mysqli_fetch_array). $row is gonna contain the current row returned*/

		//for each album, it echos the artworkPath and title//

		echo "<div class='gridViewItem'>
				<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
					<img src='"  .  $row['artworkPath'] . "'>

					<div class='gridViewInfo'>"
						. $row['title'] .
					"</div>

				</span>
			</div>";
	}

?>

</div>


