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
        <?php
        //création des élèves
        $nbeleves = 50;
        echo "<h1>Création des élèves</h1>";
        for ($i = 1; $i <= $nbeleves; $i++) {
            $annee = rand(2000, 2005);
            $mois = rand(1, 12);
            if ($mois < 10)
                $mois = "0" . $mois;
            $jour = rand(1, 26);
            if ($jour < 10)
                $jour = "0" . $jour;
            $sql = "insert into eleve values (null,'nom $i', '$annee-$mois-$jour')";
            if (!mysqli_query($link, $sql)) {
                echo "<p>$sql</p>";
                echo mysqli_error($link);
                exit;
            }
        }

        //création des matières : 4
        echo "<h1>Création des matieres</h1>";
        $matiere = ["Informatique", "Géographie", "Français", "Sport"];
        foreach ($matiere as $valeur) {
            $sql = "insert into matiere values (null,'$valeur')";
            if (!mysqli_query($link, $sql)) {
                echo "<p>$sql</p>";
                echo mysqli_error($link);
                exit;
            }
        }

        //création des notes : 
        echo "<h1>Création des notes</h1>";
        for ($i = 1; $i <= $nbeleves; $i++) {
            for ($j = 1; $j <= count($matiere); $j++) {
                $n = rand(0, 20);
                $sql = "insert into note values (null,'$i','$j',$n,'2019-10-20')";
                if (!mysqli_query($link, $sql)) {
                    echo "<p>$sql</p>";
                    echo mysqli_error($link);
                    exit;
                }
            }
        }
        ?>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>