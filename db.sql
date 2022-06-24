#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: ligneProd
#------------------------------------------------------------

CREATE TABLE ligneProd(
        id_ligneProd  Int  Auto_increment  NOT NULL ,
        nom_ligneProd Varchar (50) NOT NULL
	,CONSTRAINT ligneProd_PK PRIMARY KEY (id_ligneProd)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: machine
#------------------------------------------------------------

CREATE TABLE machine(
        id_machine  Int  Auto_increment  NOT NULL ,
        nom_machine Varchar (50) NOT NULL
	,CONSTRAINT machine_PK PRIMARY KEY (id_machine)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: fournisseur
#------------------------------------------------------------

CREATE TABLE fournisseur(
        id_fournisseur  Int  Auto_increment  NOT NULL ,
        nom_fournisseur Varchar (50) NOT NULL
	,CONSTRAINT fournisseur_PK PRIMARY KEY (id_fournisseur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reservation
#------------------------------------------------------------

CREATE TABLE reservation(
        id_reservation        Int  Auto_increment  NOT NULL ,
        dateDebut_reservation Date ,
        dateFin_reservation   Date ,
        couleur_reservation   Char (7) NOT NULL ,
        id_ligneProd          Int NOT NULL
	,CONSTRAINT reservation_PK PRIMARY KEY (id_reservation)

	,CONSTRAINT reservation_ligneProd_FK FOREIGN KEY (id_ligneProd) REFERENCES ligneProd(id_ligneProd)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: typeTache
#------------------------------------------------------------

CREATE TABLE typeTache(
        id_typeTache  Int  Auto_increment  NOT NULL ,
        nom_typeTache Varchar (128) NOT NULL
	,CONSTRAINT typeTache_PK PRIMARY KEY (id_typeTache)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tache
#------------------------------------------------------------

CREATE TABLE tache(
        id_tache        Int  Auto_increment  NOT NULL ,
        nom_tache       Varchar (128) NOT NULL ,
        dateDebut_tache Date ,
        dateFin_tache   Date ,
        id_reservation  Int NOT NULL ,
        id_fournisseur  Int ,
        id_typeTache    Int NOT NULL
	,CONSTRAINT tache_PK PRIMARY KEY (id_tache)

	,CONSTRAINT tache_reservation_FK FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation)
	,CONSTRAINT tache_fournisseur0_FK FOREIGN KEY (id_fournisseur) REFERENCES fournisseur(id_fournisseur)
	,CONSTRAINT tache_typeTache1_FK FOREIGN KEY (id_typeTache) REFERENCES typeTache(id_typeTache)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sousTypeTache
#------------------------------------------------------------

CREATE TABLE sousTypeTache(
        id_sousTypeTache  Int  Auto_increment  NOT NULL ,
        nom_sousTypeTache Varchar (128) NOT NULL ,
        id_typeTache      Int NOT NULL
	,CONSTRAINT sousTypeTache_PK PRIMARY KEY (id_sousTypeTache)

	,CONSTRAINT sousTypeTache_typeTache_FK FOREIGN KEY (id_typeTache) REFERENCES typeTache(id_typeTache)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: utiliser
#------------------------------------------------------------

CREATE TABLE utiliser(
        id_machine   Int NOT NULL ,
        id_ligneProd Int NOT NULL
	,CONSTRAINT utiliser_PK PRIMARY KEY (id_machine,id_ligneProd)

	,CONSTRAINT utiliser_machine_FK FOREIGN KEY (id_machine) REFERENCES machine(id_machine)
	,CONSTRAINT utiliser_ligneProd0_FK FOREIGN KEY (id_ligneProd) REFERENCES ligneProd(id_ligneProd)
)ENGINE=InnoDB;

