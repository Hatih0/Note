-- =====================================================
-- FICHIER DE MIGRATION - DONNÉES ACADÉMIQUES
-- =====================================================
-- Ce fichier migre les données présentes dans le PDF Matiere.pdf
-- vers la base de données gestion_note

USE gestion_note;

-- =====================================================
-- 1. INSERTION DES SEMESTRES
-- =====================================================
INSERT INTO semestres (code) VALUES ('S3');
INSERT INTO semestres (code) VALUES ('S4');

-- =====================================================
-- 2. INSERTION DES PARCOURS
-- =====================================================
INSERT INTO parcours (code, libelle, responsable) 
VALUES ('DEV', 'Développement', 'Razafinjoelina Tahina');

INSERT INTO parcours (code, libelle, responsable) 
VALUES ('BDDRES', 'Bases de Données et Réseaux', 'Rakotomalalà Vahatriniaina');

INSERT INTO parcours (code, libelle, responsable) 
VALUES ('WEB', 'Web et Design', 'Rabenanhariry Rojo');

-- =====================================================
-- 3. INSERTION DES UE - SEMESTRE 3 (Parcours DEV)
-- =====================================================
INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF201', 'Programmation orientée objet', 6, 1, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF202', 'Bases de données objets', 6, 1, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF203', 'Programmation système', 4, 1, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF208', 'Réseaux informatiques', 6, 1, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH201', 'Méthodes numériques', 4, 1, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('ORG201', 'Bases de gestion', 4, 1, 'obligatoire');

-- =====================================================
-- 4. INSERTION DES UE - SEMESTRE 4 (Parcours DEV)
-- =====================================================
INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF204', 'Système d\'information géographique', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF205', 'Système d\'information', 6, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF206', 'Interface Homme/Machine', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF207', 'Éléments d\'algorithmique', 6, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF210', 'Mini-projet de développement', 10, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH204', 'Géométrie', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH205', 'Equations différentielles', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH206', 'Optimisation', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH203', 'MAO', 4, 2, 'obligatoire');

-- =====================================================
-- 5. INSERTION DES UE - SEMESTRE 4 (Parcours BDDRES)
-- =====================================================
INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF205_BDDRES', 'Système d\'information', 6, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF204_BDDRES', 'Système d\'information géographique', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF206_BDDRES', 'Interface Homme/Machine', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF207_BDDRES', 'Éléments d\'algorithmique', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF211', 'Mini-projet de bases de données et/ou de réseaux', 10, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH202', 'Analyse des données', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH205_BDDRES', 'Equations différentielles', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH206_BDDRES', 'Optimisation', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH203_BDDRES', 'MAO', 4, 2, 'obligatoire');

-- =====================================================
-- 6. INSERTION DES UE - SEMESTRE 4 (Parcours WEB)
-- =====================================================
INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF204_WEB', 'Système d\'information géographique', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF205_WEB', 'Système d\'information', 6, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF206_WEB', 'Interface Homme/Machine', 6, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF209', 'Web dynamique', 6, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('INF212', 'Mini-projet de Web et design', 10, 2, 'obligatoire');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH202_WEB', 'Analyse des données', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH204_WEB', 'Géométrie', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH206_WEB', 'Optimisation', 4, 2, 'optionnelle');

INSERT INTO ue (code, libelle, credits, semestre_id, type) 
VALUES ('MTH203_WEB', 'MAO', 4, 2, 'obligatoire');

-- =====================================================
-- 7. INSERTION DES MATIÈRES - SEMESTRE 3
-- =====================================================
-- Les matières sont généralement associées à une UE
-- Ici, on crée des matières pour chaque UE

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF201', 'Programmation orientée objet' FROM ue WHERE code = 'INF201';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF202', 'Bases de données objets' FROM ue WHERE code = 'INF202';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF203', 'Programmation système' FROM ue WHERE code = 'INF203';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF208', 'Réseaux informatiques' FROM ue WHERE code = 'INF208';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH201', 'Méthodes numériques' FROM ue WHERE code = 'MTH201';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'ORG201', 'Bases de gestion' FROM ue WHERE code = 'ORG201';

-- =====================================================
-- 8. INSERTION DES MATIÈRES - SEMESTRE 4
-- =====================================================
INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF204', 'Système d\'information géographique' FROM ue WHERE code = 'INF204';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF205', 'Système d\'information' FROM ue WHERE code = 'INF205' LIMIT 1;

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF206', 'Interface Homme/Machine' FROM ue WHERE code = 'INF206';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF207', 'Éléments d\'algorithmique' FROM ue WHERE code = 'INF207';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF210', 'Mini-projet de développement' FROM ue WHERE code = 'INF210';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF209', 'Web dynamique' FROM ue WHERE code = 'INF209';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF211', 'Mini-projet de bases de données et/ou de réseaux' FROM ue WHERE code = 'INF211';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'INF212', 'Mini-projet de Web et design' FROM ue WHERE code = 'INF212';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH202', 'Analyse des données' FROM ue WHERE code = 'MTH202';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH203', 'MAO' FROM ue WHERE code = 'MTH203' LIMIT 1;

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH204', 'Géométrie' FROM ue WHERE code = 'MTH204';

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH205', 'Equations différentielles' FROM ue WHERE code = 'MTH205' LIMIT 1;

INSERT INTO matieres (ue_id, code, libelle) 
SELECT id, 'MTH206', 'Optimisation' FROM ue WHERE code = 'MTH206' LIMIT 1;

<<<<<<< HEAD
=======
-- =====================================================
-- 9. INSERTION D'UTILISATEURS ADMINISTRATEURS
-- =====================================================
-- Les mots de passe doivent être hashés en production
INSERT INTO utilisateurs (username, password) 
VALUES ('admin', SHA2('admin123', 256));

INSERT INTO utilisateurs (username, password) 
VALUES ('responsable_dev', SHA2('password', 256));

INSERT INTO utilisateurs (username, password) 
VALUES ('responsable_bddres', SHA2('password', 256));

INSERT INTO utilisateurs (username, password) 
VALUES ('responsable_web', SHA2('password', 256));
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679

-- =====================================================
-- 10. VÉRIFICATIONS ET AFFICHAGE DES DONNÉES INSÉRÉES
-- =====================================================
SELECT '=== PARCOURS INSÉRÉS ===' AS info;
SELECT * FROM parcours;

SELECT '=== SEMESTRES INSÉRÉS ===' AS info;
SELECT * FROM semestres;

SELECT '=== UE INSÉRÉES (Semestre 3) ===' AS info;
SELECT ue.code, ue.libelle, ue.credits, s.code AS semestre 
FROM ue 
JOIN semestres s ON ue.semestre_id = s.id 
WHERE s.code = 'S3';

SELECT '=== UE INSÉRÉES (Semestre 4) ===' AS info;
SELECT ue.code, ue.libelle, ue.credits, s.code AS semestre 
FROM ue 
JOIN semestres s ON ue.semestre_id = s.id 
WHERE s.code = 'S4';

SELECT '=== MATIÈRES INSÉRÉES ===' AS info;
SELECT m.code, m.libelle, u.code AS ue_code, u.libelle AS ue_libelle 
FROM matieres m 
JOIN ue u ON m.ue_id = u.id;

SELECT '=== UTILISATEURS INSÉRÉS ===' AS info;
SELECT id, username FROM utilisateurs;

-- =====================================================
-- FIN DE LA MIGRATION
-- =====================================================
<<<<<<< HEAD

insert into etudiants (matricule, nom, prenom) values ('2023-001', 'Rasoa', 'Andry');
=======
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
