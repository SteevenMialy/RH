# TechMada RH — Système de Gestion des Congés (CodeIgniter 4)

## 🎯 Aperçu du Projet

Système RH complet pour la gestion des demandes de congés avec authentification multi-rôles et interface moderne.

### Rôles disponibles :
- **Admin** : Gestion complète (employés, départements, types de congé)
- **Responsable RH** : Validation des demandes et gestion des soldes
- **Employé** : Demande de congés et suivi des demandes

---

## 🚀 Installation

### Prérequis
- PHP 7.4+
- CodeIgniter 4
- SQLite (ou MySQL)
- Composer

### Étapes d'installation

1. **Accéder au répertoire du projet**
   ```bash
   cd /home/davida/Documents/s4/Sys-Information\ /RH
   ```

2. **Créer la base de données SQLite**
   ```bash
   sqlite3 app/Database/db.sqlite < app/Database/Migrations/2025_06_13_000001_create_utilisateurs_table.sql
   ```
   ou exécuter directement le SQL avec votre client SQLite préféré.

3. **Configurer la base de données dans `.env`**
   ```
   database.default.DBDriver = SQLite
   database.default.DBName = app/Database/db.sqlite
   ```

4. **Lancer le serveur de développement**
   ```bash
   cd public
   php -S localhost:8080
   ```

5. **Accéder à l'application**
   - URL : `http://localhost:8080/login`

---

## 🔐 Identifiants de Test

| Rôle | Email | Mot de passe |
|------|-------|------------|
| **Admin** | `admin@techmada.mg` | `admin123` |
| **Responsable RH** | `rh@techmada.mg` | `rh123` |
| **Employé** | `employe@techmada.mg` | `emp123` |

---

## 📁 Structure du Projet

```
app/
├── Controllers/
│   ├── Auth.php                 # Authentification (login/logout)
│   ├── EmployeDashboard.php     # Dashboard employé
│   ├── RhDashboard.php          # Dashboard RH
│   └── AdminDashboard.php       # Dashboard admin
├── Models/
│   └── UtilisateurModel.php     # Gestion des utilisateurs
├── Views/
│   ├── auth/
│   │   └── login.php            # Page de connexion
│   ├── employe/                 # Vues employés
│   ├── rh/                      # Vues RH
│   ├── admin/                   # Vues admin
│   └── layout/
│       └── main.php             # Layout principal
├── Config/
│   └── Routes.php               # Configuration des routes
└── Database/
    └── Migrations/
        └── 2025_06_13_000001_create_utilisateurs_table.sql
```

---

## 🔀 Routes Disponibles

### Authentification
- `GET /login` → Page de login
- `POST /login` → Traitement du login
- `GET /logout` → Déconnexion

### Dashboard Employé
- `GET /employe` → Dashboard
- `GET /employe/demande` → Nouvelle demande
- `GET /employe/mes-conges` → Mes demandes
- `GET /employe/profil` → Mon profil

### Dashboard RH
- `GET /rh` → Dashboard
- `GET /rh/demandes` → Demandes à traiter
- `GET /rh/soldes` → Soldes des employés

### Dashboard Admin
- `GET /admin` → Dashboard
- `GET /admin/employes` → Gestion des employés
- `GET /admin/departements` → Gestion des départements
- `GET /admin/types-conge` → Gestion des types de congé
- `GET /admin/demandes` → Toutes les demandes

---

## 🎨 Design

Le design utilise un système de couleurs cohérent avec :
- **Palette verte** (forest, leaf) pour l'interface principale
- **États visuels** : succès (vert), danger (rouge), avertissement (orange), info (bleu)
- **Typographie** : Playfair Display (titres) + DM Sans (corps)
- **Layout responsive** : Sidebar sticky + main content flexible

---

## 🔒 Sécurité

- ✅ Hachage des mots de passe avec `password_hash()` (bcrypt)
- ✅ Protection CSRF via tokens CodeIgniter
- ✅ Validation des données utilisateur
- ✅ Sessions sécurisées
- ✅ Vérification des rôles pour chaque dashboard

---

## 📝 Prochaines Étapes

Les fonctionnalités suivantes sont à développer :

### Employé
- [ ] Formulaire de demande de congé
- [ ] Liste des demandes avec filtrage
- [ ] Calcul automatique du nombre de jours
- [ ] Gestion du profil
- [ ] Historique des congés

### RH
- [ ] Tableau des demandes à valider/refuser
- [ ] Gestion des soldes par employé
- [ ] Rapports et statistiques
- [ ] Historique des validations

### Admin
- [ ] CRUD Employés (créer, éditer, désactiver)
- [ ] Gestion des départements
- [ ] Configuration des types de congé
- [ ] Initialisation des soldes annuels
- [ ] Dashboard statistiques

---

## 🛠 Technologies

- **Framework** : CodeIgniter 4
- **Base de données** : SQLite
- **Frontend** : HTML5 + CSS3 + Bootstrap Icons
- **Authentification** : Sessions PHP + Hachage bcrypt
- **Validation** : Validation CI4

---

## 📧 Support

Pour toute question sur la structure ou le fonctionnement, consultez :
- Documentation CI4 : https://codeigniter.com/user_guide/
- Guide MVC fourni : `codeigniter4_prise_en_main.md`

---

**Projet TechMada RH** — Mai 2025
