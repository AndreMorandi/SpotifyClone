<?php include("includes/includedFiles.php")?>

<!--   BEGINNING OF CONTENT PART   -->	

<h1 class="pageHeadingBig" style="text-align: center"><?php echo "Made for you" ?></h1> 

<div class="gridViewContainer">

	<?php

		$albumQuery = mysqli_query($con /*variável de conexão com a database*/, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");  

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





<!--      END OF CONTENT PART      -->					
