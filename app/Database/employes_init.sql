-- Script pour initialiser la BD employés avec base.sql existant

-- Insérer les données de test pour les employés
-- Mots de passe : soa123, marie123, jean123
INSERT OR IGNORE INTO departements (nom, description, deductible) VALUES
(1, 'IT', 'Informatique', 1),
(2, 'Finance', 'Département Financier', 1),
(3, 'Marketing', 'Marketing et Communication', 1);

INSERT OR IGNORE INTO TypeConger (nom, description) VALUES
(1, 'Congé annuel', 'Congé annuel payé'),
(2, 'Congé maladie', 'Congé pour maladie'),
(3, 'Congé spécial', 'Congés spéciaux');

INSERT OR IGNORE INTO Status (nom) VALUES
(1, 'en_attente'),
(2, 'approuvee'),
(3, 'refusee'),
(4, 'annulee');

-- Insérer les employés de test
-- Mots de passe hachés avec bcrypt
INSERT OR IGNORE INTO employes (nom, prenom, email, password, role, date_embauche, departement_id, actif) VALUES
('Rakoto', 'Soa', 'employe@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2022-03-01', 1, 1),
('Dupont', 'Jean', 'jean.dupont@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2023-05-15', 2, 1),
('Martin', 'Marie', 'marie.martin@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2023-01-10', 3, 1);

-- Insérer les soldes des employés
INSERT OR IGNORE INTO Soldes_emp (employe_id, type_conger_id, solde, jours_attribues, jour_prises) VALUES
(1, 1, 18, 30, 12),
(1, 2, 8, 10, 2),
(1, 3, 1, 5, 4),
(2, 1, 25, 30, 5),
(2, 2, 10, 10, 0),
(2, 3, 5, 5, 0),
(3, 1, 20, 30, 10),
(3, 2, 9, 10, 1),
(3, 3, 3, 5, 2);

-- Insérer quelques congés d'exemple
INSERT OR IGNORE INTO conger (employe_id, type_conger_id, date_debut, date_fin, id_status) VALUES
(1, 1, '2025-06-23', '2025-06-27', 1),
(1, 2, '2025-06-02', '2025-06-03', 2),
(1, 1, '2025-05-12', '2025-05-16', 2),
(2, 1, '2025-07-01', '2025-07-05', 1),
(3, 2, '2025-06-10', '2025-06-12', 2);

PRAGMA foreign_keys = ON;
