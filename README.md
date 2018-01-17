# ApiSecurityScan
Projet Hackaton 2


## Installation de l'environnement Back 
Via docker compose, lancer la commande

````
docker-compose up --build
````

Connection au container php
````
docker-compose exec php bash
composer create-project --prefer-dist laravel/laravel backSecurityScan
````