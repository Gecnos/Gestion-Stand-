# 🍽️ Projet Laravel – Plateforme de Gestion de Stands **"Eat&Drink"**

## 🎯 Objectif du Projet
Développer une plateforme web pour gérer l'événement culinaire **Eat&Drink**, où les exposants (entrepreneurs) peuvent s'inscrire, présenter leurs produits, et les visiteurs (participants) peuvent consulter les stands et passer commande.

---

## 👥 Répartition du Travail – 3 Développeurs

Ce projet est divisé en 3 parties **indépendantes mais complémentaires** :

---

### 🔹 Vianney – Authentification & Gestion des Rôles

#### 🎯 Objectif :
Mettre en place l’ossature du système : création de comptes, rôles, redirections, autorisations.

#### 🛠️ Tâches :
- Mise en place de l’auth Laravel (login/register/reset)
- Création des rôles (`admin`, `entrepreneur_en_attente`, `entrepreneur_approuve`)
- Middleware de sécurité selon rôle
- Page de suivi de statut pour `entrepreneur_en_attente`
- Dashboard admin : liste des demandes de stand
- Fonction d’approbation ou de rejet des entrepreneurs
- Seeder pour créer l'admin à la main

#### 📁 Dossiers principaux :
`app/Http/Middleware`, `routes/web.php`, `app/Models/User.php`, `resources/views/auth/`, `database/seeders/`

---

### 🔹 Feliciano – Gestion des Stands & Produits

#### 🎯 Objectif :
Créer tout le module pour les entrepreneurs **approuvés** : stands, produits, tableau de bord personnel.

#### 🛠️ Tâches :
- Création du modèle `Stand` lié à `User`
- Formulaire de création / édition de son propre stand
- CRUD complet des produits :
  - nom, description, prix, image
- Dashboard Entrepreneur : page "Mes Produits"
- Validation des formulaires (backend + front)

#### 📁 Dossiers principaux :
`app/Models/Stand.php`, `app/Models/Product.php`, `resources/views/entrepreneur/`, `routes/web.php`, `app/Http/Controllers/`

---

### 🔹 Credo – Vitrine Publique & Commandes

#### 🎯 Objectif :
Créer l’interface visiteur pour voir les stands, consulter les produits, et commander.

#### 🛠️ Tâches :
- Page publique : liste des stands approuvés
- Page de chaque stand : présentation + produits
- Système de panier (stocké en session)
- Soumission de commande (pas de paiement)
- Création du modèle `Commande`
- Admin : consultation des commandes par stand
- (Bonus) Envoi d’email à l’entrepreneur à chaque commande

#### 📁 Dossiers principaux :
`resources/views/public/`, `app/Models/Commande.php`, `routes/web.php`, `app/Http/Controllers/PublicController.php`

---

## 🧱 Stack Technique

- **Framework :** Laravel (v10+)
- **Langages :** PHP, Blade, JavaScript (jQuery ou Alpine), HTML/CSS
- **Base de Données :** SQLite (recommandé pour démarrer) ou MySQL
- **Outils :** Laravel Breeze/Fortify pour auth, Laravel Mail pour notification

---

## ✅ Étapes recommandées

1. **Initialisation commune du projet Laravel**
2. **Création d’un repo GitHub partagé**
3. **Branche par développeur ou par module**
4. **Revue de code régulière et tests**
5. **Fusion progressive vers la branche principale (`main` ou `dev`)**

---

## 🔔 Communication

Utilisez un fichier `README_MODULE.md` dans chaque sous-dossier ou une section dans le README global pour signaler :
- Avancement
- Décisions techniques
- Routes ou APIs disponibles
