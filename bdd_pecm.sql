-- -----------------------------------------------------------------------------
--                    Generation d'une base de donnees 
-- -----------------------------------------------------------------------------
--      Nom de la base : pecm
--      Projet : PECM CHIC
--      Auteures : Sarah GROS, Salome CHEVAILLER, Seraphie MAURY
--      Date de derniere modification : 10/02/2022
-- -----------------------------------------------------------------------------

CREATE DATABASE pecm;
DROP TABLE IF EXISTS DEGREREALISATION;
DROP TABLE IF EXISTS ETAPECIRCUIT;
DROP TABLE IF EXISTS COTATION;
DROP TABLE IF EXISTS DEPARTEMENT;
DROP TABLE IF EXISTS NEVEREVENT;
DROP TABLE IF EXISTS PLANACTION;
DROP TABLE IF EXISTS PILOTE;
DROP TABLE IF EXISTS REFPILOTE;
DROP TABLE IF EXISTS EVENEMENT;
DROP TABLE IF EXISTS RAPPORTCREX;
DROP TABLE IF EXISTS REFEVENEMENT;
DROP TABLE IF EXISTS REFACTION;
DROP TABLE IF EXISTS DYSFONCTIONNEMENT;
DROP TABLE IF EXISTS FACTEUR;
DROP TABLE IF EXISTS REFDYSFONCTIONNEMENT;

-- -----------------------------------------------------------------------------
--       TABLE : DEGREREALISATION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS DEGREREALISATION;
CREATE TABLE DEGREREALISATION (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : ETAPECIRCUIT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS ETAPECIRCUIT;
CREATE TABLE ETAPECIRCUIT (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : DEPARTEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS DEPARTEMENT;
CREATE TABLE DEPARTEMENT (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(50) NOT NULL,
    RISQUE BIT NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : NEVEREVENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS NEVEREVENT;
CREATE TABLE NEVEREVENT (
    NUMERO INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : PLANACTION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS PLANACTION;
CREATE TABLE PLANACTION (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    ACTION_CORRECTIVE VARCHAR(100) NOT NULL,
    CAUSE_LATENTE VARCHAR(100) NOT NULL,
    EFFET_ATTENDU VARCHAR(100) NOT NULL,
    ECHEANCE_PREVUE VARCHAR(50) NOT NULL,
    ECHEANCE_EFFECTIVE VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : PILOTE
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS PILOTE;
CREATE TABLE PILOTE (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------------------------------
--       TABLE : REFPILOTE
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS REFPILOTE;
CREATE TABLE REFPILOTE (
    ID_PLANACTION INT FOREIGN KEY REFERENCES PLANACTION(ID),
    ID_PILOTE INT FOREIGN KEY REFERENCES PILOTE(ID),
    PRIMARY KEY (ID_PLANACTION, ID_PILOTE)
);

-- -----------------------------------------------------------------------------
--       TABLE : EVENEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS EVENEMENT;
CREATE TABLE EVENEMENT(
    NUMERO INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    DETAILS VARCHAR(500),
    DATE_EM DATE,
    DATE_MODIFICATION DATE,
    PERSONNE_CONCERNEE VARCHAR(100),
    EST_ANALYSE BIT,
    EST_NEVEREVENT VARCHAR(50),
    JUSTIFICATION VARCHAR(500),
    PATIENT_RISQUE BIT,
    MEDICAMENT_RISQUE BIT,
    MEDICAMENT_TYPE VARCHAR(50),
    EST_REFRIGERE BIT,
    ADMINISTRATION_RISQUE BIT,
    ADMINISTRATION_PRECISIONS VARCHAR(100),
    DEPARTEMENT INT FOREIGN KEY REFERENCES DEPARTEMENT(ID),
    DEGRE_REALISATION INT FOREIGN KEY REFERENCES DEGREREALISATION(ID),
    ETAPE_CIRCUIT INT FOREIGN KEY REFERENCES ETAPECIRCUIT(ID),
);

-- -----------------------------------------------------------------------------
--       TABLE : COTATION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS COTATION;
CREATE TABLE COTATION (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    GRAVITE INT NOT NULL,
    OCCURRENCE INT NOT NULL,
    NIVEAU_MAITRISE INT NOT NULL,
    CRITICITE INT NOT NULL,
    EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO)
);

-- -----------------------------------------------------------------------------
--       TABLE : RAPPORTCREX
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS RAPPORTCREX;
CREATE TABLE RAPPORTCREX (
    NUMERO INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    DATE_CREX DATE NOT NULL,
    DATE_ANALYSE DATE NOT NULL,
    EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO)
);

-- -----------------------------------------------------------------------------
--       TABLE : REFEVENEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS REFEVENEMENT;
CREATE TABLE REFEVENEMENT (
    NUM_EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO),
    NUM_NEVEREVENT INT FOREIGN KEY REFERENCES NEVEREVENT(NUMERO),
    PRIMARY KEY (NUM_EVENEMENT, NUM_NEVEREVENT)
);

-- -----------------------------------------------------------------------------
--       TABLE : REFACTION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS REFACTION;
CREATE TABLE REFACTION (
    NUM_EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO),
    ID_PLANACTION INT FOREIGN KEY REFERENCES PLANACTION(ID),
    PRIMARY KEY (NUM_EVENEMENT, ID_PLANACTION)
);

-- -----------------------------------------------------------------------------
--       TABLE : DYSFONCTIONNEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS DYSFONCTIONNEMENT;
CREATE TABLE DYSFONCTIONNEMENT (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    DEFAILLANCE VARCHAR(100) NOT NULL,
    EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO)
);

-- -----------------------------------------------------------------------------
--       TABLE : FACTEUR
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS FACTEUR;
CREATE TABLE FACTEUR (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    PREVISIBLE BIT,
    LIBELLE VARCHAR(200),
    CATEGORIE VARCHAR(50)
);

-- -----------------------------------------------------------------------------
--       TABLE : REFDYSFONCTIONNEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS REFDYSFONCTIONNEMENT;
CREATE TABLE REFDYSFONCTIONNEMENT (
    ID_DYSFONCTIONNEMENT INT FOREIGN KEY REFERENCES DYSFONCTIONNEMENT(ID),
    ID_FACTEUR INT FOREIGN KEY REFERENCES FACTEUR(ID),
    PRIMARY KEY (ID_DYSFONCTIONNEMENT, ID_FACTEUR)
);