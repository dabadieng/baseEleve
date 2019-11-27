<?php
require "../_include/inc_config.php";
//tableau des notes [id eleve][id matiere]
$sql="select * from note";
$result=requeteSQL($link, $sql);
$note=[];
while ($row=mysqli_fetch_assoc($result)) {
	$row=array_map("cb_htmlentities",$row);
	extract($row);
	$note[$no_eleve][$no_matiere]=$no_valeur;
}

//moyenne par élève
$sql="select no_eleve, avg(no_valeur) moyenne from note group by no_eleve";
$result=requeteSQL($link, $sql);
$moyenneEleve=[];
while ($row=mysqli_fetch_assoc($result)) {
	extract($row);
	$moyenneEleve[$no_eleve]=$moyenne;
}

//moyenne par matiere
$sql="select no_matiere, avg(no_valeur) moyenne from note group by no_matiere";
$result=requeteSQL($link, $sql);
$moyenneMatiere=[];
while ($row=mysqli_fetch_assoc($result)) {
	extract($row);
	$moyenneMatiere[$no_matiere]=$moyenne;
}

//moyenne globale
$sql="select avg(no_valeur) moyenne from note";
$result=requeteSQL($link, $sql);
$row=mysqli_fetch_assoc($result);
$moyenneGlobale=$row["moyenne"];

?>
<!DOCTYPE html>
<html>

<head>
    <?php require "../_include/inc_head.php" ?>
</head>

<body>
    <header>
        <?php require "../_include/inc_entete.php" ?>
    </header>
    <nav>
        <?php require "../_include/inc_menu.php"; ?>
    </nav>
    <div id="contenu">
        <h1>Bienvenu sur le CRUD de la base élève</h1>           
        <table>
            <caption>Tableau des notes</caption>
            <thead>
                <tr>
                    <th scope="col">élèves</th>
                    <?php
                    //liste des matières en entete de colonne
					$sql="select * from matiere";
					$result = requeteSQL($link, $sql);	
					$matiere=[];					
                    while ($row=mysqli_fetch_assoc($result)) {
						$row=array_map("cb_htmlentities",$row);
						$matiere[]=$row;
                        extract($row);
                        echo "<th scope='col'><a href='matiere_edit.php?id=$ma_id'>$ma_nom</a></th>";
                    }
                    ?>
					<th scope="col">Moyenne par élève</th>
                </tr>
				<!-- ligne des moyennes par matière -->
				<tr>
					<th scope="row">Moyenne par matière</th>
					<?php
					foreach($matiere as $mat) {
						extract($mat);
						$valeur=isset($moyenneMatiere[$ma_id]) ? number_format($moyenneMatiere[$ma_id],2) : "--";
						echo "<td>$valeur</td>";
					}
					?>
					<td><?=number_format($moyenneGlobale,2)?></td>
				</tr>
			 </thead>
			 <tbody>
				<?php														
				//liste des élèves
				$sql="select * from eleve";
				$result=requeteSQL($link, $sql);
				while ($row=mysqli_fetch_assoc($result)) {
					$row=array_map("cb_htmlentities",$row);
					extract($row);
					//création d'une ligne
					echo "<tr>";
					// nom de l'élève
					echo "<th scope='row'><a href='eleve_edit.php?id=$ev_id'>$ev_nom</a></th>";
					//Affichage des notes pour chaque matiere
					foreach($matiere as $mat) {
                        extract($mat);						
                        if (isset($note[$ev_id][$ma_id])) {
                            $valeur = $note[$ev_id][$ma_id];
                            if ($valeur>$moyenneMatiere[$ma_id]) {
                                $classe = "verte";
                                $sr="aria-label='note $valeur, supérieur à la moyenne'";
                            } else {
                                $classe = "rouge";
                                $sr="aria-label='note $valeur, inférieur à la moyenne'";
                            }
                        } else {
                            $valeur="Créer";
                            $classe="";
                            $sr="";
                        }                           
                        $href="note_edit.php?ev_id=$ev_id&ma_id=$ma_id";
                        echo "<td class='$classe'>";
						echo "<a href='$href' $sr>$valeur</a>";
						echo "</td>";	
					}	
					$valeur = isset($moyenneEleve[$ev_id]) ? number_format($moyenneEleve[$ev_id],2) : "--";
					echo "<th scope='row'>$valeur</th>";
					echo "</tr>";
				}
				?>
            </tbody>
        </table>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>