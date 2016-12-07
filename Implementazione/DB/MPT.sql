-- drop database if exists MPT;
-- create database MPT;
-- use MPT;

create table utente(
	ute_nome varchar(30),
	ute_cognome varchar(30),
	ute_email varchar(50) primary key,
	ute_password varchar(50),
    ute_dataIscrizione datetime,
    ute_gestoreEmail int default null,
	ute_temppassword int default 1,
	ute_docente int default 1,
	ute_amministratore int default null,
	ute_responsabile int default null
);

create table materia(
	mat_id int primary key auto_increment,
	mat_nome varchar(30) unique	
);

create table corso(
	cor_id int primary key auto_increment,
	cor_nome varchar(30) unique,
	cor_durata int
);

create table classe(
	cla_id int primary key auto_increment,
	cla_nome varchar(30) unique
);

/*create table mat_app_cor(
	mat_id int,
	cor_id int,
	primary key(mat_id,cor_id),
	foreign key(mat_id) references materia(mat_id),
	foreign key(cor_id) references corso(cor_id)
);
*/

create table cla_fre_cor(
	cla_id int,
	cor_id int,
	primary key(cla_id,cor_id),
	foreign key(cla_id) references classe(cla_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION,
	foreign key(cor_id) references corso(cor_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION
);

create table pianifica(
	ute_email varchar(50),
	cla_id int,
	mat_id int,
	cor_id int,
	pia_ini_anno int,
	pia_fin_anno int,
	pia_ore_tot int,
	pia_ore_AIT int,
	primary key(ute_email,cla_id,mat_id,pia_ini_anno,cor_id),
	foreign key(ute_email) references utente(ute_email)
	ON UPDATE CASCADE
	ON DELETE NO ACTION,
	foreign key(cla_id) references classe(cla_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION,
	foreign key(mat_id) references materia(mat_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION,
	foreign key(cor_id) references corso(cor_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION
);	
