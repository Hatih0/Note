CREATE DATABASE gestion_note;
use gestion_note;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

-- password: admin123 
INSERT INTO utilisateurs (email, password)
VALUES ('admin@example.com', '$2y$12$bEPaURLhKxt3WkRdvWFaJerH./OjbiT9l67zhplQjjBpjtbO1aALy');

CREATE TABLE etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricule VARCHAR(50) UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100)
);

CREATE TABLE parcours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50), -- dev, bddres, web
    libelle VARCHAR(100),
    responsable VARCHAR(100)
);

CREATE TABLE etudiant_parcours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    parcours_id INT,
    annee VARCHAR(20), -- ex: L1, L2
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id),
    FOREIGN KEY (parcours_id) REFERENCES parcours(id)
);

CREATE TABLE semestres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10)
);

CREATE TABLE ue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20),
    libelle VARCHAR(255),
    credits INT,
    semestre_id INT,
    type ENUM('obligatoire', 'optionnelle'),
    FOREIGN KEY (semestre_id) REFERENCES semestres(id)
);

CREATE TABLE matieres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ue_id INT,
    code VARCHAR(20),
    libelle VARCHAR(255),
    FOREIGN KEY (ue_id) REFERENCES ue(id)
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    matiere_id INT,
    note DECIMAL(5,2),
    date_saisie DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id),
    FOREIGN KEY (matiere_id) REFERENCES matieres(id)
);