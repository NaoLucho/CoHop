# Sitebuilder #

Site de base pour créer de nouveaux site.
Aujourd'hui utiliser les submodules pour les bundles:
Builder/FormBundle
Builder/PageBundle
Builder/ListBundle

Ce projet doit récupérer les évolutions communes des autres projets qui l'utilisent.

note: améliorer la gestion des bundles en utilisant packagist au lieu des submodules git.


Projet Co-Hop
git@github.com:NaoLucho/CoHop.git
https://github.com/NaoLucho/CoHop.git


Tuto installer un sitebuilder existant

Soit depuis git (mieux) soit depuis la copie du folder.
git clone https://github.com/NaoLucho/symf-builder2.git <SITENAME>
cd SITENAME
git submodule update --init
git config --global status.submoduleSummary true
Composer install (or update)
Créer parameter.yml si non existant, avec les configs db et site path project_name

¨Pour la base de donnée l’idéal est de récupérer un dump de la base en cours d’usage, sinon il faut la recréer:
bin/console doctrine:database:create
bin/console d:s:u --dump-sql -f
bin/console fos:user:create admin louis.watrin@gmail.com pass --super-admin
Manuellement dans l’admin: Group All avec Role_User
Fixtures: php bin/console importlog:csv initwebsite.csv dev


Pour CKEDITOR:

php bin/console ckeditor:install => Ne pas faire, écrase le vendor egeloen/ckeditor-bundle !
php bin/console assets:install


php bin/console assetic:dump => met à jour les JS et CSS