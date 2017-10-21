<?php
	session_start();
	$noNavbar = '';
	$pageTitle = 'Enregistrer';

	
		header('Location: dashboard.php'); // Redirect To Dashboard Page
	

	include 'init.php';

	// Check If User Coming From HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		// Check If The User Exist In Database

		$stmt = $con->prepare("SELECT 
									ID_Member, Nom_Member, Password 
								FROM 
									members 
								WHERE 
									Nom_Member = ? 
								AND 
									Password = ? 
								AND 
									GroupID = 1
								LIMIT 1");

		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		// If Count > 0 This Mean The Database Contain Record About This Nom_Member

		if ($count > 0) {
			$_SESSION['Nom_Member'] = $username; // Register Session Name
			$_SESSION['ID'] = $row['ID_Member']; // Register Session ID
			header('Location: dashboard.php'); // Redirect To Dashboard Page
			exit();
		}

	}

?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Nom" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Mot De Passe" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	</form>

<?php include $tpl . 'footer.php'; ?>