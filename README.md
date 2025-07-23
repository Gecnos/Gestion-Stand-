
# 🍽️ Eat&Drink – Plateforme de Gestion de Stands

Projet Laravel 12 avec Vite.js pour la gestion d’un événement culinaire.  
Les entrepreneurs peuvent s’inscrire et proposer leurs produits.  
Les visiteurs peuvent explorer les stands et commander.  
L’admin gère l’ensemble via un back-office complet.

---

## 🚀 Objectifs du Projet

- Digitaliser un événement culinaire avec gestion des exposants, produits et commandes.
- Offrir une vitrine publique attractive pour les visiteurs.
- Simplifier la gestion via une interface admin centralisée.

---

## 🛠️ Stack Technique

- **Laravel 12**
- **Blade + Vite.js** (⚡ `npm run dev`)
- **MySQL**
- **Tailwind CSS**
- Authentification avec rôles & middlewares Laravel

---

## 👥 Répartition du Travail

### 🔹 Vianney – Chef de projet & Développeur Back / Interface Admin

- Authentification complète (register, login, reset)
- Système de rôles :
  - `admin`
  - `entrepreneur_en_attente`
  - `entrepreneur_approuve`
- Middleware de sécurité
- Dashboard Admin :
  - Gestion des demandes de stands
  - Approbation / Rejet des entrepreneurs
  - Vue des commandes
- Seeder d’utilisateur admin

### 🔹 Feliciano – Interface Entrepreneur

- Création & édition de son stand
- CRUD des produits :
  - nom, description, prix, image
- Dashboard personnel "Mes produits"
- Validation des formulaires

### 🔹 Credo – Vitrine Publique & Commandes

- Affichage public des stands approuvés
- Page stand + liste de produits
- Système de panier (session)
- Soumission de commande
- Enregistrement en base (modèle `Commande`)
- Notification email automatique à l’entrepreneur

## 🔐 Identifiants Admin par Défaut

```bash
Email : admin@eatdrink.com
Mot de passe : password
```

## 👨‍💻 Auteurs

* **Vianney** – Chef de projet, backend & interface admin
* **Feliciano** – Module entrepreneur
* **Credo** – Interface visiteur & commandes

