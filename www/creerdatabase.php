<?php
require "../_include/inc_config.php";
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
        <h1>Création de la BDD</h1>
		<pre>
        <?php
		$sql=file_get_contents("../creation_base_eleve.sql");
		echo $sql;
		if (!mysqli_multi_query($link, $sql)) {
			echo "<p>$sql</p>";
			echo mysqli_error($link);
			exit;
		}        
        ?>
		</pre>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>