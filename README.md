# Bilmo_API
Projet 7 du parcours développeur d'application PHP/Symfony chez OpenClassrooms : Créez un web service exposant une API

Réalisé en PHP 7.2 et Symfony 5.4.7

Installer l'application

- Clonez le repository GitHub

- Configurez vos variables d'environnement dans le fichier .env :    
  
  => DATABASE_URL=mysql://root:root@127.0.0.1:3306/bilemo?serverVersion=5.7 pour la base de données
  
- Téléchargez et installez les dépendances du projet avec la commande Composer suivante : composer install

- Créez la base de données en utilisant la commande suivante : php bin/console doctrine:database:create

- Créez la structure de la base de données en utilisant la commande : php bin/console doctrine:migrations:migrate

- Installer les fixtures pour avoir un jeu de données fictives avec la commande suivante : php bin/console doctrine:fixtures:load

Genérer les clés SSH
- mkdir config/jwt

- openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 
 
- openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Lancer L'application
- Lancez le serveur à l'aide de la commande suivante : symfony serve 

- Vous pouvez désormais commencer à utiliser l'appication Bilemo sur http://localhost:8000/api

- Vous pouvez effectuer Des requetes HTTP à l'aide du logiciel Postman  

Documentation API

http://localhost:8000/api



Authentification

L’authentification est obligatoire pour accéder à l’ensemble des fonctionnalités de l’API

Pour s’authentifier :

POST /api/login_check

Les détails du login devront être envoyés en format JSON. L’ensemble des champs (username, password) est obligatoire. L’username correspond en fait à l’email du client.

Exemple :

{ 
    "username": "free@gmail.com", 
    "password": "admin"
}

L’authentification nous permet de récupérer un token, qu’il faudra transmettre à chaque requête, en type Bearer Token.



Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise !
