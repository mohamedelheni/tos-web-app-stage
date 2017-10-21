<?php

	/*
	================================================
	== Service Page
	================================================
	*/

	ob_start(); 

	session_start();

	$pageTitle = 'Services';

	/*if (isset($_SESSION['Nom_Member'])) {*/

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			$sort = 'asc';

			$sort_array = array('asc', 'desc'); 

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

				$sort = $_GET['sort'];

			}

			$stmt2 = $con->prepare("SELECT * FROM services");

			$stmt2->execute();

			$cats = $stmt2->fetchAll(); 

			if (! empty($cats)) {

			?>

			<h1 class="text-center">Services</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> Lister des Services
						<div class="option pull-right">
							
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Long</span> |  
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php
							foreach($cats as $cat) {
								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='services.php?do=Edit&catid=" . $cat['ID_Service'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Modifier</a>";
										echo "<a href='services.php?do=Delete&catid=" . $cat['ID_Service'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Suprimer</a>";
									echo "</div>";
									echo "<h3>" . $cat['Nom'] . '</h3>';
									echo "<div class='full-view'>"; 
										echo "<p>"; if($cat['Description'] == '') { echo 'Cet Service n\'a pas une description'; } else { echo $cat['Description']; } echo "</p>";
										if($cat['Visible'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Caché</span>'; } 
										if($cat['Permet_Commentaire'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i>Commentaire désactivé</span>'; }
										if($cat['Permet_Ajout'] == 1) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i> Annonces désactivées</span>'; }  
									echo "</div>";

			
								echo "</div>";
								echo "<hr>";
							}
						?>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="services.php?do=Add"><i class="fa fa-plus"></i> Ajouter Nouveau Service</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">pas de Service à voir</div>';
					echo '<a href="services.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> Nouveau Service
						</a>';
				echo '</div>';

			} ?>

			<?php

		} elseif ($do == 'Add') { ?>

			<h1 class="text-center">Ajouter Nouveau Service</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
				
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Nom Of The Category" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" placeholder="Describe The Category" />
						</div>
					</div>


					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
					</div>

				</form>
			</div>

			<?php

		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insérer Service</h1>";
				echo "<div class='container'>";

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];

				$check = checkItem("Nom", "services", $name);

				if ($check == 1) {

					$theMsg = '<div class="alert alert-danger">Désolé, cette service existe</div>';

					redirectHome($theMsg, 'back');

				} else {


					$stmt = $con->prepare("INSERT INTO 

						services(Nom, Description)

					VALUES(:zname, :zdesc)");
					$stmt->execute(array(
						'zname' 	=> $name,
						'zdesc' 	=> $desc
						
						
					));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Service Bien Inserer</div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Désolé tu ne peut pas Browse cette Page Direct</div>';

				redirectHome($theMsg, 'back');

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			$stmt = $con->prepare("SELECT * FROM services WHERE ID_Service = ?");


			$stmt->execute(array($catid));


			$cat = $stmt->fetch();

			$count = $stmt->rowCount();

			if ($count > 0) { ?>

				<h1 class="text-center">Modifier Service</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>" />

						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Nom</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control" required="required" placeholder="Nom Of The Category" value="<?php echo $cat['Nom'] ?>" />
							</div>
						</div>
		
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?php echo $cat['Description'] ?>" />
							</div>
						</div>
	
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Enregistrer" class="btn btn-primary btn-lg" />
							</div>
						</div>
											</form>
				</div>

			<?php

		

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Cette Id n\'existe pas </div>';

				redirectHome($theMsg);

				echo "</div>";

			}

		} elseif ($do == 'Update') {

			echo "<h1 class='text-center'>mise à jour Service</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				

				$stmt = $con->prepare("UPDATE 
											services 
										SET 
											Nom = ?, 
											Description = ?
											
											
										WHERE 
											ID_Service = ?");

				$stmt->execute(array($name, $desc, $id));

				

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' mise à jour bien effectué</div>';

				redirectHome($theMsg, 'back');

			} else {

				$theMsg = '<div class="alert alert-danger">Disolé tu ne peut pas browse cet page direcet</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";

			

				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			

				$check = checkItem('ID_Service', 'services', $catid);

			

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM services WHERE ID_Service = :zid");

					$stmt->bindParam(":zid", $catid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Service Suprimée</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">cet ID_Service n\'existe pas</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	/*} else {

		header('Location: index.php');

		exit();
	}*/

	ob_end_flush(); 

?>