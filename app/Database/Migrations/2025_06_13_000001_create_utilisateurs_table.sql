
-- Table utilisateurs unifiée pour tous les rôles
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'employe',
    departement_id INTEGER,
    date_embauche DATE,
    actif BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (departement_id) REFERENCES departements(id)
);

-- Insérer les utilisateurs de démonstration
-- Mot de passe par défaut pour tous : MD5('admin123'), MD5('rh123'), MD5('emp123')
INSERT OR IGNORE INTO utilisateurs (nom, prenom, email, password, role, departement_id, date_embauche, actif) VALUES
('Admin', 'TechMada', 'admin@techmada.mg', '$2y$10$vI8aWBYW2h5FcJ3D0DtOU.V9qHcRsEjx3V9dJcwCzIUPLvulQe5rm', 'admin', 1, '2025-01-01', 1),
('RH', 'Responsable', 'rh@techmada.mg', '$2y$10$VeKHTYaPsN7Nnvt6V6Gda.E8eJwPyL7xGeDcQtyXXp5wS.57W3fkm', 'rh', 1, '2025-01-01', 1),
('Rakoto', 'Soa', 'employe@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', 1, '2022-03-01', 1);
