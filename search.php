<?php

ob_start(); 

	session_start();

	$pageTitle = 'Recherche SAV';

	if (isset($_SESSION['Nom_Member'])) {


include 'init.php';

    $query = $_GET['query']; 
    
    
    
     
    $min_length = 3;
    
    if(strlen($query) >= $min_length){ 
         
        $query = htmlspecialchars($query); 
        
       
         
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (`Nom_Client` LIKE '%".$query."%') OR (`Description` LIKE '%".$query."%')
            OR (`Adresse` LIKE '%".$query."%')
            OR (`Date_Intervention` LIKE '%".$query."%')
            OR (`Duree_Intervention` LIKE '%".$query."%')
            OR (`Nom_Contact` LIKE '%".$query."%')
            OR (`tel_Fax` LIKE '%".$query."%')
            OR (`Prix_Total` LIKE '%".$query."%')
            OR (`E_mail` LIKE '%".$query."%')
            OR (`Heure_Intervention` LIKE '%".$query."%')

            ");
             $raw_results->execute();
       
         $count = $raw_results->rowCount();
        

 ?>
<h1 class="text-center">Resultat de Recherche</h1>
			<div class="container categories">
				      
  
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
						if($count > 0){
							while($results=$raw_results->fetch()){ 
								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='sav.php?do=Edit&catid=" . $results['ID_Sav'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Modifier</a>";
										echo "<a href='sav.php?do=Delete&catid=" . $results['ID_Sav'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Suprimer</a>";
									echo "</div>";
									echo "<h3>";
									$allCats = getAllFrom("*", "members", "","", "ID_Member", "ASC");
									foreach ($allCats as $catt) {									
									if ($results['b'] == $catt['ID_Member']){echo 'Inter : '. $catt['Nom_Member'].' | Date_Inter : '.$results['Date_Intervention'].' | Nom_Client : ' .$results['Nom_Client'];}
                                     }


									 echo '</h3>';
									echo "<div class='full-view'>"; 
										echo "<p>";
										echo 'Service : ';
										 $allser = getAllFrom("*", "services", "","", "ID_Service", "ASC");
										 foreach ($allser as $catt) {									
									if ($results['a'] == $catt['ID_Service']){echo $catt['Nom'] ;}
								             }
								             echo '|';echo 'Type de chantier : ';


                                                      if  ($results['Type_Chantier']==1)    {echo 'Création';} 
								               if ($results['Type_Chantier'] == 2) { echo 'Entretien'; } 
								               if ($results['Type_Chantier'] == 3) { echo 'Rénovation'; }
								               if ($results['Type_Chantier'] == 4) { echo 'Maintenance de matériel'; }
								               if ($results['Type_Chantier'] == 5) { echo 'présentation'; }
								               if ($results['Type_Chantier'] == 6) { echo 'Amélioration'; }
								              if ($results['Type_Chantier'] == 7) { echo 'Modification'; }
									              if ($results['Type_Chantier'] == 8) { echo 'Reconfiguration'; }
									              if ($results['Type_Chantier'] == 9) { echo 'intégration Software'; }
									               if ($results['Type_Chantier'] == 10) { echo 'Formation'; }

										  echo "</p>";
										if($results['Maintenance'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Maintenance </span>'; } 
										if($results['Garantie'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i>Garantie</span>'; }
										if($results['Garantie'] == 0) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i>Hors Garantie</span>'; }  
									echo "</div>";

								

								echo "</div>";
								echo "<hr>";
							}}else{ 
            echo "Pas de resultat";
        }
						?>
					</div>
				</div>
		 		
				
			</div>


      <?php

          }
    else {

				echo "<div class='container'>";

				echo'<div class="alert alert-info"> Il fout ecrire plus que 2 characters </div>';

				

				echo "</div>";

			}






include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); 

?>