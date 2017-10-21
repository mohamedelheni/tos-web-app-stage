<?php

	ob_start(); // Output Buffering Start

	session_start();

	
		$pageTitle = '';

		include 'init.php';

		/* Start Tbleau Page */

		$numUsers = 6; 

		$latestUsers = getLatest("*", "members", "ID_Member", $numUsers); // Latest Users Array

		$numItems = 6;  

		$latestItems = getLatest("*", 'chantiers', 'ID_Chantier', $numItems); // Latest Items Array

		$numComments = 6;

		?>

	

		<?php

		/* End Dashboard Page */

		include $tpl . 'footer.php';

	 else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>