<!--     NAVBAR     -->
<div id="navBarContainer">
	<nav class="navBar">

		<span role="link"  tabindex="0" onclick="openPage('index.php')" class="logo"> 
			<img src="assets/images/icons/spotify.png" title="Spotify">					
		</span>

		<div class="group">
			<div class="navItem">
				<span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink">Search
					<span class="icon fa fa-search" ></span>
				</span><!--Page Not Created Yet-->
			</div>
		</div>

		<div class="group">
			<div class="navItem">
				<span roles="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
			</div>

			<div class="navItem">
				<span roles="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
			</div>

			<div class="navItem">
				<span roles="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><?php echo $userLoggedIn; ?></span>
			</div>
		</div>

	</nav>
</div><!--END OF NAVBAR CONTAINER-->
