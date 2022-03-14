# Cheminement du projet

1. Setup du projet (front)
2. Réalisation du DB en SQL
3. Mis en place une connexion à la BDD (includes/db.php)
4. Configuré des variables d'environnement
5. Mise en place de l'inscription user
6. Mise en place de la connexion user : Vérifier que l'username existe et récupérer ses infos(**requête préparée** avec un **fetch** à la fin) -> Comparer le mot de passe obtenu dans la ligne de la BDD avec celui tapé dans le formulaire (fonction **password_verify()**) -> si c'est valide : créer une variable de session avec le username à l'intérieur
   -- Nous sommes ici--
7. Création de produits
8. Affichage des produits
9. Affichage d'un produit unique
10. Modification d'un produit
11. Suppression d'un produit
12. Factorisation/Améliorations

## Propositions d'améliorations

- Créer un système de catégories pour les produits
- Mettre en place un système de gestion de stocks
- Soigner l'UX/UI (Messages d'erreur pour les utilisateurs)
- En se basant sur le projet ledger, réaliser un export CSV de tous les produits présents dans la BDD
- Transformer les opérations CRUD en fonctions
- Mettre en place un système d'imputation des modifications ("C'est l'utilisateur xxx qui a modifié le fichier dernièrement")
- Déployer le projet en ligne avec [AlwaysData](https://www.alwaysdata.com/fr/) ou[WebHost](https://fr.000webhost.com/)
