1. Un container de services est un objet dans lequel sont stockés tous les services du projet symfony. Son rôle est de donner accès à tous ces services n'importe où dans notre projet.

2. make:entity crée simplement une entité tandis que make:user crée une entité implémentant l'interface UserInterface

3. php bin/console doctrine:fixtures:load charge les fixtures dans la BDD

4. Semver est un moyen de nommer la version de son projet afin de savoir quelles ont été les modifications apportés au projet dans ladite version, notamment grâce aux mots clés MAJOR MINOR et PATCH
MAJOR signifie changements non rétrocompatibles, MINEUR ajout de fonctionnalités rétrocompatibles et PATCH des corrections de bugs.

5. Un repository est un objet PHP permettant d'envoyer des requetes à notre BDD, toutes nos requêtes sont alors centralisés dans une seule classe.

6. php bin/console debug:router permet de voir l'ensemble des routes du projet.

7. la variable globale app le permet

8. les 2 possibilités sont la migration avec php bin/console make:migration puis php bin/console doctrine:migrations:migrate et les schémas avec php bin/console doctrine:schema:update --dump-sql vérifiant les différences entre notre code et la BDD actuelle puis générant un script sql en conséquence et php bin/console doctrine:schema:update --force afin de mettre a jour la BDD via ce script 

9. php bin/console make:controller permet de créer un controller

10. Symfony Flex permet d'automatiser la configuration par défaut après l'installation ou suppression de nouvelles dépendances.
