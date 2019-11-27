<?php
require "../_include/inc_config.php";
var_dump($_POST);
if (isset($_POST["supprimer"]) and $_POST["supprimer"]==1) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    $sql="delete from eleve where ev_id=$ev_id";
    requeteSQL($link,$sql);
    header("location:index.php");

} else if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    if ($ev_id==0)
        $sql = "insert into eleve values (null,'$ev_nom','$ev_dt_naissance')";
    else
        $sql = "update eleve set ev_nom='$ev_nom',ev_dt_naissance='$ev_dt_naissance' where ev_id=$ev_id";        
    
    requeteSQL($link,$sql);
    header("location:index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from eleve where ev_id=$id";
        $result = requeteSQL($link,$sql);
        $row = mysqli_fetch_assoc($result);
        extract($row);
    } else { //INSERT
        $ev_id=0;
        $ev_nom="";
        $ev_dt_naissance="";
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
        <h1>Edition d'un élève</h1>
        <form method="post" id="f1">
            <input type='hidden' name='ev_id' id='ev_id' value='<?=$ev_id ?>'>
			<input type='hidden' name='supprimer' id='supprimer' value='0'>
            <p>
                <label for='ev_nom'>ev_nom</label>
                <input type='text' name='ev_nom' id='ev_nom' required value='<?= htmlentities($ev_nom,ENT_QUOTES,"utf-8") ?>'>
            </p>            
            <p>
                <label for='ev_dt_naissance'>ev_dt_naissance</label>
                <input type='text' name='ev_dt_naissance' id='ev_dt_naissance' placeholder='aaaa-mm-dd' required value='<?= htmlentities($ev_dt_naissance,ENT_QUOTES,"utf-8") ?>'>
            </p>            
            <input type="button" onclick="validation()" name="btsuppression" value="Supprimer">&nbsp;<input type="button" onclick="document.location='index.php'" value="retour">&nbsp;<input type="submit" name="btsubmit" value="Enregistrer">
        </form>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>
<script>
	function validation() {		
		let reponse = confirm("Etes vous sûr de vouloir supprimer cette matière ?");
		if (reponse) {
			supprimer.value="1";
			f1.submit();
		}
	}
</script>

</html>