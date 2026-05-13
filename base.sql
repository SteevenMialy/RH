/* En SQLite, on ne fait pas CREATE DATABASE. Le fichier est la base. */

/* Table departements */
CREATE TABLE IF NOT EXISTS departements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT NOT NULL,
    deductible BOOLEAN NOT NULL
);

/* Table TypeConger */
CREATE TABLE IF NOT EXISTS TypeConger (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT NOT NULL
);

/* Table employes */
CREATE TABLE IF NOT EXISTS employes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL, -- Changé en TEXT UNIQUE
    password TEXT NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'employe',
    date_embauche DATE NOT NULL,
    departement_id INTEGER NOT NULL,
    actif BOOLEAN NOT NULL,
    FOREIGN KEY (departement_id) REFERENCES departements (id)
);

/* Table Status */
CREATE TABLE IF NOT EXISTS Status (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

/* Table conger */
CREATE TABLE IF NOT EXISTS conger (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conger_id INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    id_status INTEGER DEFAULT 1,
    FOREIGN KEY (employe_id) REFERENCES employes (id),
    FOREIGN KEY (type_conger_id) REFERENCES TypeConger (id),
    FOREIGN KEY (id_status) REFERENCES Status (id)
);

/* Table Soldes_emp */
CREATE TABLE IF NOT EXISTS Soldes_emp (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conger_id INTEGER NOT NULL,
    solde INTEGER NOT NULL,
    jours_attribues INTEGER NOT NULL,
    jour_prises INTEGER NOT NULL,
    FOREIGN KEY (employe_id) REFERENCES employes (id),
    FOREIGN KEY (type_conger_id) REFERENCES TypeConger (id)
);

/* Table rh */
CREATE TABLE IF NOT EXISTS rh (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'rh'
);

/* Table admin */
CREATE TABLE IF NOT EXISTS admin (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'admin'
);

/* Table Validation_rh */
CREATE TABLE IF NOT EXISTS Validation_rh (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    conger_id INTEGER NOT NULL,
    rh_id INTEGER NOT NULL,
    valeur VARCHAR(255) NOT NULL,
    commentaire TEXT,
    FOREIGN KEY (conger_id) REFERENCES conger (id),
    FOREIGN KEY (rh_id) REFERENCES rh (id)
);

PRAGMA foreign_keys = ON;