<?php include("includes/includedFiles.php");

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else{
	$term = "";
}

?>

<div class="searchContainer">
	<h4>Search for an artist, album or a song</h4>
	<input class="searchInput" type="text" value="<?php echo $term ?>" placeholder="Start typing..." onfocus="var temp_value=this.value; 
	this.value=''; this.value=temp_value" spellcheck="false"></input>
</div>

<script>
	
	$(".searchInput").focus(); //will give the input field focus as soon as the page loads

	$(function() {

		$(".searchInput").keyup(function() {
			clearTimeout(timer);
			//when you type something, it cancells the timer and resets a knew one.
			timer = setTimeout(function() {
				//code executed after the time expire
				var val = $(".searchInput").val(); //now it contains the value of the input field
				openPage("search.php?term=" + val);
			}, 2000); // 2 seconds later (after the user stopped typing), shows the result
		})

	})

</script>
<?php if($term == "") exit(); ?>
<div class="tracklistContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="tracklist">

		<?php  
		$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%'");
		//finds a match in our DB. The % character makes that after the 'term', it will still look for matches. Can also use the '%' before the word.
		if(mysqli_num_rows($songsQuery) == 0) {
			echo "<span class='noResults'>No songs found matching \"" . $term . "\"</span>";
		}

		$songIdArray = array();
		$i = 1;
		while($row = mysqli_fetch_array($songsQuery)) {
			// loop over $songIdArray and each item will gonna be $songId

			if($i > 15){
				break;
			}//will only display 15 matches

			array_push($songIdArray, $row['id']);
			$albumSong = new Song($con, $row['id']);
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


<div class="artistContainer borderBottom">
	<h2>ARTISTS</h2>
	<?php

		$artistsQuery = mysqli_query($con, "SELECT id FROM artist WHERE name LIKE '$term%' LIMIT 12");

		if(mysqli_num_rows($artistsQuery) == 0) {
				echo "<span class='noResults'>No artists found matching \"" . $term . "\"</span>";
		}

		while($row = mysqli_fetch_array($artistsQuery)) {
			$artistFound = new Artist($con, $row['id']);

			echo "<div class='searchResultRow'>

					<div class='artistImage'>
						<img class='image-circle' role='link' src=" . $artistFound->getArtistProfilePic() . " onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
					</div>

					<div class='artistName'>
						<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
						" . $artistFound->getName() . "
						</span>
					</div>

				</div>";
		} 


		

	?>

	<!--<script> 
		var artist = JSON.parse();
		$(".artistImage img").attr("onclick", "openPage('artist.php?id=" + artist.id + "')"); 
	</script>-->
</div>



<div class="gridViewContainer">

<?php

	$albumQuery = mysqli_query($con /*variável de conexão com a database*/, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 6");

	if(mysqli_num_rows($albumQuery) == 0) {

				//echo "<span class='noResults'>No albums found matching \"" . $term . "\"</span>";
	} 
	else {
			?><h2>ALBUMS</h2><?php

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
	}

?>

</div>
