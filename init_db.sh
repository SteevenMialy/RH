#!/bin/bash

# Script d'installation de la base de données SQLite pour TechMada RH

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DB_DIR="$SCRIPT_DIR/app/Database"
DB_FILE="$DB_DIR/db.sqlite"

echo "🚀 Installation de TechMada RH — Base de données"
echo "================================================"

# Créer le répertoire Database s'il n'existe pas
if [ ! -d "$DB_DIR" ]; then
    echo "📁 Création du répertoire Database..."
    mkdir -p "$DB_DIR"
fi

# Supprimer l'ancienne base de données si elle existe
if [ -f "$DB_FILE" ]; then
    echo "🗑  Suppression de l'ancienne base de données..."
    rm "$DB_FILE"
fi

# Créer la nouvelle base de données et initialiser le schéma
echo "🔨 Création du schéma de base de données..."
sqlite3 "$DB_FILE" << 'EOF'
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
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table départements
CREATE TABLE IF NOT EXISTS departements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT,
    deductible BOOLEAN DEFAULT 1
);

-- Table types de congé
CREATE TABLE IF NOT EXISTS types_conge (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT,
    jours_annuels INTEGER DEFAULT 30
);

-- Table soldes
CREATE TABLE IF NOT EXISTS soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    jours_attribues INTEGER DEFAULT 30,
    jours_pris INTEGER DEFAULT 0,
    jours_restants INTEGER DEFAULT 30,
    annee INTEGER DEFAULT 2025,
    FOREIGN KEY (employe_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id)
);

-- Table demandes de congé
CREATE TABLE IF NOT EXISTS demandes_conge (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nombre_jours INTEGER,
    motif TEXT,
    statut VARCHAR(20) DEFAULT 'en_attente',
    commentaire_rh TEXT,
    valide_par_id INTEGER,
    date_validation DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employe_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id),
    FOREIGN KEY (valide_par_id) REFERENCES utilisateurs(id)
);

-- Insérer les départements
INSERT INTO departements (nom, description, deductible) VALUES
('IT', 'Informatique', 1),
('Finance', 'Département Financier', 1),
('Marketing', 'Marketing et Communication', 1),
('RH', 'Ressources Humaines', 1);

-- Insérer les types de congé
INSERT INTO types_conge (nom, description, jours_annuels) VALUES
('Congé annuel', 'Congé annuel payé', 30),
('Congé maladie', 'Congé pour maladie', 10),
('Congé spécial', 'Congés spéciaux', 5),
('Sans solde', 'Congé sans solde', 0);

-- Insérer les utilisateurs de démonstration
-- Mots de passe : admin123, rh123, emp123
INSERT INTO utilisateurs (nom, prenom, email, password, role, departement_id, date_embauche, actif) VALUES
('Admin', 'TechMada', 'admin@techmada.mg', '$2y$10$vI8aWBYW2h5FcJ3D0DtOU.V9qHcRsEjx3V9dJcwCzIUPLvulQe5rm', 'admin', 1, '2025-01-01', 1),
('Rabe', 'Marie', 'rh@techmada.mg', '$2y$10$VeKHTYaPsN7Nnvt6V6Gda.E8eJwPyL7xGeDcQtyXXp5wS.57W3fkm', 'rh', 4, '2020-01-15', 1),
('Rakoto', 'Soa', 'employe@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', 1, '2022-03-01', 1);

-- Insérer les soldes pour les employés
INSERT INTO soldes (employe_id, type_conge_id, jours_attribues, jours_pris, jours_restants, annee) VALUES
(3, 1, 30, 12, 18, 2025),
(3, 2, 10, 2, 8, 2025),
(3, 3, 5, 4, 1, 2025);

PRAGMA foreign_keys = ON;
EOF

if [ $? -eq 0 ]; then
    echo "✅ Base de données créée avec succès !"
    echo ""
    echo "📊 Identifiants de connexion :"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "👤 Admin       : admin@techmada.mg / admin123"
    echo "👥 RH          : rh@techmada.mg / rh123"
    echo "👨 Employé     : employe@techmada.mg / emp123"
    echo ""
    echo "🚀 Démarrer le serveur :"
    echo "   cd public && php -S localhost:8080"
    echo ""
    echo "🌐 Accéder à l'application :"
    echo "   http://localhost:8080/login"
else
    echo "❌ Erreur lors de la création de la base de données"
    exit 1
fi
