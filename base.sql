CREATE DATABASE IF NOT EXISTS Ecoles;
USE Ecoles;

-- Table des Niveaux (L1, L2, S3, S4 etc.)
CREATE TABLE Niveau (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

-- Table des Parcours
CREATE TABLE Parcours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    responsable VARCHAR(100) NOT NULL
);

-- Table des Matières (Unités d'Enseignement)
CREATE TABLE Matier (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(20),
    nom VARCHAR(150) NOT NULL,
    credits INT NOT NULL
);

-- Table de liaison : Quelle matière est dans quel parcours/niveau ?
CREATE TABLE Programme (
    id_parcours INT,
    id_matier INT,
    id_niveau INT,
    PRIMARY KEY (id_parcours, id_matier, id_niveau),
    FOREIGN KEY (id_parcours) REFERENCES Parcours(id),
    FOREIGN KEY (id_matier) REFERENCES Matier(id),
    FOREIGN KEY (id_niveau) REFERENCES Niveau(id)
);

-- Table des Étudiants
CREATE TABLE Etudiant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    id_niveau INT,
    id_parcours INT,
    FOREIGN KEY (id_niveau) REFERENCES Niveau(id),
    FOREIGN KEY (id_parcours) REFERENCES Parcours(id)
);

CREATE TABLE Note (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant INT,
    id_matier INT,
    note FLOAT,
    resultat VARCHAR(20),
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id),
    FOREIGN KEY (id_matier) REFERENCES Matier(id)
);

-- 1. Insertion des Niveaux
INSERT INTO Niveau (nom) VALUES ('Semestre 3'), ('Semestre 4');

-- 2. Insertion des Parcours
INSERT INTO Parcours (nom, responsable) VALUES 
('Commun', 'N/A'),
('Développement', 'Razafinjoelina Tahina'),
('Bases de Données et Réseaux', 'Rakotomalala Vahatriniaina'),
('Web et Design', 'Rabenanahary Rojo');

-- 3. Insertion des Matières (Extraites des images)
INSERT INTO Matier (code, nom, credits) 
VALUES ('INF201', 'Programmation orientée objet', 6),
('INF202', 'Bases de données objets', 6),
('INF203', 'Programmation système', 4),
('INF208', 'Réseaux informatiques', 6),
('MTH201', 'Méthodes numériques', 4),
('ORG201', 'Bases de gestion', 4),
('INF207', 'Eléments d’algorithmique', 6),
('INF210', 'Mini-projet de développement', 10),
('MTH203', 'MAO', 4),
('INF209', 'Web dynamique', 6),
('INF212', 'Mini-projet de Web et design', 10),
('INF211', 'Mini-projet de bases de données et/ou de réseaux', 10);

-- 4. Liaison Programme (Exemple pour le Semestre 3 Commun)
-- On lie les matières du S3 au parcours 'Commun' (id 1)
INSERT INTO Programme (id_parcours, id_matier, id_niveau) VALUES 
(1, 1, 1), 
(1, 2, 1), 
(1, 3, 1), 
(1, 4, 1), 
(1, 5, 1), 
(1, 6, 1);

-- Exemple pour le Parcours Développement au S4 (id_parcours 2, id_niveau 2)
INSERT INTO Programme (id_parcours, id_matier, id_niveau) VALUES 
(2, 7, 2), -- Algo
(2, 8, 2), -- Mini-projet
(2, 9, 2), -- MAO
(2, 10, 2),-- Mini-projet de bases de données et/ou de réseaux
(2, 11, 2), -- Web dynamique
(2, 12, 2); -- Mini-projet Web et design

-- 5. Ajout d'un étudiant test
INSERT INTO Etudiant (nom, prenom, id_niveau, id_parcours) 
VALUES ('Dupont', 'Jean', 2, 2),
('Lucs', 'Bira', 1, 1),
('Panne', 'Kane', 2, 3),
('Pile', 'Hana', 1, 1),
('Durand', 'Bille', 2, 4);