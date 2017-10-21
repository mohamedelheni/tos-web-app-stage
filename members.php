<?php
       
       
       
	/*
	================================================
	== Manage Members Page
	== You Can Add | Edit | Delete Members From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Intervenants';

	if (isset($_SESSION['Nom_Member'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page

		if ($do == 'Manage') { // Manage Members Page

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';

			}

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT * FROM members WHERE GroupID != 1 $query ORDER BY ID_Member DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();

			if (! empty($rows)) {

			?>

			<h1 class="text-center">Intervenants</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage_mambers text-center table table-bordered">
						<tr>

							
							<td>Photo</td>
							<td>Nom</td>
							<td>Fichier</td>
							<td>Tel</td>
							
							<td>Long nom</td>
							<td>Register Date</td>
							<td>Control</td>
							
							
							
						</tr>
						<?php
						 
							foreach($rows as $row) {
								echo "<tr>";
                                      
                                
									echo "<td>";
									 if(empty($row['Photo'])){echo '<img src="enregistrement/member_img/img.PNG"';}else{ echo "<a href='enregistrement/member_img/" . $row['Photo'] . "'alt=''><img src='enregistrement/member_img/" . $row['Photo'] . "'alt=''/></a>";}
									   echo "</td>";
									   
									echo "<td>" . $row['Nom_Member'] . "</td>";

                                      	echo "<td>";
									 if(empty($row['Fichier'])){echo 'vide';}else{ echo "<a href='enregistrement/member_fichier/". $row['Fichier']."'alt=''  target='_blank'><i class='fa fa-file fa-5' aria-hidden='true'></i></a>";}
									   echo "</td>";

									echo "<td>" . $row['Tel'] . "</td>";
									
									echo "<td>" . $row['FullName'] . "</td>";
									echo "<td>" . $row['Date'] ."</td>";
									echo "<td>
										<a href='members.php?do=Edit&userid=" . $row['ID_Member'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='members.php?do=Delete&userid=" . $row['ID_Member'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
										if ($row['RegStatus'] == 0) {
											echo "<a 
													href='members.php?do=Activate&userid=" . $row['ID_Member'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Activate</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="members.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i>Nouveau Intervenant
				</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">Pas de Intervenant</div>';
					echo '<a href="members.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i>Nouveau Intervenant
						</a>';
				echo '</div>';

			} ?>

		<?php 

		} elseif ($do == 'Add') { // Add Page ?>

			<h1 class="text-center">Ajouter Nouveau Intervenant</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Nom_Member Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Nom" />
						</div>
					</div>
					<!-- End Nom_Member Field -->
					<!-- Start Password Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Mot De Passe</label>
						<div class="col-sm-10 col-md-6">
							<input type="password" name="password" class="password form-control"  autocomplete="new-password" placeholder="Mot De Passe doit etre Complex" />
							<i class="show-pass fa fa-eye fa-2x"></i>
						</div>
					</div>
					<!-- End Password Field -->
				<!-- Start GSM Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tel</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="GSM" class="form-control" required="required" placeholder="Num Tel" />
						</div>
					</div>
					<!-- End GSM Field -->
					<!-- Start Email Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control" required="required" placeholder="Email doit etre  Valid" />
						</div>
					</div>
					<!-- End Email Field -->
					<!-- Start Full Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Long Nom</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="full" class="form-control" required="required" placeholder="Long Nom" />
						</div>
					</div>
					<!-- End Full Name Field -->
					<!-- Start Profile Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Photo</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="file" class="form-control"  />

						</div>
					</div>
					<!-- End Profile Field -->
					<!-- Start fichier Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Fichier</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="fichier" class="form-control"  />

						</div>
					</div>
					<!-- End fichier Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
							
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

		<?php 

		} elseif ($do == 'Insert') {

			// Insert Member Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Intervenant</h1>";
				echo "<div class='container'>";


                $fichier1_name = $_FILES['fichier']['name'];
                $fichier1_size = $_FILES['fichier']['size'];
                $fichier1_tmp_name = $_FILES['fichier']['tmp_name'];
                $fichier1_type = $_FILES['fichier']['type'];   
                $fichier1_extension0 = explode('.',$fichier1_name);
                $fichier1_extension1 =end($fichier1_extension0);
                $f1 = strtolower($fichier1_extension1);


                 

                $fichier_name = $_FILES['file']['name'];
                $fichier_size = $_FILES['file']['size'];
                $fichier_tmp_name = $_FILES['file']['tmp_name'];
                $fichier_type = $_FILES['file']['type'];   
                $fichier_extension0 = explode('.',$fichier_name);
                $fichier_extension1 =end($fichier_extension0);
                $f = strtolower($fichier_extension1);

                $permetextension = array("jpeg","jpg","png");
                 

				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];
				$GSM    =  $_POST['GSM'];

				$hashPass = sha1($_POST['password']);

				// Validate The Form

				$formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'Nom_Intervenant ne dit pas moin que <strong>4 Characters</strong>';
				}

				if (strlen($user) > 20) {
					$formErrors[] = 'Nom_Member ne doit pas plus que <strong>20 Characters</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'Nom_Member ne doit pas <strong>vide</strong>';
				}

				

				if (empty($name)) {
					$formErrors[] = 'Full Name ne doit pas <strong>vide</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'Email ne doit pas <strong>vide</strong>';
				}
				if (empty($GSM)) {
					$formErrors[] = 'Num_Tel ne doit pas <strong>vide</strong>';
				}
				if ( !empty($fichier1_name) && ($fichier1_size == 0)) {
					$formErrors[] = 'Désolé le size de fichier est <strong>grant que 2000 Ko</strong>';
				}
				if ( !empty($fichier_name) && ($fichier_size == 0)) {
					$formErrors[] = 'Désolé le size de fichier est <strong>grant que 2000 Ko</strong>';
				}
				if ((!empty($fichier_name)) && (!in_array($f, $permetextension))) {
					$formErrors[] = 'Désolé il faut que l\'extention de photo est l\'un des <strong>png,jpg,jpeg </strong>';

			
				}
			
				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
    


				if (empty($formErrors)) {
                 
                 if (!empty($fichier1_name)){
                 $fichi1 = rand(0,1000000000) . '_' .$fichier1_name ;
				move_uploaded_file($fichier1_tmp_name, "enregistrement/member_fichier\\".$fichi1);
                  }else{$fichi1="";}

               if (!empty($fichier_name)){
					$fichi = rand(0,1000000000) . '_' .$fichier_name ;
				move_uploaded_file($fichier_tmp_name, "enregistrement/member_img\\".$fichi);
			}else{$fichi="";}
                 
					// Check If User Exist in Database

					$check = checkItem("Nom_Member", "members", $user);

					if ($check == 1) {

						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

						redirectHome($theMsg, 'back');

					} else {

						// Insert Userinfo In Database

						$stmt = $con->prepare("INSERT INTO 
													members(Nom_Member, Password, Email, FullName, RegStatus,Tel, Date,Photo,Fichier)
												VALUES(:zuser, :zpass, :zmail, :zname, 1,:zTel,now(),:zfichier,:zfichier1) ");
						$stmt->execute(array(

							'zuser' => $user,
							'zpass' => $hashPass,
							'zmail' => $email,
							'zname' => $name,
							'zTel'   => $GSM,
							'zfichier1'   => $fichi1,
							'zfichier'   => $fichi

						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

						redirectHome($theMsg, 'back');

					}

				}
           
			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			// Check If Get Request userid Is Numeric & Get Its Integer Value

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM members WHERE ID_Member = ? LIMIT 1");

			// Execute Query

			$stmt->execute(array($userid));

			// Fetch The Data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit Intervenant</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="userid" value="<?php echo $userid ?>" />
						<input type="hidden" name="ppp" value="<?php echo $row['Photo'] ?>" />
						<input type="hidden" name="fff" value="<?php echo $row['Fichier'] ?>" />
						<!-- Start Nom_Member Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Nom_Member</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control" value="<?php echo $row['Nom_Member'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Nom_Member Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Mot de Passe</label>
							<div class="col-sm-10 col-md-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="laisser vide si tu ne veux pas le changer" />
							</div>
						</div>
						<!-- End Password Field -->
												<!-- Start tel Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tel</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="newtel" class="form-control" value="<?php echo $row['Tel'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End tel Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Long Nom</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Photo</label>
							<div class="col-sm-10 col-md-6">
								<input type="file" name="ph"  value="<?php echo $row['Photo'] ?>" class="form-control" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Fichier</label>
							<div class="col-sm-10 col-md-6">
								<input type="file" name="fi" value="<?php echo $row['Fichier'] ?>" class="form-control"/>
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save"  class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
             
			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

		} elseif ($do == 'Update') { // Update Page

			echo "<h1 class='text-center'>Update Intervenant</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                
               

                $fichier1_name = $_FILES['fi']['name'];
                $fichier1_size = $_FILES['fi']['size'];
                $fichier1_tmp_name = $_FILES['fi']['tmp_name'];
                $fichier1_type = $_FILES['fi']['type'];   
                $fichier1_extension0 = explode('.',$fichier1_name);
                $fichier1_extension1 =end($fichier1_extension0);
                $f1 = strtolower($fichier1_extension1);


                 

                $fichier_name = $_FILES['ph']['name'];
                $fichier_size = $_FILES['ph']['size'];
                $fichier_tmp_name = $_FILES['ph']['tmp_name'];
                $fichier_type = $_FILES['ph']['type'];   
                $fichier_extension0 = explode('.',$fichier_name);
                $fichier_extension1 =end($fichier_extension0);
                $f = strtolower($fichier_extension1);

                $permetextension = array("jpeg","jpg","png");

                




				// Get Variables From The Form

				$id 	= $_POST['userid'];
				$user 	= $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];
				$tel    =  $_POST['newtel'];
				$ppp    =   $_POST['ppp'];
				$fff    =   $_POST['fff'];

				// Password Trick

				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				// Validate The Form

				$formErrors = array();

				if (strlen($user) < 3) {
					$formErrors[] = 'Nom_Member ne doit pas moin que <strong>3 Characters</strong>';
				}

				if (strlen($user) > 15) {
					$formErrors[] = 'Nom_Member ne doit pas plus que <strong>15 Characters</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'Nom_Member ne doit pas <strong>Vide</strong>';
				}

				if (empty($name)) {
					$formErrors[] = 'Full Name ne doit pas <strong>Vide</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'Email ne doit pas <strong>Vide</strong>';
				}
				if (empty($tel)) {
					$formErrors[] = 'Tel ne doit pas <strong>Vide</strong>';
				}
				if ( !empty($fichier1_name) && ($fichier1_size == 0)) {
					$formErrors[] = 'Désolé le size de fichier est <strong>grant que 2000 Ko</strong>';
				}
				if ( !empty($fichier_name) && ($fichier_size == 0)) {
					$formErrors[] = 'Désolé le size de fichier est <strong>grant que 2000 Ko</strong>';
				}
				if ((!empty($fichier_name)) && (!in_array($f, $permetextension))) {
					$formErrors[] = 'Désolé il faut que l\'extention de photo est l\'un des <strong>png,jpg,jpeg </strong>';

			
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

                  $fichi1 = rand(0,1000000000) . '_' .$fichier1_name ;
				move_uploaded_file($fichier1_tmp_name, "enregistrement/member_fichier\\".$fichi1);

               
					$fichi = rand(0,1000000000) . '_' .$fichier_name ;
				move_uploaded_file($fichier_tmp_name, "enregistrement/member_img\\".$fichi);





					$stmt2 = $con->prepare("SELECT 
												*
											FROM 
												members
											WHERE
												Nom_Member = ?
											AND 
												ID_Member != ?");

					$stmt2->execute(array($user, $id));

					$count = $stmt2->rowCount();

					if ($count == 1) {

						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

						redirectHome($theMsg, 'back');

					} else { 
                             
                            
						

						       $stmt = $con->prepare("UPDATE members SET Nom_Member = ?, Email = ?, FullName = ?, Password = ?,Photo = ?,Fichier = ?,Tel= ? WHERE ID_Member = ?");

						       if(empty($fichier1_name)){$fichi1 =$fff ;}
						       if(empty($fichier_name)){$fichi =$ppp ;}
						       $stmt->execute(array($user, $email, $name, $pass,$fichi,$fichi1,$tel,$id));

						// Echo Success Message

						       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

						       redirectHome($theMsg, 'back');

					}

				}

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') { // Delete Member Page

			echo "<h1 class='text-center'>Delete Intervenant</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID_Member', 'members', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM members WHERE ID_Member = :zuser");

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Activate') {

			echo "<h1 class='text-center'>Activate Intervenant</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID_Member', 'members', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE members SET RegStatus = 1 WHERE ID_Member = ?");

					$stmt->execute(array($userid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg);

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>