# Docker Drupal Dev Env Automator

This was created to automate setting up a Drupal development environment working with a project structure as hosted by Acquia.  
Replace "PROJECT" with actual Acquia Drupal project name
Replace "DOMAIN" with actual Acquia domain as applicable
Replace "PATH" with actual Acquia path as applicable

To use the project to set up a Drupal dev env, you will need to do the following:

1. Install Docker + Docker Compose
1. Get an Acquia cloud account if you don't have one
1. Create an SSH key to use with Acquia and set up in Acquia cloud (if you haven't already)
1. Clone this repo and cd into resulting dir:  **docker-drupal-dev**
1. Clone the PROJECT codebase from Acquia into /docker-drupal-dev, result: /docker-drupal-dev/**PROJECT**
    1. `git clone PROJECT@DOMAIN:PROJECT.git`
1. Get DB backup from Acquia
    1. ssh in to view backups `ssh PROJECT@DOMAIN` 
    1. and `ls -l PATH/backups`
    1. exit out noting backup file name and scp it down: 
       `scp PROJECT@PROJECT.DOMAIN:PATH/_enter-file-name-here_.gz .`
    1. unzip and rename so you have this exact file name and place in init dir: /docker-drupal-dev/init/**prod-PROJECT.sql**
    1. the docker will install this sql file into the MySql container provided file name in docker-compose.yml matches the file
1. Get non git tracked web asset files dir from Acquia
    1. ssh in `ssh PROJECT@PROJECT.DOMAIN` 
       and cd to PATH `cd PATH`
    1. tar up the files `tar -zcvf files.tar.gz sites/default/files`
    1. exit out and scp the files archive down so you have: /docker-drupal-dev/**files.tar.gz**
       `scp PROJECT@PROJECT.DOMAIN:PATH/files.tar.gz .`
    1. extract the files archive into the Drupal project: /docker-drupal-dev/PROJECT/docroot/sites/default/**files**
    1. open up access on the files dir (created in previous step) to allow full rwx (chmod 777)
1. Make settings.local.php (and tweak settings if needed) from the example copy, and copy into docroot/sites/default in PROJECT
   result: /docker-drupal-dev/PROJECT/docroot/sites/default/**settings.local.php**
1. When all steps above are complete, run this to build and start the environment: `docker-compose up -d`

When docker-compose build completes you should have 2 containers, one which provides the MySql functionality and one which will run PHP, forwarding port 443 so your host browser should be able to hit the PROJECT Drupal login page via localhost:

First hit the update page (and click continue button) as this initializes the DB:
https://localhost/update.php

Then log in to drupal admin (this assumes you have a login in the Acquia env from which you got the DB backup)
https://localhost/user/login

Make code changes as needed in the PROJECT codebase by editing files via your host code editor and/or running composer commands.  Test changes against the Drupal instance running on the containerized test environment, then create a branch to push up to Acquia to test in Acquia hosted Drupal environments.

For those unfamiliar with Docker / Docker Compose:

* View info/status on running containers: `docker ps`
* To ssh into one of the containers, get the container name, then:  `docker exec -it [CONTAINER_NAME] /bin/bash`
* Stop containers:  `docker-compose stop`
* Start containers: `docker-compose up -d`
