<?php

ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Filter SAV';

	if (isset($_SESSION['Nom_Member'])) {

include 'init.php';
       
       $query1 = $_GET['intervenant']; 
       $query2 = $_GET['ser']; 
       $query3 = $_GET['ty'];
       $query4 = $_GET['gar'];
       $date_d = $_GET['date_d'];
       $date_f = $_GET['date_f'];
       
    $fstr0 = str_replace("/","",$date_f);
    $fstr1 = $fstr0;
    $fstr2_0 =substr($fstr1,4,4);
    $fstr2_1 =substr($fstr1,2,2);
    $fstr2_2 =substr($fstr1,0,2);
    $fstr2_s = $fstr2_0.$fstr2_1.$fstr2_2;
    $fstri =(int)($fstr2_s);
   


     $dstr0 = str_replace("/","",$date_d);
    $dstr1 = $dstr0;
    $dstr2_0 =substr($dstr1,4,4);
    $dstr2_1 =substr($dstr1,2,2);
    $dstr2_2 =substr($dstr1,0,2);
    $dstr2_s = $dstr2_0.$dstr2_1.$dstr2_2;
    $dstri =(int)($dstr2_s);

    
    if($dstri<$fstri){
       $min = $dstri;
       $max = $fstri;

    }else{
        $min = $fstri;
       $max = $dstri;
    }
  

       
        if(($query1!=0)&&($query2!=0)&&($query3!=0)&&($query4==-1)&&($max!=0)){  //11101
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2) AND(Type_Chantier = $query3)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2==0)&&($query3!=0)&&($query4==-1)&&($max!=0)){  //0011
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE(Type_Chantier = $query3)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3==0)&&($query4==-1)&&($max!=0)){ //
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3==0)&&($query4==-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1)AND (Num_Date < $max) AND(Num_Date > $min) ");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2!=0)&&($query3==0)&&($query4==-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3!=0)&&($query4==-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2) AND(Type_Chantier = $query3)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3!=0)&&($query4==-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND(Type_Chantier = $query3)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }




        elseif(($query1!=0)&&($query2!=0)&&($query3!=0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2) AND(Type_Chantier = $query3)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2==0)&&($query3!=0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE(Type_Chantier = $query3)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3==0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3==0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1)AND(Garantie = $query4)AND(Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2!=0)&&($query3==0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3!=0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2) AND(Type_Chantier = $query3)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3!=0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND(Type_Chantier = $query3)AND(Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2==0)&&($query3==0)&&($query4!=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (Garantie = $query4)AND (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2==0)&&($query3==0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
             
         }

          
          elseif(($query1==0)&&($query2==0)&&($query3==0)&&($query4=-1)&&($max!=0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (Num_Date < $max) AND(Num_Date > $min)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
             
         }


            elseif(($query1!=0)&&($query2!=0)&&($query3!=0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2) AND(Type_Chantier = $query3)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
             
         }
         elseif(($query1==0)&&($query2==0)&&($query3!=0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE(Type_Chantier = $query3)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3==0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3==0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2!=0)&&($query3==0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3!=0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2) AND(Type_Chantier = $query3)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3!=0)&&($query4==-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND(Type_Chantier = $query3)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }




        elseif(($query1!=0)&&($query2!=0)&&($query3!=0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2) AND(Type_Chantier = $query3)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2==0)&&($query3!=0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE(Type_Chantier = $query3)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3==0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3==0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1)AND(Garantie = $query4) ");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2!=0)&&($query3==0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND (a = $query2)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1==0)&&($query2!=0)&&($query3!=0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (a = $query2) AND(Type_Chantier = $query3)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
         elseif(($query1!=0)&&($query2==0)&&($query3!=0)&&($query4!=-1)&&($max==0)){
        $raw_results = $con ->prepare("SELECT * FROM sav
            WHERE (b = $query1) AND(Type_Chantier = $query3)AND(Garantie = $query4)");
             $raw_results->execute();
             $count = $raw_results->rowCount();
         }
        
         


//**************
         else{$count = 0;}

       
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

          
   





include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); 

?>

