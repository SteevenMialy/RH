# 📚 Documentation du Système de Login — TechMada RH

## 📖 Table des matières
1. [Structure MVC](#structure-mvc)
2. [Architecture du Login](#architecture-du-login)
3. [Guide d'utilisation](#guide-dutilisation)
4. [Fichiers clés](#fichiers-clés)
5. [Flux de la session](#flux-de-la-session)

---

## 🏗️ Structure MVC

Le projet suit le pattern **MVC (Model-View-Controller)** standard de CodeIgniter 4 :

```
REQUEST → ROUTE → CONTROLLER → MODEL → VIEW → RESPONSE
```

### Exemple : Login
```
GET /login
  ↓
routes.php : $routes->get('/login', 'Auth::login')
  ↓
Auth::login() → retourne la vue auth/login.php
  ↓
L'utilisateur voit le formulaire et soumet ses identifiants
  ↓
POST /login
  ↓
Auth::doLogin() → appelle UtilisateurModel::authentifier()
  ↓
Si succès → création de session → redirection au dashboard
Si échec → retour au formulaire avec erreur
```

---

## 🔐 Architecture du Login

### 1️⃣ Modèle (`app/Models/UtilisateurModel.php`)

**Responsabilité** : Accès à la base de données

```php
class UtilisateurModel extends Model
{
    // Fonction d'authentification
    public function authentifier($email, $password)
    {
        $user = $this->where('email', $email)
            ->where('actif', 1)
            ->first();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;  // Utilisateur trouvé et mot de passe correct
        }
        
        return false;      // Identifiants incorrects
    }
}
```

**Chaîne de sécurité** :
- ✅ Recherche par email
- ✅ Vérification du compte actif (`actif = 1`)
- ✅ Vérification du mot de passe avec `password_verify()` (bcrypt)

### 2️⃣ Contrôleur (`app/Controllers/Auth.php`)

**Responsabilité** : Logique d'authentification et gestion des sessions

```php
class Auth extends BaseController
{
    public function doLogin()
    {
        // 1. Récupérer les données du formulaire
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // 2. Valider les données
        if (!$validation->run(['email' => $email, 'password' => $password])) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }
        
        // 3. Authentifier l'utilisateur
        $user = $this->utilisateurModel->authentifier($email, $password);
        
        // 4. Si succès, créer la session
        if ($user) {
            $this->session->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'user_role' => $user['role'],  // 'admin', 'rh', 'employe'
                'is_logged_in' => true,
            ]);
            
            // 5. Rediriger selon le rôle
            switch ($user['role']) {
                case 'admin':
                    return redirect()->to(route_to('admin_dashboard'));
                case 'rh':
                    return redirect()->to(route_to('rh_dashboard'));
                case 'employe':
                    return redirect()->to(route_to('employe_dashboard'));
            }
        }
        
        // Identifiants incorrects
        return redirect()->back()
            ->with('error', 'Identifiants incorrects. Veuillez réessayer.')
            ->withInput();
    }
}
```

### 3️⃣ Vue (`app/Views/auth/login.php`)

**Responsabilité** : Afficher le formulaire de login

```html
<form method="POST" action="<?= route_to('do_login'); ?>">
    <?= csrf_field(); ?>  <!-- Protection CSRF -->
    
    <input type="email" name="email" placeholder="vous@techmada.mg" />
    <input type="password" name="password" placeholder="••••••••" />
    
    <button type="submit">Se connecter</button>
</form>

<!-- Affichage des erreurs -->
<?php if (session()->has('error')): ?>
    <div class="flash flash-error">
        <?= session('error'); ?>
    </div>
<?php endif; ?>
```

---

## 🚀 Guide d'utilisation

### Installation initiale

**Option 1 : Avec Python (recommandé)**
```bash
python3 init_db.py
```

**Option 2 : Avec Bash**
```bash
bash init_db.sh
```

**Option 3 : Manuel (SQLite)**
```bash
sqlite3 app/Database/db.sqlite < app/Database/Migrations/2025_06_13_000001_create_utilisateurs_table.sql
```

### Démarrer le serveur

```bash
cd public
php -S localhost:8080
```

### Accéder à l'application

1. Ouvrez `http://localhost:8080/login`
2. Utilisez l'un des identifiants de test :
   - `admin@techmada.mg / admin123`
   - `rh@techmada.mg / rh123`
   - `employe@techmada.mg / emp123`

---

## 📁 Fichiers clés

| Fichier | Rôle | Description |
|---------|------|-------------|
| `Auth.php` | Contrôleur | Gère login, logout, création de session |
| `UtilisateurModel.php` | Modèle | Requêtes BD (authentification, recherche) |
| `auth/login.php` | Vue | Affiche le formulaire de connexion |
| `Config/Routes.php` | Config | Définit les routes (GET /login, POST /login) |
| `Views/layout/main.php` | Layout | Template réutilisable pour les dashboards |
| `init_db.py` | Script | Initialise la BD avec données de test |

---

## 🔄 Flux de la session

### 1. Avant la connexion
```
utilisateur → navigate vers /login → Auth::login() → affiche formulaire
```

### 2. Soumission du formulaire
```
utilisateur → remplit le formulaire → POST /login → Auth::doLogin()
```

### 3. Authentification
```
- Récupérer email + password
- Valider les données (obligatoire, format email)
- Appeler UtilisateurModel::authentifier()
- Vérifier email dans BD
- Vérifier compte actif
- Comparer les mots de passe (bcrypt)
```

### 4. Si succès
```
- Créer session avec user_id, user_role, etc.
- Mettre flashdata de succès
- Rediriger vers le dashboard approprié
```

### 5. Si échec
```
- Mettre flashdata d'erreur
- Rediriger vers /login avec les données du formulaire
- L'utilisateur voit le message "Identifiants incorrects"
```

### 6. Après connexion (dashboard)
```
EmployeDashboard::dashboard() ou RhDashboard::dashboard() ou AdminDashboard::dashboard()
  → Vérifier que l'utilisateur est connecté (checkAuth())
  → Charger les données pour la vue
  → Afficher le dashboard
```

### 7. Déconnexion
```
utilisateur → clique sur "Déconnexion" → GET /logout → Auth::logout()
  → Détruire la session (_SESSION.clear())
  → Rediriger vers /login
```

---

## 🔒 Sécurité

### Bonnes pratiques appliquées

| Pratique | Implémentation | Bénéfice |
|----------|-----------------|----------|
| **Hachage des mots de passe** | `password_hash()` + bcrypt | Les mots de passe ne sont jamais stockés en clair |
| **Vérification bcrypt** | `password_verify()` | Impossible de retrouver le mot de passe original |
| **Validation des données** | Validation CI4 (email, longueur) | Protection contre les entrées malveillantes |
| **Protection CSRF** | `<?= csrf_field(); ?>` | Empêche les attaques cross-site |
| **Sessions sécurisées** | CodeIgniter Session Library | Gestion sécurisée des sessions utilisateur |
| **Vérification des rôles** | `checkAuth()` + vérif du rôle | Empêche l'accès non autorisé aux dashboards |

### Hachage des mots de passe de test

```php
// Les mots de passe sont hachés avec bcrypt :
password_hash('admin123', PASSWORD_BCRYPT);     // → $2y$10$vI8a...
password_hash('rh123', PASSWORD_BCRYPT);         // → $2y$10$VeKH...
password_hash('emp123', PASSWORD_BCRYPT);        // → $2y$10$PYYa...
```

---

## 📱 Responsive Design

Le design est **100% responsive** avec :

- **Desktop** : Sidebar + Main content side-by-side
- **Tablet** : Layout adaptatif
- **Mobile** : Sidebar caché, plein écran (à implémenter)

CSS : `@media(max-width:768px)` dans `auth/login.php`

---

## 🎨 Personnalisation

### Modifier les couleurs

Dans `app/Views/auth/login.php` ou `app/Views/layout/main.php` :

```css
:root {
    --forest:   #2d5a3d;      /* Vert principal */
    --danger:   #c0392b;      /* Rouge */
    --success:  #1e6b3f;      /* Vert succès */
    --info:     #1a4f7a;      /* Bleu */
    --warn:     #b8750a;      /* Orange */
}
```

### Ajouter un nouvel utilisateur

```php
// Dans un contrôleur admin
$this->utilisateurModel->insert([
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'email' => 'jean.dupont@techmada.mg',
    'password' => password_hash('motdepasse123', PASSWORD_BCRYPT),
    'role' => 'employe',
    'departement_id' => 1,
    'date_embauche' => date('Y-m-d'),
    'actif' => 1
]);
```

---

## ⚙️ Configuration

### `.env` (Database)
```
database.default.DBDriver = SQLite
database.default.DBName = app/Database/db.sqlite
```

### `Config/Routes.php`
```php
// Routes du login
$routes->get('/login', 'Auth::login', ['as' => 'auth_login']);
$routes->post('/login', 'Auth::doLogin', ['as' => 'do_login']);
$routes->get('/logout', 'Auth::logout', ['as' => 'auth_logout']);

// Routes des dashboards
$routes->get('/employe', 'EmployeDashboard::dashboard', ['as' => 'employe_dashboard']);
$routes->get('/rh', 'RhDashboard::dashboard', ['as' => 'rh_dashboard']);
$routes->get('/admin', 'AdminDashboard::dashboard', ['as' => 'admin_dashboard']);
```

---

## 🐛 Troubleshooting

| Problème | Cause | Solution |
|----------|-------|----------|
| "CSRF token mismatch" | Token CSRF manquant | Ajouter `<?= csrf_field(); ?>` au formulaire |
| "Table utilisateurs not found" | BD non initialisée | Exécuter `python3 init_db.py` |
| "Identifiants toujours incorrects" | Mot de passe invalide | Vérifier que bcrypt est bien utilisé |
| Session perdue | Cookies désactivés | Vérifier les paramètres de session PHP |
| 404 sur /login | Route non définie | Vérifier `Config/Routes.php` |

---

## 📚 Ressources

- [CodeIgniter 4 - Sessions](https://codeigniter.com/user_guide/libraries/sessions.html)
- [CodeIgniter 4 - Validation](https://codeigniter.com/user_guide/libraries/validation.html)
- [PHP - password_hash()](https://www.php.net/manual/en/function.password-hash.php)
- [OWASP - Authentication Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html)

---

**Dernière mise à jour** : 13 mai 2026  
**Auteur** : GitHub Copilot  
**Projet** : TechMada RH v1.0
