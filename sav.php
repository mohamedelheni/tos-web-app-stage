<?php

	/*
	================================================
	== SAV Page
	================================================
	*/

	ob_start(); 

	session_start();

	$pageTitle = 'SAV';

	if (isset($_SESSION['Nom_Member'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			$sort = 'asc';

			$sort_array = array('asc', 'desc'); 

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

				$sort = $_GET['sort'];

			}

			$stmt = $con->prepare("SELECT  
										sav.*, 
										services.Nom,
										members.Nom_Member 
									FROM 
										sav  
									INNER JOIN 
										services 
									ON 
										services.ID_Service = sav.a 
									INNER JOIN 
										members 
									ON 
										members.ID_Member = sav.b
									ORDER BY 
										ID_Sav DESC");
			$stmt->execute();


			$sav = $stmt->fetchAll();

			if (! empty($sav)) {

			?>





			<h1 class="text-center">SAV</h1>
			<div class="container categories">
				      <form action="search.php" method="GET">
				      	<input type="text" name="query"  placeholder="n'ecriver pas [ ' ]"/>
    <input type="submit" value="chercher"  />
</form>


        <form action="filter.php"  method="GET" style="display: flex; margin:10px ">
              <div  style="width:150px">
							<select name="intervenant"> 
								<option  value="0" >***Intervenant***</option>
								<?php 
									$allCats = getAllFrom("*", "members", "", "", "ID_Member", "ASC");
									foreach($allCats as $cat) {
										echo "<option value='" . $cat['ID_Member'] . "'>" . $cat['Nom_Member'] . "</option>";
									}
								?>
							</select>
						 </div>
						 <div   style="width:150px">
							<select name="ser">
								<option value="0">***Service***</option>
								<?php 
									$allCats = getAllFrom("*", "services", "", "", "ID_Service", "ASC");
									foreach($allCats as $catt) {
										echo "<option value='" . $catt['ID_Service'] . "'>" . $catt['Nom'] . "</option>";
									}
								?>
							</select>
						</div>
						<div  style="width:150px">
							<select name="ty">
								<option value="0">***Type***</option>
										<option value="1">Création</option>
										<option value="2">Entretien</option>
										<option value="3">Rénovation</option>
										<option value="4">Maintenance de matériel</option>
										<option value="5">présentation</option>
										<option value="6">Amélioration</option>
										<option value="7">Modification</option>
										<option value="8">Reconfiguration</option>
										<option value="9">intégration Software</option>
										<option value="10">Formation</option>
							</select>
						</div>
						<div  style="width:150px">
							<select name="gar">
								<option value="-1">***Garantie(o/n)***</option>
										<option value="1">oui</option>
										<option value="0">non</option>										
							</select>
						</div>
						
						<div class="col-sm-10 col-md-2">
							<input type="text" name="date_d" class="form-control" placeholder="jj/mm/aaaa de" />
						</div>
						
						<div class="col-sm-10 col-md-2">
							<input type="text" name="date_f" class="form-control" placeholder="jj/mm/aaaa jusqu à" />
						</div>
						<input type="submit" value="filtrer"  />
         </form>


				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> List SAV
					<div class="option pull-right">
							
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Long</span> |  
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php
							foreach($sav as $cat) {
								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='sav.php?do=Edit&catid=" . $cat['ID_Sav'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Modifier</a>";
										echo "<a href='sav.php?do=Delete&catid=" . $cat['ID_Sav'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Suprimer</a>";
									echo "</div>";
									echo "<h3>";
									$allCats = getAllFrom("*", "members", "","", "ID_Member", "ASC");
									foreach ($allCats as $catt) {									
									if ($cat['b'] == $catt['ID_Member']){echo 'Inter : '. $catt['Nom_Member'].' | Date_Inter : '.$cat['Date_Intervention'].' | Nom_Client : ' .$cat['Nom_Client'];}
                                     }


									 echo '</h3>';
									echo "<div class='full-view'>"; 
										echo "<p>";
										echo 'Service : ';
										 $allser = getAllFrom("*", "services", "","", "ID_Service", "ASC");
										 foreach ($allser as $catt) {									
									if ($cat['a'] == $catt['ID_Service']){echo $catt['Nom'] ;}
								             }
								             echo '|';echo 'Type de chantier : ';


                                                      if  ($cat['Type_Chantier']==1)    {echo 'Création';} 
								               if ($cat['Type_Chantier'] == 2) { echo 'Entretien'; } 
								               if ($cat['Type_Chantier'] == 3) { echo 'Rénovation'; }
								               if ($cat['Type_Chantier'] == 4) { echo 'Maintenance de matériel'; }
								               if ($cat['Type_Chantier'] == 5) { echo 'présentation'; }
								               if ($cat['Type_Chantier'] == 6) { echo 'Amélioration'; }
								              if ($cat['Type_Chantier'] == 7) { echo 'Modification'; }
									              if ($cat['Type_Chantier'] == 8) { echo 'Reconfiguration'; }
									              if ($cat['Type_Chantier'] == 9) { echo 'intégration Software'; }
									               if ($cat['Type_Chantier'] == 10) { echo 'Formation'; }

										  echo "</p>";
										if($cat['Maintenance'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Maintenance </span>'; } 
										if($cat['Garantie'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i>Garantie</span>'; }
										if($cat['Garantie'] == 0) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i>Hors Garantie</span>'; }  
									echo "</div>";

								

								echo "</div>";
								echo "<hr>";
							}
						?>
					</div>
				</div>
		 		
				<a class="add-category btn btn-primary" href="sav.php?do=Add"><i class="fa fa-plus"></i> Nouveau SAV</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">pas de SAV à voir</div>';
					echo '<a href="sav.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> Nouveau SAV
						</a>';
				echo '</div>';

			} ?>

			<?php

		} elseif ($do == 'Add') { ?>

         <h1 class="text-center"> Nouveau SAV</h1>
         
		<form class="form-horizontal" action="?do=Insert" method="POST">

		<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Détails intervention 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				      

					<!-- Start Category Type -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Intervenant</label>
						<div class="col-sm-10 col-md-6">
							<select name="intervenant">
								<option value="0">...</option>
								<?php 
									$allCats = getAllFrom("*", "members", "", "", "ID_Member", "ASC");
									foreach($allCats as $cat) {
										echo "<option value='" . $cat['ID_Member'] . "'>" . $cat['Nom_Member'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Category Type -->
										  <!-- Start Ads Field -->
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label">Etat</label>
           <div class="col-sm-10  col-md-6">
                         <div class="choix">
             	            <input id="ads-yes" type="radio" name="etat" value="0" checked/>
             	            <label for="ads-yes">Normal</label>
                         </div>
                          <div class="choix">
             	            <input id="ads-no" type="radio" name="etat" value="1" />
             	            <label for="ads-no">Urgente</label>
                         </div>
                         <div class="choix">
             	            <input id="ads-no" type="radio" name="etat" value="2" />
             	            <label for="ads-no">Trés Urgente</label>
                         </div>
           </div>
     </div>
       <!-- End Ads Field -->
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			



	<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Société/Client Détails
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				      
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom(société/Client)</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name_client" class="form-control" autocomplete="on" required="required" placeholder="ecrire ici le nom de (société/Client)" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Liew/Adresse</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="adresse" class="form-control" required="required" autocomplete="on" placeholder="ecrire ici l'adresse" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Date d'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="date_inter" class="form-control" required="required"  placeholder="jj/mm/aaaa" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Heure d'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="heure_inter" class="form-control" required="required" placeholder="hh:mm" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Durée D'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="duree_inter" class="form-control" autocomplete="off" required="required" placeholder="ecrire ici durée d'intervention" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom de contact</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="nom_contact" class="form-control" autocomplete="off" required="required" placeholder="ecrire ici le nom de contact" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tel/fax</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="tel" class="form-control" autocomplete="off"  placeholder="ecrire ici tel ou fax" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">E-mail</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="mail" class="form-control" autocomplete="off"  placeholder="ecrire ici l'E-mail" />
						</div>
					</div>
					
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			













				<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Services et Type 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				   
				

					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Service</label>
						<div class="col-sm-10 col-md-6">
							<select name="ser">
								<option value="0">...</option>
								<?php 
									$allCats = getAllFrom("*", "services", "", "", "ID_Service", "ASC");
									foreach($allCats as $catt) {
										echo "<option value='" . $catt['ID_Service'] . "'>" . $catt['Nom'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Type Chantier</label>
						<div class="col-sm-10 col-md-6">
							<select name="ty">
								<option value="0">...</option>
										<option value="1">Création</option>
										<option value="2">Entretien</option>
										<option value="3">Rénovation</option>
										<option value="4">Maintenance de matériel</option>
										<option value="5">présentation</option>
										<option value="6">Amélioration</option>
										<option value="7">Modification</option>
										<option value="8">Reconfiguration</option>
										<option value="9">intégration Software</option>
										<option value="10">Formation</option>
							</select>
						</div>
					</div>
					
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			
			
	

<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Matériels 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					

						 
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label">Maintenance</label>
           <div class="col-sm-10  col-md-6">
                         <div>
             	<input id="ads-no" type="radio" name="maint" value="0" checked/>
             	<label for="ads-no">Non</label>
             </div>
              <div>
             	<input id="ads-yes" type="radio" name="maint" value="1" />
             	<label for="ads-yes">Oui</label>
             </div>

                         
           </div>
     </div>
     <!--            -->



					
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label"></label>
           <div class="col-sm-10  col-md-6">
                         <div class="choix">
             	            <input id="ads-yes" type="radio" name="garantie" value="1" />
             	            <label for="ads-yes">Garantie</label>
                         </div>
                          <div class="choix">
             	            <input id="ads-no" type="radio" name="garantie" value="0" checked/>
             	            <label for="ads-no">Hors Garantie</label>
                         </div>
           </div>
     </div>
     <!--            -->


	
                
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<textarea name="description" placeholder="laisser cette ligne vide et ecrire à-partir de la suivante"rows="6" cols="100"></textarea>
						</div>
					</div>

					       <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Prix Total(TTC)</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="prix" class="" autocomplete="off"  placeholder="Nom Of The Category" />
						</div>
					</div>
       			 
			
					
					




					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			




      <!-- Start submit Field -->
     <div class ="form-group">           
           <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Save Service" class="btn btn-primary btn-lg">
           </div>
     </div>
       <!-- End submit Field -->
  </form>



			</div>

			<?php

/****************************************************************************************************************************/
/****************************************************************************************************************************/
/****************************************************************************************************************************/

/****************************************************************************************************************************/
/****************************************************************************************************************************/
/******************************************************************************************************************************/


		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insérer SAV</h1>";
				echo "<div class='container'>";

				// Get Variables From The Form

				$intervenant 		= $_POST['intervenant'];
				$etat 		= $_POST['etat'];
				$mail 		= $_POST['mail'];
				$ser 		= $_POST['ser'];
				$ty 		= $_POST['ty'];
				$garantie 		= $_POST['garantie'];
				$tel 		= $_POST['tel'];
				$name_client 		= $_POST['name_client'];
				$adresse 		= $_POST['adresse'];
				$date_inter 		= $_POST['date_inter'];
				$heure_inter 		= $_POST['heure_inter'];
				$duree_inter 		= $_POST['duree_inter'];
				$nom_contact 		= $_POST['nom_contact'];
				$description 		= $_POST['description'];
				$maint 		= $_POST['maint']; 
				$prix 		= $_POST['prix'];

				$str0 = str_replace("/","",$_POST['date_inter']);
				$str1 = $str0;
                $str2_0 =substr($str1,4,4);
                $str2_1 =substr($str1,2,2);
                $str2_2 =substr($str1,0,2);
                $str2_s = $str2_0.$str2_1.$str2_2;
                 $stri =(int)($str2_s);
				


                  $formErrors = array();

				if (empty($ser)) {
					$formErrors[] = 'Il faut choisir la <strong>service</strong>';
				}

				if (empty($ty)) {
					$formErrors[] = 'Il faut choisir le <strong>Type de chantier</strong>';
				}
				if (empty($intervenant)) {
					$formErrors[] = 'Il faut choisir l\' <strong>Intervenant</strong>';
				}



                foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
    


				if (empty($formErrors)) {






					$stmt = $con->prepare("INSERT INTO 

						sav(Num_Date,
							Description,
							Maintenance,
							Garantie,
							b,
							Intervenant_Etat,
							Nom_Client,
							Adresse,
							Date_Intervention,
							Heure_Intervention,
							Duree_Intervention,
							Nom_Contact,
							tel_Fax,
							E_mail,
							Type_Chantier,
							Prix_Total,
					        a)

					VALUES(:zstri,
						:zDescription,
						:zMaintenance,
						:zGarantie,
						:zIntervenant,
						:zIntervenant_Etat,
						:zNom_Client,
						:zAdresse,
						:zDate_Intervention,
						:zHeure_Intervention,
						:zDuree_Intervention,
						:zNom_Contact,
						:ztel_Fax,
						:zE_mail,
						:zType_Chantier,
						:zPrix_Total,
						:za)");
					$stmt->execute(array(
						'zDescription' 	=> $description,
						'zMaintenance' 	=> $maint,
						'zGarantie' 	=> $garantie,
						'zIntervenant' 	=> $intervenant,
						'zIntervenant_Etat' 	=> $etat,
						'zNom_Client' 	=> $name_client,
						'zAdresse' 	=> $adresse,
						'zDate_Intervention' 	=> $date_inter,
						'zHeure_Intervention' 	=> $heure_inter,
						'zDuree_Intervention' 	=> $duree_inter,
						'zNom_Contact' 	=> $nom_contact,
						'ztel_Fax' 	=> $tel,
						'zE_mail' 	=> $mail,
						'zType_Chantier' 	=> $ty,
						'zPrix_Total' 	=> $prix,
						'za'   => $ser,
						'zstri'   => $stri
						
						
					));

					

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' SAV Bien Inserer</div>';

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
             

			$stmt = $con->prepare("SELECT * FROM sav WHERE ID_Sav = ?");

			

			$stmt->execute(array($catid));

			

			$cat = $stmt->fetch();

			

			$count = $stmt->rowCount();

			

			if ($count > 0) { ?>

				        <h1 class="text-center"> Modifier SAV</h1>
         
		<form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid ?>" />
		<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Détails intervention 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				      

					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Intervenant</label>
						<div class="col-sm-10 col-md-6">
							<select name="intervenant">
									<?php
										$allCats = getAllFrom("*", "members", "","", "ID_Member", "ASC");
										foreach ($allCats as $catt) {
											echo "<option value='" . $catt['ID_Member'] . "'";
											if ($cat['b'] == $catt['ID_Member']) { echo ' selected'; }
											echo ">" . $catt['Nom_Member'] . "</option>";
											}
										
									?>
								</select>
						</div>
					</div>
				
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label">Etat</label>
           <div class="col-sm-10  col-md-6">
                         <div class="choix">
             	            <input id="ads-yes" type="radio" name="etat" value="0" <?php if($cat['Intervenant_Etat']==0){echo 'checked';}  ?>/>
             	            <label for="ads-yes">Normal</label>
                         </div>
                          <div class="choix">
             	            <input id="ads-no" type="radio" name="etat" value="1" <?php if($cat['Intervenant_Etat']==1){echo 'checked';}  ?>/>
             	            <label for="ads-no">Urgente</label>
                         </div>
                         <div class="choix">
             	            <input id="ads-no" type="radio" name="etat" value="2" <?php if($cat['Intervenant_Etat']==2){echo 'checked';}  ?>/>
             	            <label for="ads-no">Trés Urgente</label>
                         </div>
           </div>
     </div>
       
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			



	<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Société/Client Détails
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				      
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom(société/Client)</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name_client" class="form-control"  value="<?php echo $cat['Nom_Client']; ?>" required="required" autocomplete="on"  placeholder="ecrire ici le nom de (société/Client)" />
						</div>
					</div>
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Liew/Adresse</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="adresse" class="form-control" value="<?php echo $cat['Adresse']; ?>" required="required" autocomplete="on" placeholder="ecrire ici l'adresse" />
						</div>
					</div>

					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Date d'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="date_inter" class="form-control" value="<?php echo $cat['Date_Intervention']; ?>" required="required" autocomplete="off" placeholder="jj/mm/aaaa" />
						</div>
					</div>
				
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Heure d'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="heure_inter" class="form-control" value="<?php echo $cat['Heure_Intervention']; ?>" required="required" autocomplete="off" placeholder="hh:mm" />
						</div>
					</div>
				
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Durée D'inter</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="duree_inter" class="form-control" value="<?php echo $cat['Duree_Intervention']; ?>" required="required" autocomplete="off" placeholder="ecrire ici durée d'intervention" />
						</div>
					</div>
		
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Nom de contact</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="nom_contact" class="form-control" value="<?php echo $cat['Nom_Contact']; ?>" required="required" placeholder="ecrire ic le nom de contact" />
						</div>
					</div>
		
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tel/fax</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="tel" class="form-control" value="<?php echo $cat['tel_Fax']; ?>" placeholder="ecrire ic le tel ou fax num" />
						</div>
					</div>
		
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">E-mail</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="mail" class="form-control" value="<?php echo $cat['E_mail']; ?>" placeholder="ecrire ici l'E_mail" />
						</div>
					</div>
					
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			













				<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Services et Type 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					
				      
					
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Service</label>
						<div class="col-sm-10 col-md-6">
						<select name="ser">
									<?php
										$allCats = getAllFrom("*", "services", "","", "ID_Service", "ASC");
										foreach ($allCats as $catt) {
											echo "<option value='" . $catt['ID_Service'] . "'";
											if ($cat['a'] == $catt['ID_Service']) { echo ' selected'; }
											echo ">" . $catt['Nom'] . "</option>";
											
										}
									?>
								</select>
						</div>
					</div>
			
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Type Chantier</label>
						<div class="col-sm-10 col-md-6">
							<select name="ty">
									<option value="1" <?php if  ($cat['Type_Chantier']==1)    {echo 'selected';}  ?>>Création</option>
									<option value="2" <?php if ($cat['Type_Chantier'] == 2) { echo 'selected'; } ?>>Entretien</option>
									<option value="3" <?php if ($cat['Type_Chantier'] == 3) { echo 'selected'; } ?>>Rénovation</option>
									<option value="4" <?php if ($cat['Type_Chantier'] == 4) { echo 'selected'; } ?>>Maintenance de matériel</option>
									<option value="5" <?php if ($cat['Type_Chantier'] == 5) { echo 'selected'; } ?>>présentation</option>
									<option value="6" <?php if ($cat['Type_Chantier'] == 6) { echo 'selected'; } ?>>Amélioration</option>
									<option value="7" <?php if ($cat['Type_Chantier'] == 7) { echo 'selected'; } ?>>Modification</option>
									<option value="8" <?php if ($cat['Type_Chantier'] == 8) { echo 'selected'; } ?>>Reconfiguration</option>
									<option value="9" <?php if ($cat['Type_Chantier'] == 9) { echo 'selected'; } ?>>intégration Software</option>
									<option value="10" <?php if ($cat['Type_Chantier'] == 10) { echo 'selected'; } ?>>Formation</option>
								</select>
						</div>
					</div>
					
					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			
			
	

<div class="home-stats">
		<div class="container SAV-container">
	      <div class="row SAV-row">
	       <div class="col-sm-6 SAV-col">					                                        
			<div class="panel panel-default  SAV-default">
              <div class="panel-heading SAV">
			   <i class="fa fa-tag SAV-i"></i> Matériels 
                <span class="toggle-info pull-right">
				 <i class="fa fa-plus fa-lg"></i>
				  </span>
				  </div>
			     <div class="panel-body">
                <ul class="list-unstyled latest-users">
									                                                                                            
					

						 
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label">Maintenance</label>
           <div class="col-sm-10  col-md-6">
            
              <div>
             	<input id="ads-no" type="radio" name="maint" value="1" <?php if($cat['Maintenance']==1){echo 'checked';}  ?>/>
             	<label for="ads-no">Yes</label>
             </div>
                          <div>
             	<input id="ads-no" type="radio" name="maint" value="0" <?php if($cat['Maintenance']==0){echo 'checked';}  ?>/>
             	<label for="ads-no">No</label>
             </div>
             
                     


           </div>
     </div>
     



					 
     <div class ="form-group form-group-lg">
           <label class ="col-sm-2 control-label"></label>
           <div class="col-sm-10  col-md-6">
                         <div class="choix">
             	            <input id="ads-yes" type="radio" name="garantie" value="0" <?php if($cat['Garantie']==0){echo 'checked';}  ?>/>
             	            <label for="ads-yes">Hors Garantie</label>
                         </div>
                          <div class="choix">
             	            <input id="ads-no" type="radio" name="garantie" value="1" <?php if($cat['Garantie']==1){echo 'checked';}  ?>/>
             	            <label for="ads-no"> Garantie</label>
                         </div>
           </div>
     </div>
     


       
			
					

       			 
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							
							<textarea type="text" name="description" placeholder="laisser cette ligne vide et ecrire à-partir de la suivante"rows="6" cols="100" >
								<?php echo $cat['Description'];?></textarea>
								
							</div>
						</div>
					</div>

							<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Prix Total(TTC)</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="prix"  value="<?php echo $cat['Prix_Total']; ?>" placeholder="Nom Of The Category" />
						</div>
					</div>
					




					
					
					
								                                   </ul>
				                                                   </div>
						                                            </div>
						                                            </div>
					                                                </div>	   
					                                                </div>
	                                                               </div>
	                                                               </div>			




      
     <div class ="form-group">           
           <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Save Service" class="btn btn-primary btn-lg">
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

			echo "<h1 class='text-center'>mise à jour SAV</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			
            
               


             $maint = $_POST['maint'];
            $intervenant 		= $_POST['intervenant'];
				$etat 		= $_POST['etat'];
				$mail 		= $_POST['mail'];
				$ser 		= $_POST['ser'];
				$ty 		= $_POST['ty'];
				$garantie 		= $_POST['garantie'];
				$tel 		= $_POST['tel'];
				$name_client 		= $_POST['name_client'];
				$adresse 		= $_POST['adresse'];
				$date_inter 		= $_POST['date_inter'];
				$heure_inter 		= $_POST['heure_inter'];
				$duree_inter 		= $_POST['duree_inter'];
				$nom_contact 		= $_POST['nom_contact'];
				$description 		= $_POST['description'];
				
				$prix 		= $_POST['prix'];
				$catid 		= $_POST['catid'];



                $str01 = str_replace("/","",$_POST['date_inter']);
				$str11 = $str01;
                $str2_01 =substr($str11,4,4);
                $str2_11 =substr($str11,2,2);
                $str2_21 =substr($str11,0,2);
                $str2_s1 = $str2_01.$str2_11.$str2_21;
                 $stri1 =(int)($str2_s1);


            $stmt = $con->prepare("UPDATE 
											sav 
										SET 
										    Num_Date = ?,
										    a = ? ,
											Description= ?,
							                Maintenance= ?,
							                Garantie= ?,
							                b= ?,
							                Intervenant_Etat= ?,
							                Nom_Client= ?,
							                Adresse= ?,
							                Date_Intervention= ?,
							                Heure_Intervention= ?,
							                Duree_Intervention= ?,
							                Nom_Contact= ?,
							                tel_Fax= ?,
							                E_mail= ?,
							                Type_Chantier= ?,
							                Prix_Total=?
											
										WHERE 
											ID_Sav = ?");

$stmt->execute(array($stri1,$ser,$description, $maint, $garantie, $intervenant, $etat,$name_client,$adresse,$date_inter,$heure_inter,$duree_inter,$nom_contact,$tel,$mail,$ty,$prix,$catid));
                

				$theMsg = "<div class='alert alert-success'>" . ' mise à jour bien effectué</div>';

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

				$check = checkItem('ID_Sav', 'sav', $catid);

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM sav WHERE ID_Sav = :zid");

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

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); 

?>