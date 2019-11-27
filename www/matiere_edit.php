<?php
require "../_include/inc_config.php";
var_dump($_POST);
if (isset($_POST["supprimer"]) and $_POST["supprimer"]==1) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    $sql="delete from matiere where ma_id=$ma_id";
    requeteSQL($link,$sql);
    header("location:index.php");

} else if (isset($_POST["btsubmit"])) {
    //échappe les caractères spéciaux du SQL
    $_POST=array_map("cb_mres",$_POST);
    extract($_POST);  
    if ($ma_id==0)
        $sql = "insert into matiere values (null,'$ma_nom')";
    else
        $sql = "update matiere set ma_nom='$ma_nom' where ma_id=$ma_id";        
    
    requeteSQL($link,$sql);
    header("location:index.php");
} else {
    extract($_GET);
    if ($id > 0) { //UPDATE
        $sql = "select * from matiere where ma_id=$id";
        $result = requeteSQL($link,$sql);
        $row = mysqli_fetch_assoc($result);
        extract($row);
    } else { //INSERT
        $ma_id=0;
        $ma_nom="";
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
        <h1>Edition d'une matière</h1>
        <form method="post" id="f1">
            <input type='hidden' name='ma_id' id='ma_id' value='<?=$ma_id ?>'>
			<input type='hidden' name='supprimer' id='supprimer' value='0'>
            <p>
                <label for='ma_nom'>ma_nom</label>
                <input type='text' name='ma_nom' id='ma_nom' required value='<?= htmlentities($ma_nom,ENT_QUOTES,"utf-8") ?>'>
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
            let supprimer=document.getElementById("supprimer");
            supprimer.value="1";
            let f1=document.getElementById("f1");
			f1.submit();
		}
	}
</script>

</html>