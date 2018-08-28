<?php include("includes/includedFiles.php"); ?>

<script>
	$(".playlistContainer .button").click(function() {
		createPlaylist();
	});//TO DO: implement jquery UI for alert
</script>

<div class="playlistContainer">
	<div class="gridViewContainer">
		<div class="profilePictureSpace">
			<img class="image-circle userProfilePicCircle" src="<?php echo $userLoggedIn->getUserProfilePic(); ?>">
		</div>
		<h2>PLAYLISTS</h2>
		<div class="buttonItems">
			<button class="button btn-green">NEW PLAYLIST</button>
		</div>
		

		<?php
			$username = $userLoggedIn->getUsername();

			$playlistsQuery = mysqli_query($con /*variável de conexão com a database*/, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='youDoNotHavePlaylistsYetText'>You don't have any playlist yet. Create one now.</span>";
			} 
		
		

			while($row = mysqli_fetch_array($playlistsQuery)) {

				$playlist = new Playlists($con, $row);

				/*The while is gonna loop over every single result. Converts the results
				in an array(mysqli_fetch_array). $row is gonna contain the current row returned*/

				//for each album, it echos the artworkPath and title//

				echo "<div class='gridViewItem' role='link' tabIndex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId(). "\")'>

						<div class='playlistImage'>
							<img src='assets/images/icons/playlistRed2.png'>
						</div>

						<div class='gridViewInfo'>"
								. $playlist->getName() .
							"</div>
					</div>";
			}
		?>

	</div>
</div>