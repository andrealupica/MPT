-- drop database if exists MPT;
-- create database MPT;
-- use MPT;

create table utente(
	ute_nome varchar(30),
	ute_cognome varchar(30),
	ute_email varchar(50) primary key,
	ute_password varchar(50),
    ute_dataIscrizione datetime default '0000-00-00 00:00:00',
    ute_gestoreEmail int default null,
	ute_temppassword int default 1,
	ute_docente int default 1,
	ute_amministratore int default null,
	ute_responsabile int default null,
	ute_flag int default 1
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


create table cla_fre_cor(
	cla_id int,
	cor_id int,
	primary key(cla_id,cor_id),
	foreign key(cla_id) references classe(cla_id)
	ON UPDATE CASCADE 
	ON DELETE NO ACTION,
	foreign key(cor_id) references corso(cor_id)
	ON UPDATE CASCADE 
	ON DELETE CASCADE
);

create table pianifica(
	pia_id int primary key auto_increment,
	ute_email varchar(50),
	cla_id int,
	mat_id int,
	cor_id int,
	pia_ini_anno int,
	pia_fin_anno int,
	pia_ore_tot int,
	pia_ore_AIT int,
	pia_sem int,
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

create table log_(
	log_id int primary key auto_increment,
	ute_email varchar(50),
	log_data timestamp default NOW(),
	log_descrizione text,
	log_pagina varchar(50),
	log_azione varchar(20),
	foreign key(ute_email) references utente(ute_email)
	ON UPDATE CASCADE
	ON DELETE NO ACTION
);

create table allievo(
	all_id int primary key auto_increment,
	all_nome varchar(50),
	all_birthday date,
	all_info text,
	all_flag int default 1,
	cla_id int,
	cor_id int,
	foreign key(cla_id) references classe(cla_id)
	ON UPDATE CASCADE
	ON DELETE NO ACTION,
	foreign key(cor_id) references classe(cor_id)
	ON UPDATE CASCADE
	ON DELETE NO ACTION
);

create table tema(
	tem_id int primary key auto_increment,
	tem_titolo varchar(50),
	tem_descrizione text,
	tem_valutazione text,
	tem_flag int default 1
);

create table propone(
	tem_id int,
	mat_id int,
	primary key(tem_id,mat_id),
	foreign key(tem_id) references tena(tem_id)
	ON UPDATE CASCADE
	ON DELETE NO ACTION,
	foreign key(mat_id) references materia(mat_id)
	ON UPDATE CASCADE
	ON DELETE NO ACTION
);