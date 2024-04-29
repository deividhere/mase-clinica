CREATE DATABASE clinica;

USE clinica;

-- Creare tabele
CREATE TABLE medici (
    idmedic INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(50) NOT NULL,
    prenume VARCHAR(50) NOT NULL,
    specializare VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    parola VARCHAR(255) NOT NULL, 
    telefon_cabinet VARCHAR(50) NOT NULL
);

CREATE TABLE pacienti (
    idpacient INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nume VARCHAR(50) NOT NULL,
    prenume VARCHAR(50) NOT NULL,
    cnp VARCHAR(50) NOT NULL UNIQUE,
    sex ENUM('Masculin', 'Feminin', 'Altul'),
    telefon VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    parola VARCHAR(255) NOT NULL, 
    data_nastere DATE NOT NULL,
    asigurare BOOLEAN DEFAULT 0
);

CREATE TABLE programare (
    idprogramare    INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idmedic         INT NOT NULL,
    idpacient       INT NOT NULL,
    status          ENUM('Confirmata', 'Anulata', 'In asteptare'),
    data_programare DATE NOT NULL,
    ora_programare  TIME NOT NULL
);

CREATE TABLE diagnostic (
    iddiagnostic INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idprogramare INT NOT NULL,
    diagnostic  VARCHAR(255),
    descriere    VARCHAR(255),
    recomandari  VARCHAR(255)
);

CREATE TABLE reteta (
    idreteta  INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    iddiagnostic INT NOT NULL
);

CREATE TABLE lista (
    idlista      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idreteta	 INT NOT NULL,
    idmedicament INT NOT NULL,
    cantitate    INT DEFAULT 1
);

CREATE TABLE medicamente (
    idmedicament INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    denumire     VARCHAR(50) NOT NULL,
    descriere    VARCHAR(255),
    prospect     VARCHAR(255),
    pret         DECIMAL(5,2) NOT NULL
);

CREATE TABLE concediu (
    idconcediu   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    data_incepere DATE NOT NULL,
    data_sfarsit  DATE NOT NULL,
    idmedic       INT NOT NULL
);

CREATE TABLE farmacie (
	idfarmacie INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idmedicament INT NOT NULL,
    stoc INT NOT NULL
);

CREATE TABLE asigurare (
    idasigurare    INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idpacient      INT NOT NULL,
    tip_asigurare  ENUM('Stat', 'Privat', 'Neasigurat'),
    casa_asigurare VARCHAR(50)
);

-- Foreign keys
ALTER TABLE concediu
    ADD CONSTRAINT fk_concediu_medic FOREIGN KEY ( idmedic )
        REFERENCES medici ( idmedic )
			ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE asigurare
    ADD CONSTRAINT fk_asigurare_pacient FOREIGN KEY ( idpacient )
        REFERENCES pacienti ( idpacient )
			ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE programare
    ADD CONSTRAINT fk_programare_medic FOREIGN KEY ( idmedic )
        REFERENCES medici ( idmedic )
			ON UPDATE CASCADE
            ON DELETE CASCADE;
            
ALTER TABLE programare
    ADD CONSTRAINT fk_programare_pacient FOREIGN KEY ( idpacient )
        REFERENCES pacienti ( idpacient )
			ON UPDATE CASCADE
            ON DELETE CASCADE;
            
ALTER TABLE diagnostic
    ADD CONSTRAINT fk_diagnostic_programare FOREIGN KEY ( idprogramare )
        REFERENCES programare ( idprogramare )
			ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE reteta
    ADD CONSTRAINT fk_reteta_diagnostic FOREIGN KEY ( iddiagnostic )
        REFERENCES diagnostic ( iddiagnostic )
			ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE lista
    ADD CONSTRAINT fk_lista_reteta FOREIGN KEY ( idreteta )
        REFERENCES reteta ( idreteta )
			ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE lista
    ADD CONSTRAINT fk_lista_medicament FOREIGN KEY ( idmedicament )
        REFERENCES medicamente ( idmedicament )
			ON UPDATE CASCADE
            ON DELETE CASCADE;  

ALTER TABLE farmacie
	ADD CONSTRAINT fk_farmacie_medicament FOREIGN KEY ( idmedicament )
		REFERENCES medicamente ( idmedicament )
			ON UPDATE CASCADE
            ON DELETE CASCADE;
