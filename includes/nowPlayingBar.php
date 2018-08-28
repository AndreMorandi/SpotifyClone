<?php

$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 20"); //the initial playlist
$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']); //pushed every item onto that array. Now that array contain all the 10 retrieved items from the query
}

$jsonArray = json_encode($resultArray); //convert the php to json, so it can be used by javascript

?>

<script>

$(document).ready(function() { //$(document).ready is an event which fires up when document is ready.
	var newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
	setTrack(newPlaylist[0], newPlaylist, false); //play starts 'false'(it will not play the song)
	updateVolumeProgressBar(audioElement.audio); //when the page loads, the volume progress bar is displayed full

	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault(); //prevents the default behavior for these events(mousedown, touchstart, mousemove, touchmove). It will prevent to highlight when clicking/dragging.
	});

	//control buttons with JQuery
	$('.play').click(function(){
    	playSong(); 
    	return true;
	});

	$('.pause').click(function(){
		pauseSong(); 
		return false;
	});

	$('.next').click(function() {
		nextSong();
		return;
	});

	$('.repeat').click(function() {
		setRepeat();
		return;
	});

	$('.previous').click(function() {
		previousSong();
		return;
	});

	$('.volume').click(function() {
		setMute();
		return;
	})

	$('.shuffle').click(function() {
		setShuffle();
		return;
	})


	//mouse movement events for progress bars(volume and track)
	$(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) {
		if(mouseDown) {
			//Set time of song, depending on position of mouse. "e" is the instance of the mous event
			timeFromOffset(e, this); //'this' is  ".playbackBar .progressBar"
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});


	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown) {
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();
		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	});



	$(document).mouseup(function() {
		mouseDown = false;
	});


});

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function previousSong() {
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0); //just restarts teh song
	} else {
		currentIndex--;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true); //go back to previous song
	}
}

function nextSong() {

	if(repeat == true){
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex == currentPlaylist.length - 1) { //lenght - 1 = last element of array {
		currentIndex = 0; //go back to the first index -> 0
	} else {
		currentIndex++; //next element
	}

	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);

}

function setRepeat() {
	repeat = !repeat; //inverts -> if it's false, sets true, if it's true, sets false.
	var imageName = repeat ? "repeat-active.png" : "repeat.png"; // if/else statement
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"; // if/else statement
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"; // if/else statement
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle) {
		//Randomize playlist
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		//so the song will never be played two times in a row
	}
	else {
		//Shuffle has been deactivated. Back to regular playlist
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

	}
}

function shuffleArray(array) {
	var j, x, i;
	for (i = array.length - 1; i > 0; i--) {
	    j = Math.floor(Math.random() * (i + 1));
	    x = array[i];
	    array[i] = array[j];
	    array[j] = x;
	}
}




function setTrack(trackId, newPlaylist, play) { //play->true/false(is Playing)


	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice(); //returns a copy of the array. Shuffle version
		shuffleArray(shufflePlaylist);
	}

	if(shuffle) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	} 
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
	pauseSong();

	/* AJAX CODE-> specify the page(URL) we want to make the ajax code to -> specify the 
	values you want to pass and what you want to do with the results */
	//passing song name via ajax
	$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

		//passes the string to an object so we can use it
		var track = JSON.parse(data);

		$(".trackName span").text(track.title); //title column from database

		// passing artist name via ajax
		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {

			//passes the string to an object so we can use it
			var artist = JSON.parse(data);

			$(".trackInfo .artistName span").text(artist.name); //name column from database

			$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')"); //navbar link to the artist page

		});
		// passing album artwork via ajax
		$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {

			//passes the string to an object so we can use it
			var album = JSON.parse(data);
			$(".content .albumLink img").attr("src", album.artworkPath); //will update the src attribute to be the value of the artworkPath of the song

			$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
		});



		audioElement.setTrack(track); //from database (track.path > from js file, class Audio())

		if(play) {
			playSong();
	}

	});



	
	
}



function playSong() {

    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });

    }

	$('.controlButton.play').hide();
	$('.controlButton.pause').show();
	audioElement.play();
}

function pauseSong() {
	$('.controlButton.play').show();
	$('.controlButton.pause').hide();
	audioElement.pause();
}


</script>





<!--     NOW PLAYING BAR     -->
<div id="nowPlayingBarContainer"">
	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" class="albumArtwork" src=""><!--Album Image from database-->
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0"></span><!--Get names from database (w/ AJAX)-->
					</span> 
					<span class="artistName">
						<span role="link" tabindex="0"></span><!--Get names from database (w/ AJAX)-->
					</span>
				</div>

			</div>
		</div>




		<!--     NOW PLAYING BAR CENTER     -->
		<div id="nowPlayingCenter">
			<div class="content playerControls">

				<!--     BUTTONS     --->
				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle" alt="Shuffle">
						<img src="assets/images/icons/shuffle.png">
					</button>
					<button class="controlButton previous" title="Previous" alt="Previous">
						<img src="assets/images/icons/previous.png">
					</button>
					<button class="controlButton play" title="Play" alt="Play" >
						<img src="assets/images/icons/play.png">
					</button>
					<button class="controlButton pause" title="Pause" alt="Pause" style="display: none;">
						<img src="assets/images/icons/pause.png">
					</button>
					<button class="controlButton next" title="Next" alt="Next">
						<img src="assets/images/icons/next.png">
					</button>
					<button class="controlButton repeat" title="Repeat" alt="Repeat">
						<img src="assets/images/icons/repeat.png">
					</button>
				</div>

				<!--     PROGRESS BAR     --->
				<div class="playbackBar">
					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBackground">
							<div class="progress"></div>
						</div>
					</div>
					
					<span class="progressTime remaining">0.00</span>
				</div>

			</div>
		</div>





		<div id="nowPlayingRight">
			<div class="volumeBar">

				<button class="controlButton volume" title="Volume button" alt="Volume">
					<img src="assets/images/icons/volume.png">
				</button>

				<div class="progressBar">
					<div class="progressBarBackground">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div> <!--END OF NOW PLAYING BAR-->
