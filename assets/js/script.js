var currentPlaylist = []; //empty array
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;


function openPage(url) {

	if(timer != null){
		clearTimeout(timer); //if the timer in ongoing when changing page, set the time out
	}

	if(url.indexOf("?") == -1) {
		url = url + "?";
	}
	
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);//built-in js function
	console.log(encodedUrl);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function createPlaylist() {
	var popup = prompt("Enter the name of your new playlist");

	if(popup != null) {
		$.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn }).done(function(error) { // done -> handle ajax responses [deferreds]
			//do soemthing when ajax returns
			if(error != ""){
				alert(error);
				return;
			}

			openPage("yourMusic.php");
		})
	}
}

// function for transforming time from seconds to xx:xx format
function formatTime(seconds) { 

	var time = Math.round(seconds); /*The Math.round() function returns the value of a number rounded to the nearest integer.*/
	var minutes = Math.floor(time / 60); //seconds divided by 60 give us the minutes /*The Math.floor() function returns the largest integer less than or equal to a given number.*/
	var seconds = time - (minutes * 60);

	//conditional statement
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}


function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime)); //time increasing
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime)); //time decreasing

	var progress = (audio.currentTime / audio.duration) * 100; //get the percentage of the total duration
	$(".playbackBar .progress").css("width", progress + "%"); //increasing accordingly to the percentage (progress%)
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;   //volume property varies from 0 to 1
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}


function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio'); //creates an HTML object which in this case is a audio object. Built-in audio object

	this.audio.addEventListener("canplay", function() { /* "canplay" is a property of audio */
		//'this' refers to the object ('audio' obejct in this case) that the event was called on
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.audio.addEventListener("ended", function() {
		nextSong();
	});


	this.setTrack = function(track) {
		this.currentlyPlaying = track; //current playing will always be the new track (overwritten)
		this.audio.src = track.path; //audio has already a lot of properties and 'src' is one of them

	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
}

