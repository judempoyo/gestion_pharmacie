# PharmaGest - Système de Gestion de Pharmacie

PharmaGest est une solution moderne et intuitive pour la gestion complète d'une pharmacie. Développée en PHP avec une architecture MVC, elle offre des outils puissants pour le suivi des stocks, des ventes et des rapports d'activité.

## 🚀 Fonctionnalités Clés

- **📦 Gestion des Médicaments** : Catalogue complet avec suivi précis des quantités et des prix.
- **🕒 Suivi de Péremption** : Alertes automatiques pour les produits approchant de la date d'expiration.
- **💰 Enregistrement des Ventes** : Système de facturation rapide avec historique des transactions.
- **🤝 Gestion des Fournisseurs** : Suivi des commandes et réapprovisionnement simplifié.
- **📊 Rapports & Statistiques** : Tableaux de bord dynamiques et rapports exportables (CSV) pour analyser les performances.
- **🌗 Mode Sombre/Clair** : Interface utilisateur adaptative et moderne utilisant Tailwind CSS 4.

## 📋 Prérequis

- PHP 8.1 ou supérieur
- MySQL / MariaDB
- Composer
- Node.js & NPM (pour la compilation des styles)

## 🛠️ Installation

1. **Clonage du projet** :
   ```bash
   git clone <repository-url>
   cd gestion_pharmacie
   ```

2. **Installation des dépendances PHP** :
   ```bash
   composer install
   ```

3. **Installation des dépendances Frontend** :
   ```bash
   npm install
   ```

4. **Configuration de l'environnement** :
   - Copiez `.env.example` vers `.env`
   - Configurez vos accès base de données dans `.env`

5. **Initialisation de la base de données** :
   - Importez le fichier `schema.sql` dans votre base de données MySQL.

## 💻 Développement

Pour compiler les styles en temps réel pendant le développement :
```bash
npm run dev
```

Pour générer les styles optimisés pour la production :
```bash
npm run build
```

## 🌐 Serveur Local

Vous pouvez utiliser Apache ou le serveur intégré de PHP :
```bash
php -S localhost:8000 -t public
```

## 📄 Licence

Ce projet est la propriété de **Jude Mpoyo**. Tous droits réservés.
