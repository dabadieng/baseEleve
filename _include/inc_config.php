<?php
const MODE_PROD=false;
session_start();
$link = mysqli_connect("localhost", "root", "", "baseeleve");
mysqli_set_charset($link , 'utf8');
$nomApplication = "Base élève";
$menu=array(
    ["eleve_edit.php?id=0","Nouvel élève"],
    ["matiere_edit.php?id=0","Nouvelle matière"],
    ["creerdatabase.php","RAZ BDD"],
    ["dataset.php","jeu de données"]
);

require "inc_fonction.php";
?>