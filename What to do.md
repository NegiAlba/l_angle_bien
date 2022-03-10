# Cheminement du projet

1. Setup du projet (front)
2. Réalisation du DB en SQL
3. Mis en place une connexion à la BDD (includes/db.php)
4. Configuré des variables d'environnement
5. Mise en place de l'inscription user
   -- Nous sommes ici--
6. Mise en place de la connexion user : Vérifier que l'username existe et récupérer ses infos(**requête préparée** avec un **fetch** à la fin) -> Comparer le mot de passe obtenu dans la ligne de la BDD avec celui tapé dans le formulaire (fonction **password_verify()**) -> si c'est valide : créer une variable de session avec le username à l'intérieur
7. Création de produits
8. Affichage des produits
9. Affichage d'un produit unique
10. Modification d'un produit
11. Suppression d'un produit
12. Factorisation/Améliorations
