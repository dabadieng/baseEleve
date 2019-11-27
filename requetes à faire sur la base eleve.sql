-- Moyenne des notes
select avg(no_valeur)
from note;

-- Moyenne des notes par matiere
select ma_nom, avg(no_valeur) moyenne
from note, matiere
where no_matiere=ma_id
group by ma_id;

-- liste les matieres sans note
select ma_nom, avg(no_valeur) moyenne
from matiere left join note
on no_matiere=ma_id
group by ma_id;

-- Moyenne des notes par eleve
select ev_nom, avg(no_valeur) moyenne
from note, eleve
where no_eleve=ev_id
group by ev_id;

-- Moyenne des notes par années de naissance
select year(ev_dt_naissance) annee, avg(no_valeur) moyenne
from note,eleve
where no_eleve=ev_id
group by annee;

-- Moyenne des notes par matiere et par années de naissance
select ma_nom, year(ev_dt_naissance) annee, avg(no_valeur) moyenne
from note,eleve,matiere
where no_eleve=ev_id and no_matiere=ma_id
group by ma_id,annee;

-- avec jointure gauche à 3 tables
select ma_nom, year(ev_dt_naissance) annee, avg(no_valeur) moyenne
from matiere left join note inner join eleve
on no_eleve=ev_id on no_matiere=ma_id
group by ma_id,annee;

-- Pour chaque matiere, nombre d'eleve ayant une note >= à la moyenne
select ma_nom, count(no_eleve) 
from matiere, note 
where ma_id=no_matiere and no_valeur>=(select avg(no_valeur) from note) 
group by ma_id;

-- Nombre d'éléve par année de naissance
select year(ev_dt_naissance) annee, count(ev_id) nb
from eleve
group by annee; 

-- Nombre de note égale à 0, et nombre de note égale à 20
select no_valeur, count(no_valeur) nb
from note
where no_valeur=0 or no_valeur=20
group by no_valeur;

-- Nombre de note égale à 0, et nombre de note égale à 20 par matiere
select ma_nom, no_valeur, count(no_valeur) nb
from note, matiere
where no_matiere=ma_id and (no_valeur=0 or no_valeur=20)
group by ma_id,no_valeur;

-- Nombre de note égale à 0, et nombre de note égale à 20 par matiere et par année de naissance
select ma_nom, year(ev_dt_naissance) annee, no_valeur, count(no_valeur) nb
from note, matiere, eleve
where no_eleve=ev_id and no_matiere=ma_id and (no_valeur=0 or no_valeur=20)
group by ma_id, annee, no_valeur;

-- Nombre d'élève n'ayant pas de note par matière.
select count(ev_id)
from eleve
where ev_id not in (select no_eleve from note);


select ma_nom, count(distinct no_eleve) nb
from matiere left join note inner join eleve
on no_eleve=ev_id on ma_id=no_matiere;

-- Classement des élèves selon leur moyenne générale
select ev_nom, avg(no_valeur) moyenne
from eleve, note
where ev_id=no_eleve
group by ev_id
order by moyenne desc;