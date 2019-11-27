--
-- base de donn�es: 'baseavion'
--
create database if not exists baseeleve default character set utf8 collate utf8_general_ci;
use baseeleve;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table eleve
drop table if exists eleve;
create table eleve (
	ev_id int not null auto_increment primary key,
	ev_nom varchar(50) not null,
	ev_dt_naissance date
)engine=innodb;

-- table matiere
drop table if exists matiere;
create table matiere (
	ma_id int not null auto_increment primary key,
	ma_nom varchar(50) not null
)engine=innodb;

-- table note
drop table if exists note;
create table note (
	no_id int not null auto_increment primary key,
	no_eleve int not null,
	no_matiere int not null,
	no_valeur float not null,
	no_date date,
	unique key eleve_matiere (no_eleve,no_matiere)
)engine=innodb; 


-- contraintes
alter table note add constraint cs1 foreign key (no_eleve) references eleve(ev_id) on delete cascade;
alter table note add constraint cs2 foreign key (no_matiere) references matiere(ma_id) on delete cascade;

set foreign_key_checks = 1;

-- jeu de données

