ManagerIrcBot
=============

# Install

## Git

    git clone https://github.com/kosssi/ManagerIrcBot.git
    cd ManagerIrcBot

## Configuration

    cp app/config/parameters.yml.dist app/config/parameters.yml

Change configuration in app/config/parameters.yml

## Install dépendense

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

## Create database

    php app/console doctrine:database:create
    php app/console doctrine:schema:create

## Launch server dev

    curl -L http://github.com/downloads/benja-M-1/symfttpd/symfttpd.phar 2> /dev/null > symfttpd.phar
    php symfttpd.phar spawn -p 1872

## Test

    php app/console doctrine:database:create --env test
    php app/console doctrine:schema:create --env test
    phpunit -c app/


# TODO

* create tests
* launch irc with a good server and good channel
* add jQuery in composer
* create template
* create user manager
* update server status