#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: groupes
#------------------------------------------------------------

CREATE TABLE groupes(
        id          Int  Auto_increment  NOT NULL ,
        nom         Varchar (20) NOT NULL ,
        description Varchar (20) NOT NULL
	,CONSTRAINT groupes_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: utilisateurs
#------------------------------------------------------------

CREATE TABLE utilisateurs(
        id           Int  Auto_increment  NOT NULL ,
        login        Varchar (20) NOT NULL ,
        mot_de_passe Varchar (20) NOT NULL ,
        nom_complet  Varchar (50) NOT NULL ,
        age          Int NOT NULL ,
        code_postal  Int NOT NULL ,
        telephone    Int NOT NULL ,
        metier       Varchar (10) NOT NULL ,
        id_groupes   Int NOT NULL
	,CONSTRAINT utilisateurs_PK PRIMARY KEY (id)

	,CONSTRAINT utilisateurs_groupes_FK FOREIGN KEY (id_groupes) REFERENCES groupes(id)
)ENGINE=InnoDB;

