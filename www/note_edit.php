<?php
require "../_include/inc_config.php";
if (isset($_POST["btsupprimer"])) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    $sql="delete from note where no_id=$no_id";
    requeteSQL($link,$sql);
    header("location:index.php");

} else if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    $auj=date("Y-m-d");
    if ($no_valeur<0)
        $no_valeur=0;
    if ($no_valeur>20)
        $no_valeur=20;

    if ($no_id==0)
        $sql = "insert into note values (null,'$no_eleve','$no_matiere','$no_valeur','$auj')";
    else
        $sql = "update note set no_eleve='$no_eleve',no_matiere='$no_matiere',no_valeur='$no_valeur',no_date='$auj' where no_id=$no_id";        
    
    requeteSQL($link,$sql);
    header("location:index.php");
} else {
    extract($_GET);
    $sql = "select * from note where no_eleve=$ev_id and no_matiere=$ma_id";
    $result =  requeteSQL($link,$sql);
	
	$rowcount=mysqli_num_rows($result);
	if ($rowcount==1) { //UDDATE
		$row = mysqli_fetch_assoc($result);
		extract($row);	
	} else { //INSERT
		$no_id=0;
		$no_valeur="";
	}
}
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
        <h1>Edition d'une note</h1>
        <form method="post">
            <input type='hidden' name='no_id' id='no_id' value='<?= $no_id ?>'>
			<input type='hidden' name='no_eleve' id='no_eleve' value='<?= $ev_id ?>'>
			<input type='hidden' name='no_matiere' id='no_matiere' value='<?= $ma_id ?>'>
            <p>
                <label for='no_valeur'>Note</label>
                <input type='number' min="0" max="20" step="0.1" name='no_valeur' id='no_valeur' required value='<?= htmlentities($no_valeur,ENT_QUOTES,"utf-8") ?>'>
            </p>            
            <input type="submit" name="btsupprimer" value="Supprimer">&nbsp;<input type="submit" name="btsubmit" value="Enregistrer">
        </form>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>