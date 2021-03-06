-- -----------------------------------------------------------------------------
--                    Generation d'une base de donnees 
-- -----------------------------------------------------------------------------
--      Nom de la base : pecm
--      Projet : PECM CHIC
--      Auteures : Sarah GROS, Salome CHEVAILLER, Seraphie MAURY
--      Date de derniere modification : 10/02/2022
-- -----------------------------------------------------------------------------

DROP TABLE REFACTION;
DROP TABLE REFEVENEMENT;
DROP TABLE REFPILOTE;
DROP TABLE PILOTE;
DROP TABLE RAPPORTCREX;
DROP TABLE NEVEREVENT;
DROP TABLE PLANACTION;
DROP TABLE FACTEUR;
DROP TABLE COTATION;
DROP TABLE EVENEMENT;
DROP TABLE DEPARTEMENT;


-- -----------------------------------------------------------------------------
--       TABLE : DEPARTEMENT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS DEPARTEMENT;
CREATE TABLE DEPARTEMENT (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    NOM VARCHAR(200) NOT NULL,
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
    ACTION_PREVENTIVE VARCHAR(100),
    ACTION_CORRECTIVE VARCHAR(100),
    CAUSE_LATENTE VARCHAR(100),
    EFFET_ATTENDU VARCHAR(100),
    ECHEANCE_PREVUE VARCHAR(50),
    ECHEANCE_EFFECTIVE VARCHAR(50)
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
    NUMERO INT NOT NULL PRIMARY KEY,
    DETAILS VARCHAR(500),
    CONSEQUENCES VARCHAR(500),
    DATE_EM DATE,
    DATE_DECLARATION DATE,
    DATE_MODIFICATION DATE,
    NOM VARCHAR(50),
    PRENOM VARCHAR(50),
    FONCTION VARCHAR(100),
    ANONYME BIT,
    EST_ANALYSE BIT,
    EST_NEVEREVENT VARCHAR(50),
    JUSTIFICATION VARCHAR(500),
    PREM_ACTIONS VARCHAR(500),
    PATIENT_RISQUE VARCHAR(50),
    CATEGORIE_PATIENT VARCHAR(50),
    PRECISIONS_PATIENT VARCHAR(100),
    MEDICAMENT_RISQUE VARCHAR(50),
    PRECISIONS_MEDICAMENT VARCHAR(100),
    MEDICAMENT_CLASSE VARCHAR(50),
    MEDICAMENT_TYPE VARCHAR(50),
    EST_REFRIGERE BIT,
    ADMINISTRATION_RISQUE VARCHAR(50),
    CATEGORIE_ADMINISTRATION VARCHAR(50),
    ADMINISTRATION_PRECISIONS VARCHAR(100),
    PREVENTION BIT,
    DEFENSES VARCHAR(500),
    DEGRE_REALISATION VARCHAR(200),
    ETAPE_CIRCUIT VARCHAR(200),
    DEFAILLANCE VARCHAR(500),
    DEPARTEMENT INT FOREIGN KEY REFERENCES DEPARTEMENT(ID),
);

-- -----------------------------------------------------------------------------
--       TABLE : COTATION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS COTATION;
CREATE TABLE COTATION (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    GRAVITE VARCHAR(100) NOT NULL,
    OCCURRENCE VARCHAR(100) NOT NULL,
    NIVEAU_MAITRISE VARCHAR(100) NOT NULL,
    CRITICITE VARCHAR(100) NOT NULL,
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
--       TABLE : FACTEUR
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS FACTEUR;
CREATE TABLE FACTEUR (
    ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
    PREVISIBLE VARCHAR(50),
    LIBELLE VARCHAR(200),
    PRECISIONS_FACTEUR VARCHAR(200),
    EVENEMENT INT FOREIGN KEY REFERENCES EVENEMENT(NUMERO)
);
