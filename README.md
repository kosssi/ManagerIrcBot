ManagerIrcBot
=============

= Install =

== Git ==

    git clone https://github.com/kosssi/ManagerIrcBot.git
    cd ManagerIrcBot

== Configuration ==

    cp app/config/parameters.yml.dist app/config/parameters.yml

Change configuration in app/config/parameters.yml

== Create database ==

    php app/console doctrine:database:create
    php app/console doctrine:schema:create

== Install dépendense ==

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

== Launch server dev ==

    curl -L http://github.com/downloads/benja-M-1/symfttpd/symfttpd.phar 2> /dev/null > symfttpd.phar
    php symfttpd.phar spawn -p 1872