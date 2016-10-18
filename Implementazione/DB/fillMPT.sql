insert into materia(mat_nome) values('italiano');
insert into materia(mat_nome) values('tedesco');
insert into materia(mat_nome) values('inglese');
insert into materia(mat_nome) values('matematica');
insert into materia(mat_nome) values('fisica');
insert into materia(mat_nome) values('chimica');
insert into materia(mat_nome) values('biologia');
insert into materia(mat_nome) values('storia');
insert into materia(mat_nome) values('economia');

insert into corso(cor_id,cor_nome,cor_durata) values(1,'MP1 SPAI con AU',4);
insert into corso(cor_id,cor_nome,cor_durata) values(2,'MP2 SPAI senza AU',4);
insert into corso(cor_id,cor_nome,cor_durata) values(3,'MP1 SPAI (MPI)',3);
insert into corso(cor_id,cor_nome,cor_durata) values(4,'MP1 SAMT Info',4);
insert into corso(cor_id,cor_nome,cor_durata) values(5,'MP1 SAMT EM',4);
insert into corso(cor_id,cor_nome,cor_durata) values(6,'MP1 SAMT Disegno',4);
insert into corso(cor_id,cor_nome,cor_durata) values(7,'MP1 SAMT Chimica',3);
insert into corso(cor_id,cor_nome,cor_durata) values(8,'MP2 Tecnica (CPQ)',1);
insert into corso(cor_id,cor_nome,cor_durata) values(9,'MP2 Natura (CPQ)',1);

insert into utente(ute_nome,ute_cognome,ute_email,ute_password,ute_amministratore,ute_gestoreEmail) values('nome','cognome','andrea.lupica@samtrevano.ch','1a1dc91c907325c69271ddf0c944bc72',1,1);
insert into utente(ute_nome,ute_cognome,ute_email,ute_password,ute_amministratore) values('nome','cognome','nome.cognome@edu.ti.ch','1a1dc91c907325c69271ddf0c944bc72',1);

insert into classe(cla_id,cla_nome) values(1,'1');
insert into classe(cla_id,cla_nome) values(2,'2');
insert into classe(cla_id,cla_nome) values(3,'3');
insert into classe(cla_id,cla_nome) values(4,'4');

insert into cla_fre_cor(cor_id,cla_id) values(1,1);
insert into cla_fre_cor(cor_id,cla_id) values(2,1);
insert into cla_fre_cor(cor_id,cla_id) values(3,1);
insert into cla_fre_cor(cor_id,cla_id) values(4,1);
insert into cla_fre_cor(cor_id,cla_id) values(1,2);
insert into cla_fre_cor(cor_id,cla_id) values(2,2);
insert into cla_fre_cor(cor_id,cla_id) values(3,2);
insert into cla_fre_cor(cor_id,cla_id) values(3,3);
insert into cla_fre_cor(cor_id,cla_id) values(9,1);
insert into cla_fre_cor(cor_id,cla_id) values(8,2);
