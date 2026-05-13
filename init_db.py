#!/usr/bin/env python3
"""
Script d'initialisation de la base de données SQLite pour TechMada RH
Uniquement pour les EMPLOYES
Exécutez : python3 init_db.py
"""

import sqlite3
import os
import sys

# Chemin vers la base de données
DB_DIR = os.path.join(os.path.dirname(__file__), 'app', 'Database')
DB_FILE = os.path.join(DB_DIR, 'db.sqlite')

# Créer le répertoire s'il n'existe pas
os.makedirs(DB_DIR, exist_ok=True)

# Supprimer l'ancienne BD si elle existe
if os.path.exists(DB_FILE):
    print("🗑  Suppression de l'ancienne base de données...")
    os.remove(DB_FILE)

# Connecter à la nouvelle BD
print("🔨 Création du schéma de base de données...")
conn = sqlite3.connect(DB_FILE)
cursor = conn.cursor()

# Lire et exécuter le fichier base.sql
print("📝 Exécution de base.sql...")
with open('base.sql', 'r', encoding='utf-8') as f:
    sql_script = f.read()
    cursor.executescript(sql_script)

# Insérer les données de test pour les employés
print("📝 Insertion des données de test...")

cursor.execute("""
    INSERT OR IGNORE INTO departements (nom, description, deductible) VALUES
    ('IT', 'Informatique', 1),
    ('Finance', 'Département Financier', 1),
    ('Marketing', 'Marketing et Communication', 1)
""")

cursor.execute("""
    INSERT OR IGNORE INTO TypeConger (nom, description) VALUES
    ('Congé annuel', 'Congé annuel payé'),
    ('Congé maladie', 'Congé pour maladie'),
    ('Congé spécial', 'Congés spéciaux')
""")

cursor.execute("""
    INSERT OR IGNORE INTO Status (nom) VALUES
    ('en_attente'),
    ('approuvee'),
    ('refusee'),
    ('annulee')
""")

# Insérer les employés de test
# Mots de passe hachés avec bcrypt
cursor.execute("""
    INSERT OR IGNORE INTO employes (nom, prenom, email, password, role, date_embauche, departement_id, actif) VALUES
    ('Rakoto', 'Soa', 'employe@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2022-03-01', 1, 1),
    ('Dupont', 'Jean', 'jean.dupont@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2023-05-15', 2, 1),
    ('Martin', 'Marie', 'marie.martin@techmada.mg', '$2y$10$PYYaKl2VH/D7Cl80LiI1c.aLdlRh5FVIBnNDu1M6yJhQm9e5Sa6D.', 'employe', '2023-01-10', 3, 1)
""")

# Insérer des comptes RH et Admin de test
cursor.execute("""
    INSERT OR IGNORE INTO rh (username, email, password, role) VALUES
    ('Responsable RH', 'rh@techmada.mg', '$2y$10$VeKHTYaPsN7Nnvt6V6Gda.E8eJwPyL7xGeDcQtyXXp5wS.57W3fkm', 'rh')
""")

cursor.execute("""
    INSERT OR IGNORE INTO admin (username, email, password, role) VALUES
    ('Administrateur', 'admin@techmada.mg', '$2y$10$vI8aWBYW2h5FcJ3D0DtOU.V9qHcRsEjx3V9dJcwCzIUPLvulQe5rm', 'admin')
""")

# Insérer les soldes
cursor.execute("""
    INSERT OR IGNORE INTO Soldes_emp (employe_id, type_conger_id, solde, jours_attribues, jour_prises) VALUES
    (1, 1, 18, 30, 12),
    (1, 2, 8, 10, 2),
    (1, 3, 1, 5, 4),
    (2, 1, 25, 30, 5),
    (2, 2, 10, 10, 0),
    (2, 3, 5, 5, 0),
    (3, 1, 20, 30, 10),
    (3, 2, 9, 10, 1),
    (3, 3, 3, 5, 2)
""")

# Insérer des congés d'exemple
cursor.execute("""
    INSERT OR IGNORE INTO conger (employe_id, type_conger_id, date_debut, date_fin, id_status) VALUES
    (1, 1, '2025-06-23', '2025-06-27', 1),
    (1, 2, '2025-06-02', '2025-06-03', 2),
    (1, 1, '2025-05-12', '2025-05-16', 2),
    (2, 1, '2025-07-01', '2025-07-05', 1),
    (3, 2, '2025-06-10', '2025-06-12', 2)
""")

conn.commit()
conn.close()

print("")
print("✅ Base de données créée avec succès !")
print("")
print("📊 Identifiants de connexion (EMPLOYÉS UNIQUEMENT) :")
print("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━")
print("👨 Soa Rakoto       : employe@techmada.mg / emp123")
print("👨 Jean Dupont      : jean.dupont@techmada.mg / emp123")
print("👩 Marie Martin     : marie.martin@techmada.mg / emp123")
print("")
print("🚀 Démarrer le serveur :")
print("   cd public && php -S localhost:8080")
print("")
print("🌐 Accéder à l'application :")
print("   http://localhost:8080/login")
print("")
