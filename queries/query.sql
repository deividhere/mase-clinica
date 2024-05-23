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
    data_nastere DATE NOT NULL DEFAULT (CURDATE()),
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
    nume VARCHAR(255) NOT NULL,
    stoc INT NOT NULL
);

CREATE TABLE asigurare (
    idasigurare    INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idpacient      INT NOT NULL,
    tip_asigurare  ENUM('Stat', 'Privat', 'Neasigurat'),
    casa_asigurare VARCHAR(50) DEFAULT ("Fara")
);

CREATE TABLE persistentlogin (
	idlogin 	INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    uniqueid	VARCHAR(255) NOT NULL,
    email		VARCHAR(255) NOT NULL
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

-- Triggere

DELIMITER $$

CREATE TRIGGER check_leave_overlap
BEFORE INSERT ON concediu
FOR EACH ROW
BEGIN
    DECLARE overlap_count INT;

    -- Check if there is an overlapping leave for the same medic
    SELECT COUNT(*)
    INTO overlap_count
    FROM concediu
    WHERE idmedic = NEW.idmedic
      AND NEW.data_incepere <= data_sfarsit
      AND NEW.data_sfarsit >= data_incepere;

    -- If there is an overlap, raise an error
    IF overlap_count > 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Concediul se suprapune cu altul.';
    END IF;
END$$

DELIMITER ;

CREATE TRIGGER trg_check_programare_before_insert
BEFORE INSERT ON programare
FOR EACH ROW
BEGIN
    DECLARE v_count INT;
    DECLARE v_count_leave INT;
    DECLARE v_weekday INT;
    
    -- Check for overlapping appointments for the same patient
    SELECT COUNT(*) INTO v_count
    FROM programare
    WHERE idpacient = NEW.idpacient
      AND data_programare = NEW.data_programare
      AND ora_programare = NEW.ora_programare;
    
    -- Check if the medic is on leave during the specified appointment date
    SELECT COUNT(*) INTO v_count_leave
    FROM concediu
    WHERE idmedic = NEW.idmedic
      AND NEW.data_programare BETWEEN data_incepere AND data_sfarsit;

    -- Check if the appointment date is on a weekend
    SET v_weekday = DAYOFWEEK(NEW.data_programare);
    
    -- If either condition is met, signal an error
    IF v_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Aveți deja o programare la această oră.';
    END IF;
    
    IF v_count_leave > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Medicul este în concediu în acea zi.';
    END IF;

    IF v_weekday = 1 OR v_weekday = 7 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nu puteți face o programare în weekend.';
    END IF;
    
    IF CONCAT(NEW.data_programare, ' ', NEW.ora_programare) < NOW() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Programarea nu poate fi făcută în trecut.';
    END IF;
END//

DELIMITER ;

DELIMITER //

CREATE TRIGGER before_insert_diagnostic
BEFORE INSERT ON diagnostic
FOR EACH ROW
BEGIN
    DECLARE appointment_datetime DATETIME;

    -- Check if there is already a diagnosis for the same appointment
    IF EXISTS (SELECT 1 FROM diagnostic WHERE idprogramare = NEW.idprogramare) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Există deja un diagnostic pentru această programare.';
    END IF;

    -- Get the appointment date and time
    SELECT CONCAT(data_programare, ' ', ora_programare) INTO appointment_datetime
    FROM programare
    WHERE idprogramare = NEW.idprogramare;

    -- Check if the appointment date and time have passed
    IF appointment_datetime > NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Nu puteți insera un diagnostic pentru o programare din viitor.';
    END IF;
END //

DELIMITER ;

