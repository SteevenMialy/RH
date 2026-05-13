# 🚀 DÉMARRAGE RAPIDE — TechMada RH Login

## ⚡ 3 étapes pour commencer

### Étape 1 : Initialiser la base de données
```bash
cd /home/davida/Documents/s4/Sys-Information\ /RH

# Choisir une option :

# Option A : Python (recommandé)
python3 init_db.py

# Option B : Bash
bash init_db.sh
```

**Résultat attendu** : ✅ Base de données créée avec succès

---

### Étape 2 : Lancer le serveur
```bash
cd public
php -S localhost:8080
```

**Résultat attendu** : 
```
Development Server started on http://localhost:8080
```

---

### Étape 3 : Ouvrir dans le navigateur
```
http://localhost:8080/login
```

---

## 🔑 Identifiants de test

**Copier-coller ces identifiants** :

```
👤 Admin
   Email    : admin@techmada.mg
   Mot passe: admin123

👥 Responsable RH
   Email    : rh@techmada.mg
   Mot passe: rh123

👨 Employé
   Email    : employe@techmada.mg
   Mot passe: emp123
```

---

## ✅ Vérifier que tout fonctionne

1. Accéder à `http://localhost:8080/login`
2. Voir la page de login avec le design TechMada RH ✓
3. Te connecter avec `employe@techmada.mg / emp123`
4. Voir le dashboard employé ✓
5. Cliquer sur "Déconnexion" → retour login ✓

---

## 📁 Fichiers importants

```
app/
├── Controllers/
│   ├── Auth.php                 ← Login/Logout
│   ├── EmployeDashboard.php
│   ├── RhDashboard.php
│   └── AdminDashboard.php
├── Models/
│   └── UtilisateurModel.php     ← Authentification
├── Views/
│   ├── auth/login.php            ← Page de connexion
│   ├── employe/                  ← Dashboards
│   ├── rh/
│   ├── admin/
│   └── layout/main.php           ← Template réutilisable
└── Config/
    └── Routes.php               ← Toutes les routes

init_db.py                        ← 🚀 Initialiser BD
init_db.sh                        ← 🚀 Initialiser BD

DOCUMENTATION_LOGIN.md            ← 📚 Détails techniques
README_LOGIN.md                   ← 📖 Installation complète
```

---

## 🎓 Architecture MVC

```
REQUEST
   ↓
Route (Config/Routes.php)
   ↓
Contrôleur (Controllers/Auth.php)
   ↓
Modèle (Models/UtilisateurModel.php)  ← BD
   ↓
Vue (Views/auth/login.php)
   ↓
RESPONSE
```

---

## 🔒 Sécurité

✅ Mot de passe hachés avec **bcrypt**  
✅ Validation des données  
✅ Protection CSRF  
✅ Sessions sécurisées  
✅ Vérification des rôles  

---

## 💡 Conseils

- **Garder le terminal ouvert** pour voir les logs du serveur
- **Pas d'erreur affichée** = Tout fonctionne ✓
- **Les cookies doivent être activés** pour les sessions
- **Tester les 3 rôles** pour voir les différents dashboards

---

## ❓ Troubleshooting rapide

| Problème | Solution |
|----------|----------|
| "Connection refused" | Lancer le serveur : `php -S localhost:8080` |
| "Table not found" | Exécuter : `python3 init_db.py` |
| "Identifiants incorrects" | Copier-coller exactement : `employe@techmada.mg` |
| Session perdue | Vérifier cookies navigateur |
| Port 8080 occupé | Changer port : `php -S localhost:8888` |

---

## 📚 Documentation complète

Pour comprendre le système en détail :
- Lire `DOCUMENTATION_LOGIN.md` (guide technique complet)
- Consulter `README_LOGIN.md` (installation avancée)

---

**Prêt ? 🚀 Suivre les 3 étapes ci-dessus !**
